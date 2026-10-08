<?php

/**
 * Build scoped CSS for Product Highlights / Product Details so TinyMCE templates
 * (Bootstrap + moban.css) match the admin editor without leaking into Tailwind.
 *
 * Usage: php scripts/build-product-highlights-css.php
 */

$root = dirname(__DIR__);
$prefixes = [
    '.product-highlights-content',
    '.product-details-content',
];
$dstFile = $root . '/public/front/css/product-highlights.css';

$sources = [
    [
        'file' => $root . '/public/tinymce/tpl/css/det_bootstrap.css',
        'label' => 'Bootstrap v3.3.6 (det_bootstrap.css)',
        'before' => function (string $css): string {
            // Drop trailing animate.css / @charset block bundled in det_bootstrap.css
            $cutAt = strpos($css, '@charset');
            return $cutAt === false ? $css : substr($css, 0, $cutAt);
        },
        'after' => function (string $css): string {
            return str_replace("url('../fonts/", "url('/tinymce/tpl/fonts/", $css);
        },
    ],
    [
        'file' => $root . '/public/images/moban.css',
        'label' => 'TinyMCE template styles (moban.css)',
        'before' => null,
        'after' => null,
    ],
];

function splitSelectors(string $selector): array
{
    $parts = [];
    $buf = '';
    $depth = 0;
    $len = strlen($selector);
    for ($i = 0; $i < $len; $i++) {
        $ch = $selector[$i];
        if ($ch === '(') {
            $depth++;
        }
        if ($ch === ')' && $depth > 0) {
            $depth--;
        }
        if ($ch === ',' && $depth === 0) {
            $parts[] = $buf;
            $buf = '';
            continue;
        }
        $buf .= $ch;
    }
    if ($buf !== '') {
        $parts[] = $buf;
    }
    return $parts;
}

function prefixSelector(string $sel, string $prefix): string
{
    $sel = trim($sel);
    if ($sel === '') {
        return $sel;
    }
    if ($sel[0] === '@') {
        return $sel;
    }
    if (preg_match('/^(from|to|\d+(\.\d+)?%)$/i', $sel)) {
        return $sel;
    }
    if (strpos($sel, $prefix) === 0) {
        return $sel;
    }

    $replaced = preg_replace(
        '/(^|[\s>+~])(html|body|:root)(?=[\s>+~.#:\[,]|$)/i',
        '$1' . $prefix,
        $sel
    );

    if ($replaced !== $sel) {
        return preg_replace(
            '/' . preg_quote($prefix, '/') . '(\s+' . preg_quote($prefix, '/') . ')+/',
            $prefix,
            $replaced
        );
    }

    return $prefix . ' ' . $sel;
}

function stripCssComments(string $css): string
{
    return preg_replace('/\/\*.*?\*\//s', '', $css) ?? $css;
}

function prefixSelectorList(string $list, array $prefixes): string
{
    $list = stripCssComments($list);
    $out = [];
    foreach (splitSelectors($list) as $sel) {
        foreach ($prefixes as $prefix) {
            $p = prefixSelector($sel, $prefix);
            if ($p !== '') {
                $out[] = $p;
            }
        }
    }
    return implode(', ', $out);
}

function processCss(string $css, array $prefixes): string
{
    $out = '';
    $len = strlen($css);
    $i = 0;

    while ($i < $len) {
        if ($i + 1 < $len && $css[$i] === '/' && $css[$i + 1] === '*') {
            $end = strpos($css, '*/', $i + 2);
            if ($end === false) {
                $out .= substr($css, $i);
                break;
            }
            $out .= substr($css, $i, $end + 2 - $i);
            $i = $end + 2;
            continue;
        }

        $brace = strpos($css, '{', $i);
        if ($brace === false) {
            $out .= substr($css, $i);
            break;
        }

        $prelude = substr($css, $i, $brace - $i);
        $depth = 1;
        $j = $brace + 1;
        $inStr = false;
        $strCh = '';
        $inCmt = false;

        while ($j < $len) {
            $ch = $css[$j];
            if ($inCmt) {
                if ($ch === '*' && $j + 1 < $len && $css[$j + 1] === '/') {
                    $inCmt = false;
                    $j += 2;
                    continue;
                }
                $j++;
                continue;
            }
            if ($inStr) {
                if ($ch === '\\') {
                    $j += 2;
                    continue;
                }
                if ($ch === $strCh) {
                    $inStr = false;
                }
                $j++;
                continue;
            }
            if ($ch === '"' || $ch === "'") {
                $inStr = true;
                $strCh = $ch;
                $j++;
                continue;
            }
            if ($ch === '/' && $j + 1 < $len && $css[$j + 1] === '*') {
                $inCmt = true;
                $j += 2;
                continue;
            }
            if ($ch === '{') {
                $depth++;
            }
            if ($ch === '}') {
                $depth--;
                if ($depth === 0) {
                    break;
                }
            }
            $j++;
        }

        $body = substr($css, $brace + 1, $j - $brace - 1);
        $trimmedPrelude = trim($prelude);

        if ($trimmedPrelude !== '' && $trimmedPrelude[0] === '@') {
            if (preg_match('/^@([a-zA-Z\-]+)/', $trimmedPrelude, $m)) {
                $at = strtolower($m[1]);
                $isKeyframes = in_array($at, ['keyframes', '-webkit-keyframes', '-moz-keyframes', '-o-keyframes'], true);
                $isPassthrough = in_array($at, ['charset', 'import', 'namespace', 'font-face', 'counter-style', 'property'], true) || $isKeyframes;
                if ($isPassthrough) {
                    $out .= $prelude . '{' . $body . '}';
                } else {
                    $out .= $prelude . '{' . processCss($body, $prefixes) . '}';
                }
            } else {
                $out .= $prelude . '{' . $body . '}';
            }
        } else {
            $out .= "\n" . prefixSelectorList($trimmedPrelude, $prefixes) . ' {' . $body . '}';
        }

        $i = $j + 1;
    }

    return $out;
}

