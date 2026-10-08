<?php

namespace App\Services;

use App\Modules\Inquiry\Models\Inquiry;
use App\Modules\Inquiry\Models\InquiryAttachment;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InquiryAttachmentService
{
    public const MAX_FILES = 5;
    public const MAX_SIZE_KB = 10240; // 10MB

    public const ALLOWED_EXTENSIONS = [
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
        'png', 'jpg', 'jpeg', 'gif', 'webp', 'bmp',
        'zip', 'rar', '7z',
        'txt', 'csv',
    ];

    /**
     * Validation rules fragment for controllers.
     *
     * @return array<string, mixed>
     */
    public static function validationRules(): array
    {
        return [
            'attachments' => ['nullable', 'array', 'max:' . self::MAX_FILES],
            'attachments.*' => [
                'file',
                'max:' . self::MAX_SIZE_KB,
            ],
        ];
    }

    /**
     * @return array<int, UploadedFile>
     */
    public function collectUploadedFiles(Request $request): array
    {
        $files = $request->file('attachments', []);
        if ($files instanceof UploadedFile) {
            $files = [$files];
        }
        if (!is_array($files)) {
            return [];
        }

        return array_values(array_filter($files, static function ($file) {
            return $file instanceof UploadedFile && $file->isValid();
        }));
    }

    /**
     * Persist uploaded files for an inquiry.
     *
     * @param array<int, UploadedFile>|null $files
     * @return array<int, InquiryAttachment>
     */
    public function storeForInquiry(Inquiry $inquiry, ?array $files = null, ?Request $request = null): array
    {
        if ($files === null && $request) {
            $files = $this->collectUploadedFiles($request);
        }
        $files = $files ?? [];

        if (count($files) > self::MAX_FILES) {
            throw ValidationException::withMessages([
                'attachments' => ['You can upload up to ' . self::MAX_FILES . ' files.'],
            ]);
        }

        foreach ($files as $file) {
            $this->assertAllowedFile($file);
        }

        $saved = [];
        foreach ($files as $file) {
            $attachment = $this->storeOne($inquiry, $file);
            if ($attachment) {
                $saved[] = $attachment;
            }
        }

        return $saved;
    }

    public function assertAllowedFile(UploadedFile $file): void
    {
        $extension = strtolower((string)$file->getClientOriginalExtension());
        if ($extension === '' || !in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw ValidationException::withMessages([
                'attachments' => ['Unsupported file type: ' . ($extension ?: 'unknown') . '. Allowed: ' . implode(', ', self::ALLOWED_EXTENSIONS)],
            ]);
        }
        if ((int)$file->getSize() > self::MAX_SIZE_KB * 1024) {
            throw ValidationException::withMessages([
                'attachments' => ['Each file must be smaller than 10MB.'],
            ]);
        }
    }

    public function storeOne(Inquiry $inquiry, UploadedFile $file): ?InquiryAttachment
    {
        $this->assertAllowedFile($file);
        $extension = strtolower((string)$file->getClientOriginalExtension());

        $folder = 'storage/uploads/inquiry/' . date('Ym/d');
        $uploadPath = public_path($folder);
        if (!is_dir($uploadPath) && !mkdir($uploadPath, 0755, true) && !is_dir($uploadPath)) {
            Log::error('Failed to create inquiry upload directory', ['path' => $uploadPath]);
            throw ValidationException::withMessages([
                'attachments' => ['Upload failed, please try again later.'],
            ]);
        }

        $originalName = (string)$file->getClientOriginalName();
        $safeBase = pathinfo($originalName, PATHINFO_FILENAME);
        $safeBase = Str::slug($safeBase) ?: 'file';
        $storedName = $safeBase . '_' . time() . '_' . Str::random(6) . '.' . $extension;

        if (!$file->move($uploadPath, $storedName)) {
            throw ValidationException::withMessages([
                'attachments' => ['Failed to save attachment: ' . $originalName],
            ]);
        }

        $relativePath = $folder . '/' . $storedName;
        $abs = public_path($relativePath);
        $size = is_file($abs) ? (int)filesize($abs) : (int)$file->getSize();

        return InquiryAttachment::create([
            'inquiry_id' => $inquiry->id,
            'original_name' => mb_substr($originalName, 0, 255),
            'stored_name' => $storedName,
            'path' => $relativePath,
            'mime' => (string)($file->getClientMimeType() ?: ''),
            'extension' => $extension,
            'size' => $size,
        ]);
    }
}
