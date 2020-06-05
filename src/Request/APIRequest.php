<?php declare(strict_types=1);

namespace WideNet\Request;

use GuzzleHttp\Client;

final class APIRequest
{
    private $clientHttp;

    public function __construct(Client $clientHttp = null)
    {
        $this->clientHttp = $clientHttp ?? new Client(['base_uri' => 'https://ws.WideNet.com/cep/']);
    }

    public function get(string $zipcode): array
    {
        $response = $this->clientHttp->get("$zipcode.json");
        
        return json_decode($response->getBody()->getContents(), true);
    }
}
