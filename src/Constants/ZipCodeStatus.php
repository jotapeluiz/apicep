<?php

declare(strict_types=1);

namespace WideNet\Constants;

/**
 * Represents the return status of the API
 */
final class ZipCodeStatus
{
    const FOUND = 200;

    const INVALID = 400;
    
    const NOT_FOUND = 404;
}
