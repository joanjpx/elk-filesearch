<?php

namespace ElkFilesearch;

use Exception;
use getID3 as GlobalGetID3;

class FileReader
{
    

    public function getAllFilePaths(string $directory = '../files')
    {
        $filePaths = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        $i = 0;
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $filePaths[] = $file->getPathname();
            }

            
            if($i > 10){
                return $filePaths;
            }
            $i++;
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
                'title' => mb_convert_encoding(basename($filePath), 'UTF-8'),
                'file_type' => mb_convert_encoding($extension, 'UTF-8'),
                'path' => mb_convert_encoding($filePath, 'UTF-8'),
                'date' => date('Y-m-d H:i:s'),
                'update_date' => date('Y-m-d H:i:s', filemtime($filePath)),
            ];
    
            /*if (strpos($document['title'], '~$') === false) {
                echo $document['title'] . "\n";
                $fileInfo = $this->extractFileInfo($filePath);
                $document['metadata'] = $this->convertObjectsToArray($fileInfo['metadata']);
                $document['content'] = $fileInfo['content'];
            }
    
            $document['metadata'] = json_encode($document['metadata'] ?? null, JSON_UNESCAPED_UNICODE);*/
            $documents[] = $document;
        }
    
        return $documents;
    }
}
