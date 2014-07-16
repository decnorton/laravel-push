<?php return [

    // Used to create object when passing an array of registration IDs.
    // Must implement DeviceInterface
    'device_model'    => 'Device',

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