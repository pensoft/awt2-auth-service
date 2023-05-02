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

    'orcid' => [
        'client_id' => env('ORCID_CLIENT_ID'),
        'client_secret' => env('ORCID_CLIENT_SECRET'),
        'redirect' => env('ORCID_REDIRECT_URI') ,
        'environment' => env('ORCID_ENVIRONMENT'), // Optional
        'uid_fieldname' => env('ORCID_UID_FIELDNAME'), // Optional
    ],

    'pensoft' => [
        'url' => [
            'article_editor' => env('ARTICLE_EDITOR_URL'),
            'article_editor_stage' => env('ARTICLE_EDITOR_URL_STAGE'),
            'article_backoffice' => env('ARTICLE_BACKOFFICE_URL'),
            'article_backoffice_stage' => env('ARTICLE_BACKOFFICE_URL_STAGE')
        ],
        'services' => [
            'article' => env('ARTICLE_SERVICE'),
            'auth' => env('AUTH_SERVICE'),
            'event_dispatcher' => env('EVENT_DISPATCHER_SERVICE'),
            'article_storage' => env('ARTICLE_STORAGE_SERVICE'),
            'cdn' => env('CDN_SERVICE')
        ]
    ]

];
