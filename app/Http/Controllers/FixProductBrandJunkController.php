<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * 浏览器可访问：产品详情品牌 HTML 修复工具。
 *
 * 清理误译标签（JUNIO / about-us 蓝链）：
 *   /fix_product_junio  预览；?apply=1 写库
 *
 * 为西班牙语段落开头 JUNEX 添加 about-us 深蓝链接：
 *   /fix_product_junex_link  预览；?apply=1 写库
 *
 * 可选口令（.env 设置 FIX_TOOL_TOKEN=xxx 后）：?token=xxx
 */
class FixProductBrandJunkController extends Controller
{
    /** @var array<int, string> */
    protected array $fields = [
        'content',
        'brief_content',
        'm_content',
        'product_details',
        'description',
        'content_1',
        'content_2',
        'content_3',
        'content_4',
        'content_5',
        'content_6',
        'content_7',
        'content_8',
        'content_9',
        'content_10',
        'name',
        'title',
        'keywords',
    ];

    public function __invoke(Request $request)
    {
        $this->assertFixToolToken($request);

        $apply = filter_var($request->query('apply', false), FILTER_VALIDATE_BOOLEAN);
        $table = 'product_translations';
        if (!Schema::hasTable($table)) {
            return response('<pre>table missing: product_translations</pre>', 500)
                ->header('Content-Type', 'text/html; charset=UTF-8');
        }

        $columns = Schema::getColumnListing($table);
        $fields = array_values(array_filter($this->fields, static function ($f) use ($columns) {
            return in_array($f, $columns, true);
        }));

        $query = DB::table($table)->orderBy('id');
        $query->where(function ($outer) use ($fields) {
            foreach ($fields as $i => $field) {
                $method = $i === 0 ? 'where' : 'orWhere';
                $outer->{$method}(function ($w) use ($field) {
                    $w->where($field, 'like', '%JUNIO%')
                        ->orWhere($field, 'like', '%junio%')
                        ->orWhere($field, 'like', '%about-us%')
                        // 上次替换后可能残留「JUNEX JUNEX」
                        ->orWhere($field, 'like', '%JUNEX JUNEX%')
                        ->orWhere($field, 'like', '%JUNEX&nbsp;JUNEX%')
                        ->orWhere($field, 'like', '%Junex Junex%');
                });
            }
        });

        $rows = $query->get(array_merge(['id', 'product_id', 'locale'], $fields));
        $report = [];
        $changedRows = 0;
        $changedFields = 0;

        foreach ($rows as $row) {
            $updates = [];
            $samples = [];
            foreach ($fields as $field) {
                $original = (string)($row->{$field} ?? '');
                if ($original === '') {
                    continue;
                }
                if (!$this->looksDirty($original)) {
                    continue;
                }
                $cleaned = $this->cleanHtml($original);
                if ($cleaned === $original) {
                    continue;
                }
                $updates[$field] = $cleaned;
                $samples[$field] = [
                    'before' => $this->excerpt($original),
                    'after' => $this->excerpt($cleaned),
                ];
            }

            if ($updates === []) {
                continue;
            }

            $changedRows++;
            $changedFields += count($updates);
            $report[] = [
                'id' => (int)$row->id,
                'product_id' => (int)$row->product_id,
                'locale' => (string)$row->locale,
                'fields' => array_keys($updates),
                'samples' => $samples,
            ];

            if ($apply) {
                DB::table($table)->where('id', $row->id)->update($updates);
            }
        }

        $html = $this->renderReport($apply, $rows->count(), $changedRows, $changedFields, $report);

        return response($html, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    protected function looksDirty(string $html): bool
    {
        return (bool)preg_match('/JUNIO|junio|about-us|JUNEX(?:\s|&nbsp;)+JUNEX/i', $html);
    }

    protected function cleanHtml(string $html): string
    {
        $patterns = [
            // 用户报的结构：font-size 18px + strong + about-us 链接 + 蓝色 JUNIO/JUNEX
            '/<span\s+style=["\'][^"\']*font-size:\s*18px;?[^"\']*["\']\s*>\s*<strong>\s*<a\s+[^>]*href=["\'][^"\']*about-us[^"\']*["\'][^>]*>\s*<span\s+style=["\'][^"\']*color:\s*#3598db;?[^"\']*["\']\s*>\s*(?:JUNIO|JUNEX|Junio|Junex)\s*<\/span>\s*<\/a>\s*<\/strong>\s*<\/span>/iu',
            // 更宽松：任意外层 span/strong 包着 about-us 链 + JUNIO/JUNEX
            '/<span[^>]*>\s*<strong>\s*<a\s+[^>]*href=["\'][^"\']*about-us[^"\']*["\'][^>]*>\s*<span[^>]*>\s*(?:JUNIO|JUNEX|Junio|Junex)\s*<\/span>\s*<\/a>\s*<\/strong>\s*<\/span>/iu',
            // 仅 a>span 结构
            '/<a\s+[^>]*href=["\'][^"\']*about-us[^"\']*["\'][^>]*>\s*<span[^>]*>\s*(?:JUNIO|JUNEX|Junio|Junex)\s*<\/span>\s*<\/a>/iu',
            // 仅 about-us 链接文字为 JUNIO/JUNEX
            '/<a\s+[^>]*href=["\'][^"\']*about-us[^"\']*["\'][^>]*>\s*(?:JUNIO|JUNEX|Junio|Junex)\s*<\/a>/iu',
        ];

        $out = $html;
        foreach ($patterns as $pattern) {
            // 在结尾修饰符前插入 lookahead：后面已有 JUNEX 明文则只删标签
            $patternDrop = preg_replace('#/([imsxuADSUXJ]*)$#', '(?=\s*(?:&nbsp;|\x{00A0})?\s*(?:JUNEX|Junex)\b)/$1', $pattern) ?: $pattern;
            $out = preg_replace($patternDrop, '', $out) ?? $out;
            // 否则保留一个明文品牌名
            $out = preg_replace($pattern, 'JUNEX', $out) ?? $out;
        }

        // 残留误译品牌词（非品牌名上下文尽量只替换独立词）
        $out = preg_replace('/\bJUNIO\b/u', 'JUNEX', $out) ?? $out;
        $out = preg_replace('/\bJunio\b/u', 'JUNEX', $out) ?? $out;

        // 合并连续重复品牌：JUNEX JUNEX / JUNEX&nbsp;JUNEX / Junex Junex → JUNEX
        $out = preg_replace('/\bJUNEX(?:\s|&nbsp;|\x{00A0})+(?:JUNEX\b)/iu', 'JUNEX', $out) ?? $out;
        // 多轮叠词（JUNEX JUNEX JUNEX）
        for ($i = 0; $i < 3; $i++) {
            $next = preg_replace('/\bJUNEX(?:\s|&nbsp;|\x{00A0})+(?:JUNEX\b)/iu', 'JUNEX', $out) ?? $out;
            if ($next === $out) {
                break;
            }
            $out = $next;
        }

        // 清理可能出现的连续空格（不碰标签内）
        $out = preg_replace('/[ \t]{2,}/', ' ', $out) ?? $out;

        return $out;
    }

    protected function excerpt(string $text, int $max = 220): string
    {
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;
        if (mb_strlen($text) <= $max) {
            return $text;
        }

        return mb_substr($text, 0, $max) . '…';
    }

    /**
     * @param  array<int, array<string, mixed>>  $report
     */
    protected function renderReport(bool $apply, int $scanned, int $changedRows, int $changedFields, array $report): string
    {
        $mode = $apply ? 'APPLY（已写库）' : 'DRY-RUN（仅预览，未写库）';
        $applyUrl = url('/fix_product_junio') . '?apply=1';
        $token = trim((string)env('FIX_TOOL_TOKEN', ''));
        if ($token !== '') {
            $applyUrl .= '&token=' . rawurlencode($token);
        }

        $lines = [];
        $lines[] = '<!doctype html><html><head><meta charset="utf-8"><title>Fix JUNIO product content</title>';
        $lines[] = '<style>body{font:14px/1.5 -apple-system,BlinkMacSystemFont,Segoe UI,sans-serif;padding:20px;max-width:1100px;margin:0 auto;background:#f7f7f7;color:#222}';
        $lines[] = 'h1{font-size:20px} .box{background:#fff;border:1px solid #ddd;border-radius:8px;padding:14px 16px;margin:12px 0}';
        $lines[] = '.ok{color:#0a7} .warn{color:#c60} .err{color:#c00} code,pre{background:#f0f0f0;padding:2px 4px;border-radius:4px;white-space:pre-wrap;word-break:break-word}';
        $lines[] = 'a.btn{display:inline-block;background:#16a291;color:#fff;padding:8px 14px;border-radius:6px;text-decoration:none;margin-right:8px}';
        $lines[] = 'table{width:100%;border-collapse:collapse} td,th{border:1px solid #e5e5e5;padding:8px;vertical-align:top;font-size:12px} th{background:#fafafa}</style></head><body>';
        $lines[] = '<h1>清理产品详情误译品牌标签（JUNIO / about-us 蓝链）</h1>';
        $lines[] = '<div class="box"><strong>模式：</strong><span class="' . ($apply ? 'err' : 'warn') . '">' . htmlspecialchars($mode) . '</span><br>';
        $lines[] = '扫描命中行：' . (int)$scanned . '　将修改行：' . (int)$changedRows . '　字段变更：' . (int)$changedFields . '<br>';
        $lines[] = '规则：去掉 about-us 蓝链 HTML → 明文 <code>JUNEX</code>；JUNIO→JUNEX；连续 <code>JUNEX JUNEX</code>（含 &amp;nbsp;）合并为单个 <code>JUNEX</code>。';
        $lines[] = '</div>';

        if (!$apply) {
            $lines[] = '<div class="box">';
            $lines[] = '<a class="btn" href="' . htmlspecialchars($applyUrl) . '">确认写库 apply=1</a>';
            $lines[] = '<a class="btn" style="background:#666" href="' . htmlspecialchars(url('/fix_product_junio')) . '">重新预览</a>';
            $lines[] = '</div>';
        } else {
            $lines[] = '<div class="box ok">已写回数据库。请刷新产品详情页检查。用完请删除本工具路由或设置 FIX_TOOL_TOKEN。</div>';
        }

        if ($report === []) {
            $lines[] = '<div class="box ok">没有需要修改的记录。</div>';
        } else {
            $lines[] = '<div class="box"><table><thead><tr><th>translation_id</th><th>product_id</th><th>locale</th><th>fields</th><th>before → after</th></tr></thead><tbody>';
            foreach ($report as $item) {
                $sampleHtml = '';
                foreach ($item['samples'] as $field => $pair) {
                    $sampleHtml .= '<div><strong>' . htmlspecialchars((string)$field) . '</strong><br>';
                    $sampleHtml .= '<span class="err">B:</span> ' . htmlspecialchars((string)$pair['before']) . '<br>';
                    $sampleHtml .= '<span class="ok">A:</span> ' . htmlspecialchars((string)$pair['after']) . '</div><hr>';
                }
                $lines[] = '<tr>';
                $lines[] = '<td>' . (int)$item['id'] . '</td>';
                $lines[] = '<td>' . (int)$item['product_id'] . '</td>';
                $lines[] = '<td>' . htmlspecialchars((string)$item['locale']) . '</td>';
                $lines[] = '<td>' . htmlspecialchars(implode(', ', $item['fields'])) . '</td>';
                $lines[] = '<td>' . $sampleHtml . '</td>';
                $lines[] = '</tr>';
            }
            $lines[] = '</tbody></table></div>';
        }

        $lines[] = '</body></html>';

        return implode("\n", $lines);
    }

    /**
     * 为 product_translations.content 中西班牙语段落开头的 JUNEX 添加 about-us 链接。
     */
    public function linkJunexAbout(Request $request)
    {
        $this->assertFixToolToken($request);

        $apply = filter_var($request->query('apply', false), FILTER_VALIDATE_BOOLEAN);
        $field = 'content';
        $marker = 'JUNEX es un fabricante profesional de ropa deportiva especializado en yoga';
        $linkColor = '#0284c7';
        $table = 'product_translations';

        if (!Schema::hasTable($table) || !in_array($field, Schema::getColumnListing($table), true)) {
            return response('<pre>table/column missing: product_translations.' . $field . '</pre>', 500)
                ->header('Content-Type', 'text/html; charset=UTF-8');
        }

        $query = DB::table($table)
            ->orderBy('id')
            ->where($field, 'like', '%' . $marker . '%');

        $locale = trim((string)$request->query('locale', 'es'));
        if ($locale !== '') {
            $query->where('locale', $locale);
        }

        $rows = $query->get(['id', 'product_id', 'locale', $field]);
        $report = [];
        $changedRows = 0;

        foreach ($rows as $row) {
            $original = (string)($row->{$field} ?? '');
            if ($original === '' || !$this->junexLinkNeedsApply($original, $marker)) {
                continue;
            }

            $updated = $this->linkifyLeadingJunex($original, $marker, $linkColor);
            if ($updated === $original) {
                continue;
            }

            $changedRows++;
            $report[] = [
                'id' => (int)$row->id,
                'product_id' => (int)$row->product_id,
                'locale' => (string)$row->locale,
                'before' => $this->excerpt($original, 260),
                'after' => $this->excerpt($updated, 260),
            ];

            if ($apply) {
                DB::table($table)->where('id', $row->id)->update([$field => $updated]);
            }
        }

        $html = $this->renderJunexLinkReport($apply, $rows->count(), $changedRows, $report, $locale, $linkColor);

        return response($html, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    protected function assertFixToolToken(Request $request): void
    {
        $expectedToken = trim((string)env('FIX_TOOL_TOKEN', ''));
        if ($expectedToken === '') {
            return;
        }

        $token = (string)$request->query('token', '');
        if (!hash_equals($expectedToken, $token)) {
            abort(403, 'Invalid token');
        }
    }

    protected function junexLinkNeedsApply(string $html, string $marker): bool
    {
        if (mb_stripos($html, $marker) === false) {
            return false;
        }

        if (preg_match('/<a\s[^>]*href=["\'][^"\']*about-us[^"\']*["\'][^>]*>\s*<span[^>]*>\s*JUNEX\s*<\/span>\s*<\/a>\s+es un fabricante profesional/iu', $html)) {
            return false;
        }

        if (preg_match('/<a\s[^>]*href=["\'][^"\']*about-us[^"\']*["\'][^>]*>\s*JUNEX\s*<\/a>\s+es un fabricante profesional/iu', $html)) {
            return false;
        }

        return true;
    }

    protected function linkifyLeadingJunex(string $html, string $marker, string $linkColor): string
    {
        $markerPos = mb_stripos($html, $marker);
        if ($markerPos === false) {
            return $html;
        }

        $prefix = mb_substr($html, 0, $markerPos);
        $suffix = mb_substr($html, $markerPos + 5);

        $tail = mb_substr($prefix, -300);
        if (preg_match('/<a\s[^>]*href=["\'][^"\']*about-us[^"\']*["\'][^>]*>\s*(?:<span[^>]*>\s*)?$/iu', $tail)
            || preg_match('/^\s*<\/span>\s*<\/a>/iu', $suffix)
        ) {
            return $html;
        }

        $link = '<a href="/about-us"><span style="color:' . $linkColor . ';">JUNEX</span></a>';

        return $prefix . $link . $suffix;
    }

    /**
     * @param  array<int, array<string, mixed>>  $report
     */
    protected function renderJunexLinkReport(bool $apply, int $scanned, int $changedRows, array $report, string $locale, string $linkColor): string
    {
        $mode = $apply ? 'APPLY（已写库）' : 'DRY-RUN（仅预览，未写库）';
        $applyUrl = url('/fix_product_junex_link') . '?apply=1&locale=' . rawurlencode($locale);
        $previewUrl = url('/fix_product_junex_link') . '?locale=' . rawurlencode($locale);
        $token = trim((string)env('FIX_TOOL_TOKEN', ''));
        if ($token !== '') {
            $applyUrl .= '&token=' . rawurlencode($token);
            $previewUrl .= '&token=' . rawurlencode($token);
        }

        $linkPreview = '<a href="/about-us"><span style="color:' . $linkColor . ';">JUNEX</span></a>';

        $lines = [];
        $lines[] = '<!doctype html><html><head><meta charset="utf-8"><title>Fix JUNEX about-us link</title>';
        $lines[] = '<style>body{font:14px/1.5 -apple-system,BlinkMacSystemFont,Segoe UI,sans-serif;padding:20px;max-width:1100px;margin:0 auto;background:#f7f7f7;color:#222}';
        $lines[] = 'h1{font-size:20px} .box{background:#fff;border:1px solid #ddd;border-radius:8px;padding:14px 16px;margin:12px 0}';
        $lines[] = '.ok{color:#0a7} .warn{color:#c60} .err{color:#c00} code,pre{background:#f0f0f0;padding:2px 4px;border-radius:4px;white-space:pre-wrap;word-break:break-word}';
        $lines[] = 'a.btn{display:inline-block;background:#0284c7;color:#fff;padding:8px 14px;border-radius:6px;text-decoration:none;margin-right:8px}';
        $lines[] = 'table{width:100%;border-collapse:collapse} td,th{border:1px solid #e5e5e5;padding:8px;vertical-align:top;font-size:12px} th{background:#fafafa}</style></head><body>';
        $lines[] = '<h1>产品详情西班牙语段落：为开头 JUNEX 添加 about-us 链接</h1>';
        $lines[] = '<div class="box"><strong>模式：</strong><span class="' . ($apply ? 'err' : 'warn') . '">' . htmlspecialchars($mode) . '</span><br>';
        $lines[] = '字段：<code>content</code>　语言：<code>' . htmlspecialchars($locale) . '</code><br>';
        $lines[] = '扫描命中行：' . (int)$scanned . '　将修改行：' . (int)$changedRows . '<br>';
        $lines[] = '替换规则：段落开头 <code>JUNEX</code> → ' . $linkPreview . ' es un fabricante profesional…';
        $lines[] = '</div>';

        if (!$apply) {
            $lines[] = '<div class="box">';
            $lines[] = '<a class="btn" href="' . htmlspecialchars($applyUrl) . '">确认写库 apply=1</a>';
            $lines[] = '<a class="btn" style="background:#666" href="' . htmlspecialchars($previewUrl) . '">重新预览</a>';
            $lines[] = '</div>';
        } else {
            $lines[] = '<div class="box ok">已写回数据库。请刷新产品详情页检查。用完请删除本工具路由或设置 FIX_TOOL_TOKEN。</div>';
        }

        if ($report === []) {
            $lines[] = '<div class="box ok">没有需要修改的记录（可能已全部加链，或暂无匹配段落）。</div>';
        } else {
            $lines[] = '<div class="box"><table><thead><tr><th>translation_id</th><th>product_id</th><th>locale</th><th>before → after</th></tr></thead><tbody>';
            foreach ($report as $item) {
                $lines[] = '<tr>';
                $lines[] = '<td>' . (int)$item['id'] . '</td>';
                $lines[] = '<td>' . (int)$item['product_id'] . '</td>';
                $lines[] = '<td>' . htmlspecialchars((string)$item['locale']) . '</td>';
                $lines[] = '<td><span class="err">B:</span> ' . htmlspecialchars((string)$item['before']) . '<br><span class="ok">A:</span> ' . htmlspecialchars((string)$item['after']) . '</td>';
                $lines[] = '</tr>';
            }
            $lines[] = '</tbody></table></div>';
        }

        $lines[] = '</body></html>';

        return implode("\n", $lines);
    }
}
