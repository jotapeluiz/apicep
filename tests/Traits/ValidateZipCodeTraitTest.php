<?php

declare(strict_types=1);

namespace WideNet\Tests\Traits;

use PHPUnit\Framework\TestCase;
use WideNet\Traits\ValidateZipCodeTrait;

class ValidateZipCodeTraitTest extends TestCase
{
    use ValidateZipCodeTrait;

    public function testWhenPassingAZipCodeMustReturnWhichIsValid()
    {
        $this->assertTrue($this->zipCodeValid('99999-999'));
        $this->assertTrue($this->zipCodeValid('99999999'));
    }

    public function testWhenPassingAnInvalidZipCodeShouldReturnFalse()
    {
        $this->assertFalse($this->zipCodeValid('99999'));
        $this->assertFalse($this->zipCodeValid('999999999'));
        $this->assertFalse($this->zipCodeValid('lorem ipsum'));
        $this->assertFalse($this->zipCodeValid(''));
        $this->assertFalse($this->zipCodeValid(' '));
    }
}
