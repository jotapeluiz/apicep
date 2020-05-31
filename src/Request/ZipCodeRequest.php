<?php declare(strict_types=1);

namespace APICEP\Request;

use GuzzleHttp\Client;

final class ZipCodeRequest
{
    private $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ?? new Client(['base_uri' => 'https://ws.apicep.com/cep/']);
    }

    public function search(string $zipcode): array
    {
        $response = $this->client->get("$zipcode.json");
        
        return json_decode($response->getBody()->getContents(), true);
    }
}
