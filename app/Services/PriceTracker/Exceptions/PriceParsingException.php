<?php

declare(strict_types=1);

namespace App\Services\PriceTracker\Exceptions;

use Exception;

final class PriceParsingException extends Exception
{
    /**
     * Create a new PriceParsingException instance.
     */
    public function __construct(string $url)
    {
        parent::__construct("Unable to parse the price from the provided URL: {$url}");
    }
}
