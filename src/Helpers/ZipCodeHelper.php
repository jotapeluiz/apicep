<?php declare(strict_types=1);

namespace WideNet\Helpers;

final class ZipCodeHelper
{
    public static function isValid(string $zipcode): bool
    {        
        return (preg_match('/^[0-9]{8}$/m', preg_replace('/[\D]/m', '', $zipcode)) === 1);
    }
}
