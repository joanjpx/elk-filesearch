<?php

declare(strict_types=1);

namespace Search\Service;

class ELKService
{
    
    public function search(string $search)
    {
        $response = ELKClient::create()->post("/filesearch/_search?q=*".$search."*");
        
        return json_decode($response->getBody()->getContents(), true);
    }
}