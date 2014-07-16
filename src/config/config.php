<?php return [

    'android' => [
        'service'     => 'gcm',
        'development' => true,

        'api_key'     => 'API_KEY'
    ],

    'ios' => [
        'service'     => 'apns',
        'development' => true,

        'certificate' => '/path/to/certificate.pem',
        'passPhrase'  => 'password'
    ]

];