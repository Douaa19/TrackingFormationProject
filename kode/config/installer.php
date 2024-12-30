<?php

use App\Enums\StatusEnum;

return [

    'app_name'    => "PixelDesk",
    'software_id' => "PXL0001==",
    'cacheFile' => 'LktvZGVfUGl4ZWw=',
    
    'core' => [
        'appVersion' => '2.1',
        'minPhpVersion' => '8.1',
    ],

    'requirements' => [

        'php' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL',
            'gd',

        ],
        'apache' => [
            'mod_rewrite',
        ],

    ],
    'permissions' => [
        '.env'     => '666',
        'storage/framework/'     => '775',
        'storage/logs/'          => '775',
        'bootstrap/cache/'       => '775', 
    ],

];