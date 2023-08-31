<?php

declare(strict_types=1);

namespace Search\Service;

class ELKService
{

    public function search(string $search)
    {
        $response = ELKClient::create()->post("/files/_search?q=*" . $search . "*");

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function getUrlsFilePath(): string
    {
        return __DIR__ . '/../../../../public/urls.json';
    }

    // Function to read URLs from the JSON file
    public function readUrls()
    {
        $fileContents = file_get_contents($this->getUrlsFilePath());
        $urls = json_decode($fileContents, true);
        return $urls;
    }

    // Function to write URLs to the JSON file
    public function writeUrls($urls)
    {
        $jsonString = json_encode($urls, JSON_PRETTY_PRINT);
        file_put_contents($this->getUrlsFilePath(), $jsonString);
    }

    // Function to add a new URL
    public function addUrl($url)
    {
        $urls = $this->readUrls();
        $urls[] = $url;
        $this->writeUrls($urls);
    }

    // Function to update an existing URL
    public function updateUrl($index, $newUrl)
    {
        $urls = $this->readUrls();
        if (isset($urls[$index])) {
            $urls[$index] = $newUrl;
            $this->writeUrls($urls);
        }
    }

    // Function to delete a URL
    public function deleteUrl($index)
    {
        $urls = $this->readUrls();
        if (isset($urls[$index])) {
            array_splice($urls, $index, 1);
            $this->writeUrls($urls);
        }
    }
}
