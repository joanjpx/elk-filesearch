<?php


namespace ElkFilesearch;

use GuzzleHttp\Client;
use ElkFilesearch\HttpClient;
use ElkFilesearch\FileReader;


class Main{

    public function __construct()
    {
        $this->client = HttpClient::create('https://192.168.10.71:9200');
        $this->reader = new FileReader();
    }

    public function execute()
    {
        try {
            //$response = $this->client->get("/");
            //$statusCode = $response->getStatusCode();


            $path = '/home/benjamin/shared_win/IA-TEST/ING/';

            $documents = $this->reader->getDocumentsToInsert($this->reader->getAllFilePaths($path));
    
            $i = 1;
            foreach ($documents as $document) {
                $response = $this->client->post("/files/_doc/".$i,[
                    'json' => $document,
                ]);
                
                print_r($response->getBody()->getContents());                   

                $i++;
            }


            /*if ($statusCode === 200) {
                $body = $response->getBody()->getContents();
                print_r($body);
            } else {
                echo "Unexpected response status code: $statusCode";
            }*/
        } catch (GuzzleHttp\Exception\ConnectException $e) {
            echo "Connection error: " . $e->getMessage();
            echo "\n";
            echo "Exception trace:\n";
            echo $e->getTraceAsString();
        }
    } 

}


require 'vendor/autoload.php'; // Carga el archivo de autoloading
(new Main)->execute();