<?php
namespace ElkFilesearch;

require '../vendor/autoload.php'; // Carga el archivo de autoloading

class Api
{
    public function __construct()
    {
        $this->client = HttpClient::create('https://192.168.10.71:9200');
        $this->reader = new FileReader();
    }


    public function search(string $search) : string
    {
        $response = $this->client->post("/filesearch/_search?q=*".$search."*");
        
        print_r($response->getBody()->getContents());exit;
    }
}

$searchTerm = $_GET['q'];

(new Api)->search($searchTerm);