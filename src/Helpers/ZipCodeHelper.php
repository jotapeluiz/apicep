<?php declare(strict_types=1);

namespace WideNet\Helpers;

final class ZipCodeHelper
{
    /**
     * Checks if a zip code is invalid
     *
     * @param string $zipcode
     * @return boolean
     */
    public static function isValid(string $zipcode): bool
    {
        return (preg_match('/^[0-9]{8}$/m', preg_replace('/[\D]/m', '', $zipcode)) === 1);
    }
}
