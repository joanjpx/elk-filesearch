<?php

declare(strict_types=1);

namespace Search\Service;

use GuzzleHttp\Client;

class ELKClient
{
    public static function create(): Client
    {
        return new Client([
            'base_uri'        => '',
            'timeout'         => 30,
            'verify'          => false, // Ignore SSL certificate
            'max_connections' => 10,
            'headers'         => [
                'Accept' => 'application/json',
                'Authorization' => 'Basic ZWxhc3RpYzpnbmJpdDEyMw=='
            ],

        ]);
    }
}