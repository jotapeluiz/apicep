<?php

declare(strict_types=1);

namespace WideNet\Tests;

use PHPUnit\Framework\TestCase;
use Faker\Factory;
use ReflectionClass;
use WideNet\ZipCode;
use WideNet\Exceptions\AttributeNotFoundException;
use WideNet\Exceptions\UpdateAttributeException;

final class ZipCodeTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('pt_BR');
    }

    public function testWithAnInvalidZipNumber()
    {
        $zipCode = new ZipCode($this->faker->phoneNumber);
        
        $this->assertTrue($zipCode->isInvalid());
        $this->assertFalse($zipCode->wasFound());
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
        
        $zipCode = new ZipCode('');
        $zipCode->foo;
    }

    public function testShouldGenerateExceptionWhenTryingToChangeAnAttribute()
    {
        $this->expectException(UpdateAttributeException::class);
        
        $zipCode = new ZipCode('');
        $zipCode->foo = $this->faker->postcode;
        $zipCode->code = $this->faker->postcode;
    }

    private function validAddress(): array
    {
        return [
            'code' => $this->faker->postcode,
            'state' => $this->faker->stateAbbr,
            'stateName' => $this->faker->state,
            'city' => $this->faker->city,
            'district' => $this->faker->state,
            'address' => $this->faker->streetName
        ];
    }
}
