<?php

namespace Gabrielmoura\LaravelCep;

use DomainException;
use Exception;
use Illuminate\Support\Facades\Log;

class CepException extends DomainException
{
    /**
     * Create a new exception instance.
     */
    public function __construct(string $message, int $code = 0, ?Exception $previous = null)
    {
        $message = "CEP: $message";
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error($this->getMessage());
    }
}
