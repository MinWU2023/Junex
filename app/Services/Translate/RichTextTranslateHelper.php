<?php

namespace App\Services\Translate;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;

class RichTextTranslateHelper
{
    /** Unique token; reverse-replace safe when using descending indexes. */
    protected string $tokenPrefix = '⟦TW';
    protected string $tokenSuffix = '⟧';

    public function isRich(string $type, string $value): bool
    {
        if (in_array($type, ['uedit', 'editor', 'html'], true)) {
            return true;
        }

        return $value !== '' && preg_match('/<[a-z][\s\S]*>/i', $value) === 1;
    }

    /**
     * Extract alt/title/placeholder + visible text nodes into segments.
     * Template keeps HTML structure with unique placeholders.
     *
     * @return array{template:string,segments:array<int,string>,count:int}
     */
    public function extract(string $html): array
    {
        $html = trim($html);
        if ($html === '') {
            return ['template' => '', 'segments' => [], 'count' => 0];
        }

        // Prefer DOM; fall back to regex extractor if DOM fails
        try {
            $result = $this->extractByDom($html);
            if ($result['count'] > 0) {
                return $result;
            }
        } catch (\Throwable $e) {
            // fall through
        }

        return $this->extractByRegex($html);
    }

    /**
     * @param array<int,string> $segments translated texts in same order as extract
     */
    public function restore(string $template, array $segments): string
    {
        $html = $template;
        // Important: replace from highest index to lowest to avoid
        // ⟦TW1⟧ matching inside ⟦TW10⟧ / ⟦TW11⟧
        $indexes = array_keys($segments);
        rsort($indexes, SORT_NUMERIC);
        foreach ($indexes as $index) {
            $token = $this->token($index);
            $html = str_replace($token, (string) $segments[$index], $html);
        }

        return $html;
    }

    protected function token(int $index): string
    {
        return $this->tokenPrefix . $index . $this->tokenSuffix;
    }

    /**
     * @return array{template:string,segments:array<int,string>,count:int}
     */
    protected function extractByDom(string $html): array
    {
        $wrapped = '<!DOCTYPE html><html><head><meta charset="utf-8"></head><body><div id="tw-root">' . $html . '</div></body></html>';
        $doc = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $doc->loadHTML($wrapped);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $doc->getElementById('tw-root');
        if (!$root) {
            throw new \RuntimeException('DOM root missing');
        }

        $segments = [];
        $attrs = ['alt', 'title', 'placeholder'];
        $this->walk($root, $segments, $attrs);

        $template = '';
        foreach ($root->childNodes as $child) {
            $template .= $doc->saveHTML($child);
        }

        return [
            'template' => $template,
            'segments' => $segments,
            'count' => count($segments),
        ];
    }

    /**
     * Regex fallback: keep HTML tags intact, extract attribute values + text between tags.
     *
     * @return array{template:string,segments:array<int,string>,count:int}
     */
    protected function extractByRegex(string $html): array
    {
        $segments = [];

        // 1) alt / title / placeholder attributes
        $template = preg_replace_callback(
            '/\b(alt|title|placeholder)\s*=\s*(["\'])(.*?)\2/is',
            function ($m) use (&$segments) {
                $value = html_entity_decode($m[3], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                if (!$this->shouldTranslate($value)) {
                    return $m[0];
                }
                $token = $this->token(count($segments));
                $segments[] = $value;
                return $m[1] . '=' . $m[2] . $token . $m[2];
            },
            $html
        );
        if (!is_string($template)) {
            $template = $html;
        }

        // 2) text between tags (not inside script/style)
        $parts = preg_split('/(<script\b[^>]*>.*?<\/script>|<style\b[^>]*>.*?<\/style>|<[^>]+>)/is', $template, -1, PREG_SPLIT_DELIM_CAPTURE);
        if (!is_array($parts)) {
            return ['template' => $html, 'segments' => [$html], 'count' => 1];
        }

        $out = '';
        foreach ($parts as $part) {
            if ($part === '') {
                continue;
            }
            // tag or script/style block
            if ($part[0] === '<' || preg_match('/^<(script|style)\b/i', $part)) {
                $out .= $part;
                continue;
            }
            if (!$this->shouldTranslate($part)) {
                $out .= $part;
                continue;
            }
            // Keep leading/trailing whitespace outside the translatable core
            if (preg_match('/^(\s*)([\s\S]*?)(\s*)$/u', $part, $wm)) {
                $core = $wm[2];
                if ($this->shouldTranslate($core)) {
                    $token = $this->token(count($segments));
                    $segments[] = html_entity_decode($core, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $out .= $wm[1] . $token . $wm[3];
                } else {
                    $out .= $part;
                }
            } else {
                $out .= $part;
            }
        }

        return [
            'template' => $out,
            'segments' => $segments,
            'count' => count($segments),
        ];
    }

    /**
     * @param array<int,string> $segments
     * @param array<int,string> $attrs
     */
    protected function walk(DOMNode $node, array &$segments, array $attrs): void
    {
        if ($node->nodeType === XML_TEXT_NODE) {
            $raw = (string) $node->nodeValue;
            if (!$this->shouldTranslate($raw)) {
                return;
            }
            // Preserve surrounding whitespace in the node by only replacing the core
            if (preg_match('/^(\s*)([\s\S]*?)(\s*)$/u', $raw, $m)) {
                $core = $m[2];
                if ($this->shouldTranslate($core)) {
                    $token = $this->token(count($segments));
                    $segments[] = $core;
                    $node->nodeValue = $m[1] . $token . $m[3];
                }
            }
            return;
        }

        if ($node->nodeType !== XML_ELEMENT_NODE) {
            return;
        }

        /** @var DOMElement $node */
        $tag = strtolower($node->nodeName);
        if (in_array($tag, ['script', 'style', 'code', 'pre'], true)) {
            return;
        }

        if ($node->hasAttributes()) {
            foreach ($attrs as $attr) {
                if (!$node->hasAttribute($attr)) {
                    continue;
                }
                $value = (string) $node->getAttribute($attr);
                if (!$this->shouldTranslate($value)) {
                    continue;
                }
                $token = $this->token(count($segments));
                $segments[] = $value;
                $node->setAttribute($attr, $token);
            }
        }

        if ($node->hasChildNodes()) {
            // Copy list first — live NodeList mutates during walk
            $children = [];
            foreach ($node->childNodes as $child) {
                $children[] = $child;
            }
            foreach ($children as $child) {
                $this->walk($child, $segments, $attrs);
            }
        }
    }

    protected function shouldTranslate(string $text): bool
    {
        $trim = trim(html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if ($trim === '') {
            return false;
        }
        // already placeholder
        if (preg_match('/^⟦TW\d+⟧$/', $trim)) {
            return false;
        }
        // URL / path / email / hex color / pure number / CSS-like
        if (preg_match('#^(https?:)?//#i', $trim)) {
            return false;
        }
        if (preg_match('/^[\/#][\w\-\/.?=&%]*$/i', $trim)) {
            return false;
        }
        if (preg_match('/^[\w.+-]+@[\w.-]+\.\w+$/', $trim)) {
            return false;
        }
        if (preg_match('/^#[0-9a-f]{3,8}$/i', $trim)) {
            return false;
        }
        if (preg_match('/^[\d\s.,:%+\-–—\/]+$/u', $trim)) {
            return false;
        }
        // no letters at all
        if (!preg_match('/\p{L}/u', $trim)) {
            return false;
        }

        return true;
    }
}
