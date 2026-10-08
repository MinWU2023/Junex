<?php

namespace App\Services;

class GibberishDetectionService
{
    public function calculateGibberishScore($content)
    {
        if (empty($content)) {
            return [
                'score' => 0,
                'details' => [],
                'is_gibberish' => false
            ];
        }

        $score   = 0;
        $details = [];
        $content = trim((string) $content);
        $length  = mb_strlen($content);

        // ========== 中文检测豁免 ==========
        $chineseCount = preg_match_all('/[\x{4e00}-\x{9fa5}]/u', $content);
        if ($chineseCount > 0 && ($chineseCount / $length > 0.3)) {
            return [
                'score' => 0,
                'details' => ['检测到中文文本，跳过英文噪音检测'],
                'is_gibberish' => false
            ];
        }

        // ========== 英文随机字母串检测（强化版） ==========
        if (preg_match('/^[a-zA-Z]+$/', $content) && $length >= 6) {
            $vowelCount = preg_match_all('/[aeiouAEIOU]/', $content);
            $vowelRatio = $vowelCount / $length;
            $hasWeirdCaseMix = (preg_match('/[A-Z]/', $content) && preg_match('/[a-z]/', $content));

            // 常见英文组合（可读性模式）
            $commonPatterns = ['th', 'ch', 'sh', 'ph', 'ing', 'ed', 'er', 'ly', 'tion', 'able', 'est'];
            $hasCommonPattern = false;
            foreach ($commonPatterns as $p) {
                if (stripos($content, $p) !== false) {
                    $hasCommonPattern = true;
                    break;
                }
            }

            // 辅音比例
            $consonantCount = preg_match_all('/[bcdfghjklmnpqrstvwxyz]/i', $content);
            $consonantRatio = $length > 0 ? $consonantCount / $length : 0;

            // 判定条件（满足任意两条即视为乱码）
            $randomIndicators = 0;
            if ($vowelRatio < 0.35) $randomIndicators++;
            if ($hasWeirdCaseMix) $randomIndicators++;
            if (!$hasCommonPattern) $randomIndicators++;
            if ($consonantRatio > 0.6) $randomIndicators++;

            if ($randomIndicators >= 2) {
                $score += 80;
                $details[] = '检测到随机英文字母串（结构异常或可读性低）';
            }
        }

        // ========== 规则1：长度超过10但没有空格 ==========
        $isEmail = filter_var($content, FILTER_VALIDATE_EMAIL);
        $isPhone = preg_match('/^\+?[0-9][0-9\-\(\),.\s]{5,}$/', $content);
        $isNamePhoneMix = (preg_match('/[a-zA-Z]/', $content) && preg_match('/\d{6,}/', $content));

        if ($length >= 10 && !str_contains($content, ' ') && !$isEmail && !$isPhone && !$isNamePhoneMix) {
            $score += 60;
            $details[] = '内容长度超过10个字符且无空格';
        }

        // ========== 规则2：元音比例过低 ==========
        if (preg_match('/[a-zA-Z]/', $content)) {
            $vowels = preg_match_all('/[aeiouAEIOU]/', $content);
            if ($length > 10 && ($vowels / $length) < 0.1) {
                $score += 10;
                $details[] = '元音比例过低';
            }
        }

        // ========== 规则3：链接检测（智能豁免） ==========
        // 先提取所有邮箱地址，避免将邮箱误检测为域名
        $emailPattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';
        $contentWithoutEmails = preg_replace($emailPattern, '', $content);

        if (preg_match_all('/\b((https?:\/\/)?(www\.)?[a-zA-Z0-9\-]+\.[a-z]{2,})(\/\S*)?/i', $contentWithoutEmails, $matches)) {
            foreach ($matches[0] as $url) {
                $lowerUrl = strtolower($url);

                // 白名单域名（可扩展）
                $whitelist = [
                    'google.com',
                    'facebook.com',
                    'linkedin.com',
                    'youtube.com',
                    'amazon.com',
                    'instagram.com',
                    'twitter.com',
                ];

                $isWhitelisted = false;
                foreach ($whitelist as $allowed) {
                    if (str_contains($lowerUrl, $allowed)) {
                        $isWhitelisted = true;
                        break;
                    }
                }

                // 可疑域名特征：低质量TLD、长参数、超长随机域名
                if (
                    !$isWhitelisted &&
                    (
                        preg_match('/\.(xyz|top|click|cn|ru|work|info|biz|tk|pw|cc)\b/', $lowerUrl) ||
                        preg_match('/[\?\&\=]/', $lowerUrl) ||
                        preg_match('/[a-z0-9\-]{10,}\.[a-z]{2,}/', $lowerUrl)
                    )
                ) {
                    $score += 80;
                    $details[] = "检测到可疑链接: {$url}";
                } else {
                    $details[] = "检测到正常链接（豁免）: {$url}";
                }
            }
        }

        // ========== 规则4：辅音密度 ==========
        if (preg_match('/[a-zA-Z]/', $content)) {
            $consonantCount = preg_match_all('/[bcdfghjklmnpqrstvwxyz]/i', $content);
            $consonantDensity = $length > 0 ? $consonantCount / $length : 0;

            if (preg_match('/[bcdfghjklmnpqrstvwxyz]{5,}/i', $content)) {
                $score += 10;
                $details[] = '包含5个以上连续辅音';
            }

            if ($length > 10 && $consonantDensity > 0.7) {
                $score += 10;
                $details[] = '辅音比例过高';
            }
        }

        // ========== 规则5：重复字符 ==========
        if (preg_match('/(.)\1{3,}/', $content)) {
            $score += 15;
            $details[] = '包含重复字符';
        }

        // ========== 规则6：特殊字符比例 ==========
        $specialChars = preg_match_all('/[^a-zA-Z0-9\s\+\-\(\),.@\x{4e00}-\x{9fa5}]/u', $content);
        if ($length > 0 && $specialChars / $length > 0.3) {
            $score += 10;
            $details[] = '特殊字符比例过高';
        }

        // ========== 规则7：全为数字 ==========
        if (preg_match('/^\d+$/', $content)) {
            $score += 20;
            $details[] = '内容全为数字';
        }

        // ========== 规则8：短单词检测（疑似无效询盘） ==========
        if (preg_match('/^[a-zA-Z]{4,7}$/', $content)) {
            $lower = strtolower($content);
            $commonWords = ['hello', 'hi', 'test', 'plako', 'ok', 'hey', 'thanks'];
            if (in_array($lower, $commonWords)) {
                $score = 59;
                $details[] = '短英文单词（疑似无效询盘）';
            }
        }

        if ($score > 100) {
            $score = 100;
        }

        return [
            'score' => $score,
            'details' => $details,
            'is_gibberish' => $score >= 60
        ];
    }
}
