<?php

declare(strict_types=1);

namespace App\Services\PriceTracker\Exceptions;

use Exception;

class HttpRequestException extends Exception
{
    /**
     * Create a new HttpRequestException instance.
     */
    public function __construct(string $url, int $status)
    {
        $errorMessage = "HTTP request to $url failed with status code $status.";

        parent::__construct($errorMessage);
    }
}
