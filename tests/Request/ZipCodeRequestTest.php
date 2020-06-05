<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use APICEP\Request\ZipCodeRequest;
use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ZipCodeRequestTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('pt_BR');
    }
    
    public function testShouldReturnDataFromAnAddressWithAValidZipCode()
    {        
        $body = $this->validAddressData();
        $request = $this->buildRequest(200, $body);

        $this->assertEquals($request->search($this->faker->postcode), $body);
    }

    public function testShouldReturnTheDataWithAnInvalidZipCode()
    {        
        $body = $this->invalidAddressData();
        $request = $this->buildRequest(200, $body);

        $this->assertEquals($request->search(''), $body);
    }

    public function testMustReturnDataWithANonexistentZipCode()
    {        
        $body = $this->addressDataNotFound();
        $request = $this->buildRequest(200, $body);

        $this->assertEquals($request->search($this->faker->phoneNumber), $body);
    }

    public function testShouldThrowExceptionWhenAnErrorOccursInTheRequest()
    {                
        $this->expectException(GuzzleHttp\Exception\RequestException::class);
        $this->expectExceptionCode(500);

        $request = $this->buildRequest(500, []);
        $request->search($this->faker->postcode);
    }

    private function validAddressData(): array
    {
        return [
            'status' => 200,
            'ok' => true,
            'code' => $this->faker->postcode,
            'state' => $this->faker->stateAbbr,
            'city' => $this->faker->city,
            'district' => $this->faker->state,
            'address' => $this->faker->streetName,
            'statusText' => 'ok'
        ];
    }

    private function addressDataNotFound(): array
    {
        return [
            'status' => 404,
            'ok' => false,
            "message" => 'CEP não encontrado',
            "statusText" => 'not_found'
        ];
    }

    private function invalidAddressData(): array
    {
        return [
            'status' => 400,
            'ok' => false,
            "message" => 'CEP informado é inválido',
            "statusText" => 'bad_request'            
        ];
    }

    private function buildRequest(int $status, array $body = null): ZipCodeRequest
    {        
        $mock = new MockHandler([new Response($status, [], json_encode($body))]);
        $handler = HandlerStack::create($mock);
        
        return new ZipCodeRequest(new Client(['handler' => $handler]));
    }
}
