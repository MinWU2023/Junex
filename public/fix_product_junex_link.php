<?php
/**
 * 独立浏览器工具（只需上传本文件到 public/ 目录即可使用，无需控制器）。
 *
 * 预览：/fix_product_junex_link.php
 * 写库：/fix_product_junex_link.php?apply=1
 * 口令：/fix_product_junex_link.php?token=xxx&apply=1  （.env 设置 FIX_TOOL_TOKEN 时）
 */

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$field = 'content';
$marker = 'JUNEX es un fabricante profesional de ropa deportiva especializado en yoga';
$linkColor = '#0284c7';
$self = basename(__FILE__);

$expectedToken = trim((string)env('FIX_TOOL_TOKEN', ''));
if ($expectedToken !== '') {
    $token = (string)($_GET['token'] ?? '');
    if (!hash_equals($expectedToken, $token)) {
        http_response_code(403);
        exit('Invalid token');
    }
}

$apply = filter_var($_GET['apply'] ?? false, FILTER_VALIDATE_BOOLEAN);
$locale = trim((string)($_GET['locale'] ?? 'es'));

header('Content-Type: text/html; charset=UTF-8');

if (!Schema::hasTable('product_translations')) {
    http_response_code(500);
    exit('<pre>table missing: product_translations</pre>');
}

if (!in_array($field, Schema::getColumnListing('product_translations'), true)) {
    http_response_code(500);
    exit('<pre>column missing: ' . htmlspecialchars($field) . '</pre>');
}

$needsLink = static function (string $html) use ($marker): bool {
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
};

$junexAlreadyLinked = static function (string $prefix, string $suffix): bool {
    $tail = mb_substr($prefix, -300);
    if (preg_match('/<a\s[^>]*href=["\'][^"\']*about-us[^"\']*["\'][^>]*>\s*(?:<span[^>]*>\s*)?$/iu', $tail)) {
        return true;
    }
    return (bool)preg_match('/^\s*<\/span>\s*<\/a>/iu', $suffix);
};

$linkifyLeadingJunex = static function (string $html) use ($marker, $linkColor, $junexAlreadyLinked): string {
    $markerPos = mb_stripos($html, $marker);
    if ($markerPos === false) {
        return $html;
    }

    $prefix = mb_substr($html, 0, $markerPos);
    $suffix = mb_substr($html, $markerPos + 5);

    if ($junexAlreadyLinked($prefix, $suffix)) {
        return $html;
    }

    $link = '<a href="/about-us"><span style="color:' . $linkColor . ';">JUNEX</span></a>';

    return $prefix . $link . $suffix;
};

$excerpt = static function (string $text, int $max = 260): string {
    $text = preg_replace('/\s+/u', ' ', $text) ?? $text;
    if (mb_strlen($text) <= $max) {
        return $text;
    }
    return mb_substr($text, 0, $max) . '…';
};

$query = DB::table('product_translations')
    ->orderBy('id')
    ->where($field, 'like', '%' . $marker . '%');

if ($locale !== '') {
    $query->where('locale', $locale);
}

$rows = $query->get(['id', 'product_id', 'locale', $field]);
$report = [];
$changedRows = 0;

foreach ($rows as $row) {
    $original = (string)($row->{$field} ?? '');
    if ($original === '' || !$needsLink($original)) {
        continue;
    }

    $updated = $linkifyLeadingJunex($original);
    if ($updated === $original) {
        continue;
    }

    $changedRows++;
    $report[] = [
        'id' => (int)$row->id,
        'product_id' => (int)$row->product_id,
        'locale' => (string)$row->locale,
        'before' => $excerpt($original),
        'after' => $excerpt($updated),
    ];

    if ($apply) {
        DB::table('product_translations')->where('id', $row->id)->update([
            $field => $updated,
        ]);
    }
}

$mode = $apply ? 'APPLY（已写库）' : 'DRY-RUN（仅预览，未写库）';
$qs = 'locale=' . rawurlencode($locale);
$applyUrl = '/' . $self . '?apply=1&' . $qs;
$previewUrl = '/' . $self . '?' . $qs;
if ($expectedToken !== '') {
    $applyUrl .= '&token=' . rawurlencode($expectedToken);
    $previewUrl .= '&token=' . rawurlencode($expectedToken);
}

$linkPreview = '<a href="/about-us"><span style="color:' . $linkColor . ';">JUNEX</span></a>';

echo '<!doctype html><html><head><meta charset="utf-8"><title>Fix JUNEX about-us link</title>';
echo '<style>body{font:14px/1.5 -apple-system,BlinkMacSystemFont,Segoe UI,sans-serif;padding:20px;max-width:1100px;margin:0 auto;background:#f7f7f7;color:#222}';
echo 'h1{font-size:20px} .box{background:#fff;border:1px solid #ddd;border-radius:8px;padding:14px 16px;margin:12px 0}';
echo '.ok{color:#0a7} .warn{color:#c60} .err{color:#c00} code,pre{background:#f0f0f0;padding:2px 4px;border-radius:4px;white-space:pre-wrap;word-break:break-word}';
echo 'a.btn{display:inline-block;background:#0284c7;color:#fff;padding:8px 14px;border-radius:6px;text-decoration:none;margin-right:8px}';
echo 'table{width:100%;border-collapse:collapse} td,th{border:1px solid #e5e5e5;padding:8px;vertical-align:top;font-size:12px} th{background:#fafafa}</style></head><body>';
echo '<h1>产品详情西班牙语段落：为开头 JUNEX 添加 about-us 链接</h1>';
echo '<div class="box"><strong>模式：</strong><span class="' . ($apply ? 'err' : 'warn') . '">' . htmlspecialchars($mode) . '</span><br>';
echo '文件：<code>' . htmlspecialchars($self) . '</code>　字段：<code>' . htmlspecialchars($field) . '</code>　语言：<code>' . htmlspecialchars($locale) . '</code><br>';
echo '扫描命中行：' . (int)$rows->count() . '　将修改行：' . (int)$changedRows . '<br>';
echo '替换规则：段落开头 <code>JUNEX</code> → ' . $linkPreview . ' es un fabricante profesional…';
echo '</div>';

if (!$apply) {
    echo '<div class="box">';
    echo '<a class="btn" href="' . htmlspecialchars($applyUrl) . '">确认写库 apply=1</a>';
    echo '<a class="btn" style="background:#666" href="' . htmlspecialchars($previewUrl) . '">重新预览</a>';
    echo '</div>';
} else {
    echo '<div class="box ok">已写回数据库。请刷新产品详情页检查。用完请删除 public/' . htmlspecialchars($self) . '。</div>';
}

if ($report === []) {
    echo '<div class="box ok">没有需要修改的记录（可能已全部加链，或暂无匹配段落）。</div>';
} else {
    echo '<div class="box"><table><thead><tr><th>translation_id</th><th>product_id</th><th>locale</th><th>before → after</th></tr></thead><tbody>';
    foreach ($report as $item) {
        echo '<tr>';
        echo '<td>' . (int)$item['id'] . '</td>';
        echo '<td>' . (int)$item['product_id'] . '</td>';
        echo '<td>' . htmlspecialchars((string)$item['locale']) . '</td>';
        echo '<td><span class="err">B:</span> ' . htmlspecialchars((string)$item['before']) . '<br><span class="ok">A:</span> ' . htmlspecialchars((string)$item['after']) . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}

echo '</body></html>';
