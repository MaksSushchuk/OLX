<?php

declare(strict_types=1);

namespace App\Services\PriceTracker\Abstracts;

use App\Services\PriceTracker\Exceptions\HttpRequestException;
use App\Services\PriceTracker\Exceptions\PriceParsingException;
use Illuminate\Support\Facades\Log;

abstract class PriceParsingStrategy
{
    /**
     * Parse the price from the provided URL.
     *
     * @throws PriceParsingException
     * @throws HttpRequestException
     */
    abstract protected function parsePrice(string $url): ?float;

    public function tryParsePrice($url): ?float
    {
        try {
            return $this->parsePrice($url);
        } catch (PriceParsingException|HttpRequestException $e) {
            Log::error(
                'Failed to parse price.',
                context: [
                    'url' => $url,
                    'message' => $e->getMessage(),
                ]
            );

            return null;
        }
    }
}
