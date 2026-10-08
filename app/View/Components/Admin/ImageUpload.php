<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class ImageUpload extends Component
{
    public string $label;

    public string $name;

    /** @var string|array|null */
    public $value;

    public bool $multiple;

    public int $max;

    public bool $required;

    public bool $limit;

    public bool $watermark;

    public string $uploadType;

    public bool $album;

    public string $uid;

    public string $accept;

    public string $hint;

    /**
     * @param  string|array|null  $value  单图为路径字符串，多图为路径数组
     * @param  bool|string|int  $multiple
     * @param  bool|string|int  $required
     * @param  bool|string|int  $limit
     * @param  bool|string|int  $watermark
     * @param  bool|string|int  $album
     */
    public function __construct(
        string $label,
        string $name,
        $value = null,
        $multiple = false,
        int $max = 1,
        $required = false,
        $limit = true,
        $watermark = true,
        string $uploadType = 'system',
        $album = true,
        string $accept = '',
        string $hint = ''
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->multiple = filter_var($multiple, FILTER_VALIDATE_BOOLEAN);
        $this->max = max(1, (int)$max);
        if (!$this->multiple) {
            $this->max = 1;
        }
        $this->required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
        $this->limit = filter_var($limit, FILTER_VALIDATE_BOOLEAN);
        $this->watermark = filter_var($watermark, FILTER_VALIDATE_BOOLEAN);
        $this->uploadType = $uploadType;
        $this->album = filter_var($album, FILTER_VALIDATE_BOOLEAN);
        $this->accept = $accept !== ''
            ? $accept
            : 'image/jpeg,image/png,image/gif,image/webp,image/bmp,image/svg+xml,.jpg,.jpeg,.png,.gif,.webp,.bmp,.svg';
        $this->hint = $hint !== ''
            ? $hint
            : __('支持 jpg / jpeg / png / gif / webp / bmp / svg，可拖拽上传');
        $this->uid = 'aui_' . substr(md5($name . microtime(true) . mt_rand()), 0, 12);

        if ($this->multiple) {
            if (is_string($value) && $value !== '') {
                $decoded = json_decode($value, true);
                $this->value = is_array($decoded) ? $decoded : preg_split('/\s*,\s*/', $value);
            } elseif (is_array($value)) {
                $this->value = $value;
            } else {
                $this->value = [];
            }
            $this->value = array_values(array_filter(array_map(static function ($item) {
                return is_string($item) ? trim($item) : '';
            }, $this->value), static function ($item) {
                return $item !== '';
            }));
        } else {
            $this->value = is_string($value) ? trim($value) : '';
        }
    }

    public function render()
    {
        return view('components.admin.image-upload');
    }
}
