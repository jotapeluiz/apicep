<?php declare(strict_types=1);

namespace APICEP\Exceptions;

use Exception;

final class UpdateAttributeException extends Exception
{
    public function __construct(string $message, int $code = 0, Exception $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }
}

