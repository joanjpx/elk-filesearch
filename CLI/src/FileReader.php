<?php

namespace ElkFilesearch;

use Exception;
use getID3 as GlobalGetID3;


class FileReader
{

    const ALLOWED_EXTENSIONS = ['doc','docx'];
    

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
                
                $extension = pathinfo($file->getPathname(), PATHINFO_EXTENSION);
                if(in_array($extension,['doc','docx'])){
                    $filePaths[] = $file->getPathname();
                    $i++;
                }
            }

            if($i > 10000){
                return $filePaths;
            }
        }

        return $filePaths;
    }
    
    public function getAllMetaTags($filePath) {

        $metaTags = get_meta_tags($filePath);
        return $metaTags;
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

    public function getContentFromDocument(string $path) : string
    {
        $document = \PhpOffice\PhpWord\IOFactory::load($path); // Cambia la ruta al documento que deseas procesar

        $content = '';

        // Recorre todos los elementos del documento y extrae el contenido de texto
        foreach ($document->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    foreach ($element->getElements() as $textElement) {
                        if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                            $content .= $textElement->getText();
                        }
                    }
                }
            }
        }

        return $content; // Imprime el contenido extraído del documento
    }

    public function getDocumentsToInsert(array $filePaths): array
    {
        $documents = [];
    
        foreach ($filePaths as $filePath) 
        {
            $document = $this->getDocumentToInsert($filePath);

            if(!empty($document))
            {
                $documents[] = $document;
            }
        }
    
        return $documents;
    }

    public function getDocumentToInsert(string $filePath) : array
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    
        if (empty($filePath) || in_array($extension, ['zip', 'rar', 'stl', 'dwg']) || strpos($filePath, '$')) 
        {
            return null;
        }

        if(in_array($extension, self::ALLOWED_EXTENSIONS))
        {
            $document = [
                'title' => mb_convert_encoding(basename($filePath), 'UTF-8'),
                'file_type' => mb_convert_encoding($extension, 'UTF-8'),
                'path' => mb_convert_encoding($filePath, 'UTF-8'),
                'date' => date('Y-m-d H:i:s'),
                'update_date' => date('Y-m-d H:i:s', filemtime($filePath)),
            ];
            
            $document['metadata'] = $this->getAllMetaTags($filePath);
            $document['body'] = $this->getContentFromDocument($filePath);

            $documents[] = $document;
        }
    }
}
