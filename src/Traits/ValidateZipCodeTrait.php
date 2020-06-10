<?php

declare(strict_types=1);

namespace WideNet\Traits;

trait ValidateZipCodeTrait
{
    /**
     * Checks if a zip code is invalid
     *
     * @param string $zipcode
     * @return boolean
     */
    public function zipCodeValid(string $zipCode): bool
    {
        $zipCode = preg_replace('/[\D]/m', '', $zipCode);

        return (preg_match('/^[0-9]{8}$/m', $zipCode) === 1);
    }
}
