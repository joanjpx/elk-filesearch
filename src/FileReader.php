<?php

namespace FileSearch;

require '../vendor/autoload.php';
use GuzzleHttp\Client as HttpClient;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;
use getID3 as GlobalGetID3;

class FileReader
{
    private string $user = 'elastic';
    private string $pass = 'gnbit123';
    private array $hosts = [
        [
            'host' => '192.168.10.71',
            'port' => 9200,
            'scheme' => 'https',
        ],
    ];

    public function getAllFilePaths(string $directory = '../files')
    {
        $filePaths = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $filePaths[] = $file->getPathname();
            }
        }

        return $filePaths;
    }

    public function extractFileInfo($filename)
    {
        $getID3 = new GlobalGetID3();
        $fileInfo = $getID3->analyze($filename);

        $metadata = $fileInfo['tags'] ?? [];
        $content = file_get_contents($filename);

        return [
            'metadata' => $metadata,
            'content' => $content,
        ];
    }

    public function insertDocumentToElasticsearch($document)
    {
        $client = (new ClientBuilder)
        ->setBasicAuthentication($this->user, $this->pass)
        ->setHttpClient(new HttpClient(['verify' => false ]))
        ->setHosts(['192.168.10.71:9200'])
        ->build();

        $params = [
            'index' => 'files',
            'type' => '_doc',
            'body' => $document,
        ];

        $response = $client->index($params);
        // ... (handle response or errors)
    }

    private function convertObjectsToArray($data)
    {
        if (is_object($data)) {
            $data = json_decode(json_encode($data), true);
        }
        if (is_array($data)) {
            return json_encode($data, JSON_PRETTY_PRINT);
        }
        return null;
    }

    public function getDocumentsToInsert(array $filePaths): array
    {
        $documents = [];

        foreach ($filePaths as $filePath) {

            $extension = pathinfo($filePath, PATHINFO_EXTENSION);

            if (empty($filePath) || in_array($extension, ['zip', 'rar', 'stl', 'dwg'])) {
                continue;
            }

            $document = [
                'title' => basename($filePath),
                'file_type' => $extension,
                'path' => $filePath,
                'date' => date('Y-m-d H:i:s'),
                'update_date' => date('Y-m-d H:i:s', filemtime($filePath)),
            ];

            if (strpos($document['title'], '~$') === false) {
                echo $document['title'] . "\n";
                $fileInfo = $this->extractFileInfo($filePath);
                $document['metadata'] = $this->convertObjectsToArray($fileInfo['metadata']);
                $document['content'] = $fileInfo['content'];
            }

            $document['metadata'] = json_encode($document['metadata'] ?? null);
            $documents[] = $document;
        }

        return $documents;
    }
}

$reader = new FileReader;
$documents = $reader->getDocumentsToInsert($reader->getAllFilePaths());

foreach ($documents as $document) {
    $reader->insertDocumentToElasticsearch($document);
}

print_r($documents);