function isolationHelpers(array $prefixes): string
{
    $out = '';
    foreach ($prefixes as $prefix) {
        $out .= <<<CSS
{$prefix} {
  display: block;
  min-width: 0;
  max-width: 1200px;
  width: 100%;
  box-sizing: border-box;
  overflow-x: auto;
  overflow-y: visible;
  -webkit-overflow-scrolling: touch;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 14px;
  line-height: 24px;
  color: #555;
  background: #fff;
  text-align: left;
}
{$prefix} *,
{$prefix} *::before,
{$prefix} *::after {
  box-sizing: border-box;
}
/* Prevent Bootstrap fixed .container widths from clipping inside PDP column */
{$prefix} .container,
{$prefix} .container-fluid {
  width: 100% !important;
  max-width: 100% !important;
  margin-left: auto;
  margin-right: auto;
  padding-left: 15px;
  padding-right: 15px;
}
{$prefix} .row {
  margin-left: -15px;
  margin-right: -15px;
}
{$prefix} img,
{$prefix} video {
  max-width: 100%;
  height: auto;
}
{$prefix} table {
  float: none !important;
  display: table !important;
  width: 100% !important;
  max-width: 100% !important;
  min-width: 0 !important;
  height: auto !important;
  margin-left: 0 !important;
  margin-right: 0 !important;
  border-collapse: collapse;
  table-layout: fixed !important;
  box-sizing: border-box !important;
  overflow: hidden;
}
{$prefix} table thead,
{$prefix} table tbody,
{$prefix} table tfoot,
{$prefix} table tr,
{$prefix} table td,
{$prefix} table th {
  height: auto !important;
  min-height: 0 !important;
  max-height: none !important;
  max-width: 100% !important;
  overflow: hidden !important;
}
{$prefix} table td,
{$prefix} table th {
  border: 1px solid #ccc;
  padding: 8px;
  vertical-align: top;
  white-space: normal !important;
  word-break: break-word !important;
  overflow-wrap: anywhere !important;
}
{$prefix} table p {
  margin: 0 !important;
  white-space: normal !important;
  word-break: break-word !important;
  overflow-wrap: anywhere !important;
}
{$prefix} iframe {
  max-width: 100%;
}
/* Undo common Tailwind preflight conflicts inside editor HTML */
{$prefix} ul,
{$prefix} ol {
  margin: 0;
  padding: 0;
}
{$prefix} p {
  margin: 0;
}
{$prefix} a {
  text-decoration: none;
  color: inherit;
}
{$prefix} .clearfix:before,
{$prefix} .clearfix:after {
  content: " ";
  display: table;
}
{$prefix} .clearfix:after {
  clear: both;
}

CSS;
    }

    return $out;
}

$prefixLabel = implode(', ', $prefixes);
$bundle = "/*!\n"
    . " * Product Highlights / Product Details scoped editor styles\n"
    . " * Prefix: {$prefixLabel}\n"
    . " * Matches TinyMCE content_css: det_bootstrap.css + moban.css\n"
    . " * Regenerate: php scripts/build-product-highlights-css.php\n"
    . " */\n\n";

foreach ($sources as $source) {
    if (!is_file($source['file'])) {
        fwrite(STDERR, "Missing source: {$source['file']}\n");
        exit(1);
    }

    $css = file_get_contents($source['file']);
    if ($css === false) {
        fwrite(STDERR, "Failed to read: {$source['file']}\n");
        exit(1);
    }

    if (is_callable($source['before'])) {
        $css = $source['before']($css);
    }

    $scoped = processCss($css, $prefixes);

    if (is_callable($source['after'])) {
        $scoped = $source['after']($scoped);
    }

    $bundle .= "/* ===== {$source['label']} ===== */\n";
    $bundle .= $scoped . "\n\n";
}

$bundle .= "/* ===== Isolation helpers (editor island vs Tailwind) ===== */\n";
$bundle .= isolationHelpers($prefixes);

file_put_contents($dstFile, $bundle);
echo 'Wrote ' . number_format(filesize($dstFile)) . " bytes to {$dstFile}\n";
