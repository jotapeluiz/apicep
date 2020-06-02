<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use APICEP\Helpers\ZipCodeHelper;

class ZipCodeHelperTest extends TestCase
{
    public function testWhenPassingAZipCodeMustReturnWhichIsValid()
    {        
        $this->assertTrue(ZipCodeHelper::isValid('99999-999'));
        $this->assertTrue(ZipCodeHelper::isValid('99999999'));
    }

    public function testWhenPassingAnInvalidZipCodeShouldReturnFalse()
    {        
        $this->assertFalse(ZipCodeHelper::isValid('99999'));
        $this->assertFalse(ZipCodeHelper::isValid('999999999'));
        $this->assertFalse(ZipCodeHelper::isValid('lorem ipsum'));
        $this->assertFalse(ZipCodeHelper::isValid(''));
        $this->assertFalse(ZipCodeHelper::isValid(' '));
    }
}
