<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => base_path(''),
            'url' => env('APP_URL'),
            'visibility' => 'public',
            'throw' => false,
        ],

        'local-backup' => [
            'driver' => 'local',
            'root' => storage_path('app/backup/database'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'amazon-s3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'visibility' => 'public',
        ],

        'digital-ocean' => [
            'driver' => 's3',
            'key' => env('DO_ACCESS_KEY_ID'),
            'secret' => env('DO_SECRET_KEY'),
            'region' => env('DO_DEFAULT_REGION'),
            'bucket' => env('DO_BUCKET'),
            'endpoint' => env('DO_ENDPOINT'),
            'url' => env('DO_URL'),
            'visibility' => 'public',
        ],

        'wasabi' => [
            'driver' => 's3',
            'key' => env('WAS_ACCESS_KEY_ID'),
            'secret' => env('WAS_SECRET_KEY'),
            'region' => env('WAS_DEFAULT_REGION'),
            'bucket' => env('WAS_BUCKET'),
            'endpoint' => env('WAS_URL'),
            'visibility' => 'public',
        ],

        'dropbox' => [
            'driver' => 'dropbox',
            'key' => env('DROPBOX_APP_KEY'),
            'secret' => env('DROPBOX_APP_SECRET'),
            'authorization_token' => env('DROPBOX_AUTH_TOKEN'),
        ],

        'google' => [
            'driver' => 'google',
            'clientId' => env('GOOGLE_DRIVE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
            'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
            'folderId' => env('GOOGLE_DRIVE_FOLDER_ID'),
        ],
        'public-folder' => [
            'driver' => 'local',
            'root' => base_path('public/uploads'),
            'url' => env('APP_URL'),
            'visibility' => 'public',
            'throw' => false,
        ],
        'digital-ocean-backup' => [
            'driver' => 's3',
            'key' => env('DOB_ACCESS_KEY_ID'),
            'secret' => env('DOB_SECRET_KEY'),
            'region' => env('DOB_DEFAULT_REGION'),
            'bucket' => env('DOB_BUCKET'),
            'endpoint' => env('DOB_ENDPOINT'),
            'url' => env('DOB_URL'),
            'root' => env('DOB_DIRECTORY'),
            'visibility' => 'public',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
