<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    | 翻译通道（工作台）
    | 推荐：TRANSLATE_DEEPL_KEY = DeepL 免费账号 API Key（每月 50 万字符，几乎不 429）
    | 申请：https://www.deepl.com/pro-api （选 Free）
    | 备选：TRANSLATE_MYMEMORY_EMAIL 填有效邮箱可提高 MyMemory 日限额
    | 自建：TRANSLATE_LIBRE_URL = http://127.0.0.1:5000 （Docker 跑 LibreTranslate，无限免费用）
    */
    'translate' => [
        'deepl_key' => env('TRANSLATE_DEEPL_KEY', ''),
        'deepl_api' => env('TRANSLATE_DEEPL_API', 'https://api-free.deepl.com'),
        'mymemory_email' => env('TRANSLATE_MYMEMORY_EMAIL', ''),
        'libre_url' => env('TRANSLATE_LIBRE_URL', ''),
    ],

];
