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

    /**
     * 腾讯 007 防水墙设置
     * https://007.qq.com/
     */
    'captcha' => [
        'register' => [
            'aid' => env('CAPTCHA_ID_REGISTER', ''),
            'secret' => env('CAPTCHA_SECRET_REGISTER', ''),
        ],
        'login' => [
            'aid' => env('CAPTCHA_ID_LOGIN', ''),
            'secret' => env('CAPTCHA_SECRET_LOGIN', ''),
        ],
        'verify_code' => [
            'aid' => env('CAPTCHA_ID_VERIFY_CODE', ''),
            'secret' => env('CAPTCHA_SECRET_VERIFY_CODE', ''),
        ]
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

    'baidu_smart_program' => [
        'app_id' => env('BAIDU_SMART_PROGRAM_APP_ID', ''),
        'app_key' => env('BAIDU_SMART_PROGRAM_APP_KEY', ''),
        'app_secret' => env('BAIDU_SMART_PROGRAM_APP_SECRET', ''),
    ],

    'wechat_mini_program' => [
        'app_id' => env('WECHAT_NIMI_PROGRAM_APP_ID', ''),
        'app_secret' => env('WECHAT_NIMI_PROGRAM_APP_SECRET', ''),
    ],

    'qq_mini_program' => [//QQ小程序设置
        'app_id' => env('QQ_NIMI_PROGRAM_APP_ID', ''),
        'app_token' => env('QQ_NIMI_PROGRAM_APP_KEY', ''),
        'app_secret' => env('QQ_NIMI_PROGRAM_APP_SECRET', ''),
    ],

    'bytedance_mini_program' => [//字节跳动小程序设置
        'app_id' => env('BYTEDANCE_NIMI_PROGRAM_APP_ID', ''),
        'app_secret' => env('BYTEDANCE_NIMI_PROGRAM_APP_SECRET', ''),
    ],
];
