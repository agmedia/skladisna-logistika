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
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            //'root' => storage_path('app'),
            'root' => public_path(),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

        //
        'assets' => [
            'driver' => 'local',
            'root' => public_path('assets/'),
            'url' => 'assets/'
        ],
        //
        'media' => [
            'driver' => 'local',
            'root' => public_path('media/'),
            'url' => 'media/'
        ],
        //
        'images' => [
            'driver' => 'local',
            'root' => public_path('media/images/'),
            'url' => 'media/images/'
        ],
        //
        'gallery' => [
            'driver' => 'local',
            'root' => public_path('media/images/gallery/'),
            'url' => 'media/images/gallery/'
        ],
        //
        'pdf' => [
            'driver' => 'local',
            'root' => public_path('media/pdf/'),
            'url' => 'media/pdf/'
        ],
        //
        // Specific folders
        //
        'category' => [
            'driver' => 'local',
            'root' => public_path('media/images/gallery/category/'),
            'url' => 'media/images/gallery/category/'
        ],
        //
        'products' => [
            'driver' => 'local',
            'root' => public_path('media/images/gallery/products/'),
            'url' => 'media/images/gallery/products/'
        ],
        //
        'manufacturer' => [
            'driver' => 'local',
            'root' => public_path('media/images/gallery/manufacturer/'),
            'url' => 'media/images/gallery/manufacturer/'
        ],
        //
        'slider' => [
            'driver' => 'local',
            'root' => public_path('media/images/gallery/slider/'),
            'url' => 'media/images/gallery/slider/'
        ],
        //
        'blog' => [
            'driver' => 'local',
            'root' => public_path('media/images/gallery/blog/'),
            'url' => 'media/images/gallery/blog/'
        ],
        //
        'landing' => [
            'driver' => 'local',
            'root' => public_path('media/images/gallery/landing/'),
            'url' => 'media/images/gallery/landing/'
        ],
        //
        'page' => [
            'driver' => 'local',
            'root' => public_path('media/images/gallery/page/'),
            'url' => 'media/images/gallery/page/'
        ],
        //
        'user' => [
            'driver' => 'local',
            'root' => public_path('media/images/gallery/user/'),
            'url' => 'media/images/gallery/user/'
        ],
        //
        'widget' => [
            'driver' => 'local',
            'root' => public_path('media/images/gallery/widget/'),
            'url' => 'media/images/gallery/widget/'
        ],
    ],

];
