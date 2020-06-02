<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Faker\Factory;
use APICEP\ZipCode;
use APICEP\Exceptions\AttributeNotFoundException;
use APICEP\Exceptions\UpdateAttributeException;
use ReflectionClass;

final class ZipCodeTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('pt_BR');
    }

    public function testWithAnInvalidZipNumber()
    {
        $zipcode = new ZipCode($this->faker->phoneNumber);
        
        $this->assertTrue($zipcode->isInvalid());
        $this->assertFalse($zipcode->wasFound());
    }

    public function testWithAnValidZipNumber()
    {        
        $address = $this->validAddress();

        $class = new ReflectionClass(ZipCode::class);
        $instance = $class->newInstanceArgs(['zipcode' => '']);
        
        $property = $class->getProperty('attributes');
        $property->setAccessible(true);
        $property->setValue($instance, $address);
        
        $property = $class->getProperty('found');
        $property->setAccessible(true);
        $property->setValue($instance, true);
        
        $toString = "{$instance->address}, {$instance->district}, {$instance->city} - {$instance->state}, {$instance->code}";

        $this->assertTrue($class->getMethod('wasFound')->invoke($instance));
        $this->assertEquals($address, $class->getMethod('toArray')->invoke($instance));
        $this->assertEquals(json_encode($address), $class->getMethod('toJson')->invoke($instance));
        $this->assertEquals($toString, $class->getMethod('__toString')->invoke($instance));
    }

    public function testShouldGenerateExceptionWhenAccessingAnAttributeNotFound()
    {                
        $this->expectException(AttributeNotFoundException::class);
        
        $zipcode = new ZipCode('');
        $zipcode->foo;
    }

    public function testShouldGenerateExceptionWhenTryingToChangeAnAttribute()
    {                
        $this->expectException(UpdateAttributeException::class);
        
        $zipcode = new ZipCode('');
        $zipcode->foo = $this->faker->postcode;
        $zipcode->code = $this->faker->postcode;
    }

    private function validAddress(): array
    {
        return [
            'code' => $this->faker->postcode,
            'state' => $this->faker->stateAbbr,
            'city' => $this->faker->city,
            'district' => $this->faker->state,
            'address' => $this->faker->streetName
        ];
    }
}