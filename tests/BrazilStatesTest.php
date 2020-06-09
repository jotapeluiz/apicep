<?php

declare(strict_types=1);

namespace WideNet\Tests;

use PHPUnit\Framework\TestCase;
use WideNet\BrazilStates;
use WideNet\Exceptions\StateNotFoundException;

final class BrazilStatesTest extends TestCase
{
    private $brazilStates;

    protected function setUp(): void
    {
        $this->brazilStates = new BrazilStates();
    }

    public function testWhenPassingAnAcronymMustReturnTheStateName()
    {
        $this->assertEquals('Minas Gerais', $this->brazilStates->name('MG'));
    }

    public function testWhenPassingALowercaseAcronymMustReturnTheStateName()
    {
        $this->assertEquals('Rio de Janeiro', $this->brazilStates->name('rj'));
    }

    public function testWhenPassingAnAcronymWithUpperOrLowerCaseMustReturnTheStateName()
    {
        $this->assertEquals('Distrito Federal', $this->brazilStates->name('Df'));
    }

    public function testShouldGenerateExceptionWhenPassingAnInvalidAcronym()
    {
        $this->expectException(StateNotFoundException::class);

        $this->brazilStates->name('');
    }

    public function testShouldGenerateExceptionWhenPassingAnNonexistentAcronym()
    {
        $this->expectException(StateNotFoundException::class);

        $this->brazilStates->name('AaA');
    }
}
