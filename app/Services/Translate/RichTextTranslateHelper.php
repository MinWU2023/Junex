<?php

namespace App\Services\Translate;

use DOMDocument;
use DOMNode;

class RichTextTranslateHelper
{
    public function isRich(string $type, string $value): bool
    {
        if (in_array($type, ['uedit', 'editor', 'html'], true)) {
            return true;
        }

        return $value !== '' && preg_match('/<[a-z][\s\S]*>/i', $value) === 1;
    }

    /**
     * @return array{template:string,segments:array<int,string>}
     */
    public function extract(string $html): array
    {
        $html = trim($html);
        if ($html === '') {
            return ['template' => '', 'segments' => []];
        }

        $doc = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8" ?><div id="tw-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $segments = [];
        $attrs = ['alt', 'title', 'placeholder'];
        $root = $doc->getElementById('tw-root');
        if (!$root) {
            return ['template' => $html, 'segments' => [$html]];
        }

        $this->walk($root, $segments, $attrs);
        $template = '';
        foreach ($root->childNodes as $child) {
            $template .= $doc->saveHTML($child);
        }

        return ['template' => $template, 'segments' => $segments];
    }

    /**
     * @param array<int,string> $segments
     */
    public function restore(string $template, array $segments): string
    {
        $html = $template;
        foreach ($segments as $index => $segment) {
            $html = str_replace('%%TR' . $index . '%%', $segment, $html);
        }

        return $html;
    }

    /**
     * @param array<int,string> $segments
     */
    protected function walk(DOMNode $node, array &$segments, array $attrs): void
    {
        if ($node->nodeType === XML_TEXT_NODE) {
            $text = (string) $node->nodeValue;
            if (trim($text) !== '') {
                $key = '%%TR' . count($segments) . '%%';
                $segments[] = $text;
                $node->nodeValue = $key;
            }
            return;
        }

        if ($node->nodeType !== XML_ELEMENT_NODE) {
            return;
        }

        $tag = strtolower($node->nodeName);
        if (in_array($tag, ['script', 'style'], true)) {
            return;
        }

        if ($node->hasAttributes()) {
            foreach ($attrs as $attr) {
                if ($node->attributes->getNamedItem($attr)) {
                    $value = (string) $node->attributes->getNamedItem($attr)->nodeValue;
                    if (trim($value) !== '') {
                        $key = '%%TR' . count($segments) . '%%';
                        $segments[] = $value;
                        $node->attributes->getNamedItem($attr)->nodeValue = $key;
                    }
                }
            }
        }

        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $child) {
                $this->walk($child, $segments, $attrs);
            }
        }
    }
}
