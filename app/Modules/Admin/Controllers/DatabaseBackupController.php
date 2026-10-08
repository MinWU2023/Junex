<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\DatabaseBackup;
use App\Modules\Common\Collections\CommonResourceCollection;
use App\Modules\Common\Controllers\BaseController;
use App\Services\DatabaseBackupService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DatabaseBackupController extends BaseController
{
    public function __construct(DatabaseBackup $databaseBackup)
    {
        $this->modelName = 'DatabaseBackup';
        $this->model = $databaseBackup;
        $this->viewPath = 'Admin.Views.DatabaseBackup';
        $this->orderBy = 'created_at';
    }

    public function index()
    {
        $request = request();
        $status = $request->get('status');
        $type = $request->get('type');

        if ($request->ajax() || $request->wantsJson()) {
            $data = tap($this->model->orderByDesc($this->orderBy), function ($query) use ($status, $type) {
                if ($status) {
                    $query->where('status', $status);
                }
                if ($type) {
                    $query->where('type', $type);
                }
            })->paginate($request->input('limit', 15));

            return new CommonResourceCollection($data);
        }

        return view($this->viewPath . '.index', compact('status', 'type'));
    }

    public function store(Request $request)
    {
        @set_time_limit(0);

        /** @var DatabaseBackupService $service */
        $service = app(DatabaseBackupService::class);
        $record = $service->backup('manual');

        if ($record->status !== 'success') {
            return $this->badRequest($record->message ?: '备份失败');
        }

        return $this->data([
            'id' => $record->id,
            'filename' => $record->filename,
            'file_size_human' => $record->file_size_human,
        ], 0, '手动全量备份成功');
    }

    public function download($id): BinaryFileResponse
    {
        /** @var DatabaseBackup $backup */
        $backup = DatabaseBackup::query()->findOrFail($id);

        if (!$backup->fileExists()) {
            abort(404, '备份文件不存在');
        }

        return response()->download($backup->absolutePath(), $backup->filename);
    }

    public function restore($id)
    {
        @set_time_limit(0);

        /** @var DatabaseBackup $backup */
        $backup = DatabaseBackup::query()->findOrFail($id);
        $result = app(DatabaseBackupService::class)->restore($backup);

        if (empty($result['ok'])) {
            return $this->badRequest($result['message'] ?? '恢复失败');
        }

        $safety = $result['safety_backup'] ?? null;

        return $this->data([
            'safety_backup' => $safety ? $safety->filename : null,
        ], 0, $result['message'] ?? '恢复成功');
    }

    public function destroy($id)
    {
        /** @var DatabaseBackup $backup */
        $backup = DatabaseBackup::query()->findOrFail($id);
        app(DatabaseBackupService::class)->deleteBackup($backup);

        return $this->success();
    }
}
