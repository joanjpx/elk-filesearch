<?php
namespace ElkFilesearch;

require '../vendor/autoload.php'; // Carga el archivo de autoloading


class Main{

    public function __construct()
    {
        $this->client = HttpClient::create('https://192.168.10.71:9200');
        $this->reader = new FileReader();
    }

    public function execute()
    {
        try {

            $path = '../files';

            $documents = $this->reader->getDocumentsToInsert($this->reader->getAllFilePaths($path));
    
            $i = 1;
            
            foreach ($documents as $document) 
            {
                $response = $this->client->post("/filesearch/_doc",[
                    'json' => $document,
                ]);
                
                print_r($response->getBody()->getContents());                   

                $i++;
            }

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            echo "Connection error: " . $e->getMessage();
            echo "\n";
            echo "Exception trace:\n";
            echo $e->getTraceAsString();
        }
    } 

}


(new Main)->execute();