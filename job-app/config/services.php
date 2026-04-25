<?php

        return [

            /*
            |--------------------------------------------------------------------------
            | Default Filesystem Disk
            |--------------------------------------------------------------------------
            |
            | Here you may specify the default filesystem disk that should be used
            | by the framework. The "local" disk, as well as a variety of cloud
            | based disks are available to your application. Explore them all!
            |
            */

            'default' => env('FILESYSTEM_DISK', 'local'),

            /*
            |--------------------------------------------------------------------------
            | Filesystem Disks
            |--------------------------------------------------------------------------
            |
            | Here you may configure as many filesystem "disks" as you wish, and you
            | may even configure multiple disks of the same driver. Defaults have
            | been set for each client as an example of the required values.
            |
            */

            'disks' => [

                'local' => [
                    'driver' => 'local',
                    'root' => storage_path('app'),
                    'throw' => false,
                ],

                'public' => [
                    'driver' => 'local',
                    'root' => storage_path('app/public'),
                    'url' => env('APP_URL') . '/storage',
                    'visibility' => 'public',
                    'throw' => false,
                ],

                'cloud' => [
                    'driver' => 's3',
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    'region' => env('AWS_DEFAULT_REGION'),
                    'bucket' => env('AWS_BUCKET'),
                    'url' => env('AWS_URL'),
                    'endpoint' => env('AWS_ENDPOINT'),
                    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
                    'throw' => true,
                ],


            ],

            /*
            |--------------------------------------------------------------------------
            | Symbolic Links
            |--------------------------------------------------------------------------
            |
            | Here you may configure the symbolic links that will be created when the
            | `storage:link` Artisan command is run. The array keys should be
            | the locations of the links and the values should be their targets.
            |
            */

            'gemini' => [
                    'key' => env('GEMINI_API_KEY'),
                ],


            'links' => [
                public_path('storage') => storage_path('app/public'),
            ],

        ];
