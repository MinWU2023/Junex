<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class FrontLangCheckCommand extends Command
{
    protected $signature = 'front:lang-check {locale=es}';

    protected $description = 'Diagnose front JSON translations (locale file + __() sample keys)';

    public function handle(): int
    {
        $locale = strtolower(trim((string)$this->argument('locale')));
        $path = resource_path('lang/' . $locale . '.json');

        $this->line('app.locale (before) = ' . app()->getLocale());
        $this->line('langPath = ' . (method_exists(app(), 'langPath') ? app()->langPath() : resource_path('lang')));
        $this->line('json path = ' . $path);
        $this->line('json exists = ' . (is_file($path) ? 'YES' : 'NO'));
        if (is_file($path)) {
            $this->line('json size = ' . filesize($path) . ' bytes');
            $this->line('json mtime = ' . date('Y-m-d H:i:s', filemtime($path)));
            $decoded = json_decode((string)file_get_contents($path), true);
            $this->line('json valid = ' . (is_array($decoded) ? 'YES' : 'NO'));
            $this->line('json keys = ' . (is_array($decoded) ? count($decoded) : 0));
        }

        App::setLocale($locale);
        if (app()->bound('translator')) {
            app('translator')->setLocale($locale);
        }

        $keys = [
            'Share',
            'New Blog',
            'Home',
            'Blogs',
            'Previous Post',
            'Next Post',
            'LEAVE A MESSAGE',
            'Product Tags',
            'Categories',
            'What Are You Looking For?',
        ];

        $this->newLine();
        $this->info('__() samples @ locale=' . app()->getLocale());
        foreach ($keys as $key) {
            $val = __($key);
            $ok = $val !== $key;
            $this->line(($ok ? '[OK]  ' : '[MISS]') . ' ' . $key . ' => ' . $val);
        }

        return 0;
    }
}
