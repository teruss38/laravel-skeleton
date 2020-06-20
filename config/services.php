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

    'qq' => [
        'client_id' => env('QQ_KEY', ''),
        'client_secret' => env('QQ_SECRET', ''),
        'redirect' => env('QQ_REDIRECT_URI', '/auth/social/qq/callback')
    ],

    'wechat' => [
        'client_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID', ''),
        'client_secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET', ''),
        'redirect' => env('WECHAT_OFFICIAL_ACCOUNT_REDIRECT', '/auth/social/wechat/callback')
    ],

    'wechat_web' => [
        'client_id' => env('WECHAT_WEB_ACCOUNT_APPID', ''),
        'client_secret' => env('WECHAT_WEB_ACCOUNT_SECRET', ''),
        'redirect' => env('WECHAT_WEB_ACCOUNT_REDIRECT', '/auth/social/wechat_web/callback')
    ],

    'weibo' => [
        'client_id' => env('WEIBO_ID', ''),
        'client_secret' => env('WEIBO_SECRET', ''),
        'redirect' => env('WEIBO_REDIRECT', '/auth/social/weibo/callback')
    ],

    'baidu' => [
        'client_id' => env('BAIDU_KEY', ''),
        'client_secret' => env('BAIDU_SECRET', ''),
        'redirect' => env('BAIDU_REDIRECT_URI', '/auth/social/baidu/callback')
    ],

    'alipay' => [
        'client_id' => env('ALI_APP_ID', ''),
        'client_secret' => env('ALI_PRIVATE_KEY', storage_path('alipay/private.pem')),
        'redirect' => env('ALI_REDIRECT_URI', '/auth/social/alipay/callback')
    ],
];
