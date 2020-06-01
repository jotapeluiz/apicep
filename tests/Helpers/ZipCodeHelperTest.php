<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use APICEP\Helpers\ZipCodeHelper;

class ZipCodeHelperTest extends TestCase
{
    public function testWhenPassingAZipCodeMustReturnWhichIsValid()
    {        
        $this->assertTrue(ZipCodeHelper::valid('99999-999'));
        $this->assertTrue(ZipCodeHelper::valid('99999999'));
    }

    public function testWhenPassingAnInvalidZipCodeShouldReturnFalse()
    {        
        $this->assertFalse(ZipCodeHelper::valid('99999'));
        $this->assertFalse(ZipCodeHelper::valid('999999999'));
        $this->assertFalse(ZipCodeHelper::valid('lorem ipsum'));
        $this->assertFalse(ZipCodeHelper::valid(''));
        $this->assertFalse(ZipCodeHelper::valid(' '));
    }
}
