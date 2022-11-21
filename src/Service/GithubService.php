<?php

namespace App\Service;

use App\Entity\Article;
use Symfony\Component\HttpClient\HttpClient;

class GithubService
{
    public function getQuantity(float $quantity)
    {

        $client = HttpClient::create();

        $response = $client->request('GET', 'https://github.com/Adazajac/WebProject/issues');

        foreach ($response->toArray() as $issue) {

        }

        return $quantity;
    }
}