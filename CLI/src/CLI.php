<?php
namespace ElkFilesearch;

require '../vendor/autoload.php'; // Carga el archivo de autoloading


class CLI{

    public function __construct()
    {
        $this->client = HttpClient::create('https://192.168.10.71:9200');
        $this->reader = new FileReader();
    }

    public function execute(string $path)
    {
        try {

            $document = $this->reader->getDocumentToInsert($path);
    
            $response = $this->client->post("/filesearch/_doc",[
                'json' => $document,
            ]);
            
            print_r($response->getBody()->getContents());                   

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            echo "Connection error: " . $e->getMessage();
            echo "\n";
            echo "Exception trace:\n";
            echo $e->getTraceAsString();
        }
    } 

}


$path = $argv[1];

(new CLI)->execute($path);