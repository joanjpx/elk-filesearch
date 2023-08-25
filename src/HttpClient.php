<?php
namespace ElkFilesearch;

use GuzzleHttp\Client;

class HttpClient
{
    public static function create(string $baseUri): Client
    {

        return new Client([
            'base_uri'        => $baseUri,
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
