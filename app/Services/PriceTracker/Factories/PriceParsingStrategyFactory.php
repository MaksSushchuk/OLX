<?php

declare(strict_types=1);

namespace App\Services\PriceTracker\Factories;

use App\Enums\Source;
use App\Services\PriceTracker\Abstracts\PriceParsingStrategy;
use App\Services\PriceTracker\Strategies\OlxPriceParsingStrategy;
use InvalidArgumentException;

final class PriceParsingStrategyFactory
{
    /**
     * Get the appropriate price parsing strategy based on the source.
     *
     * @param Source $source The source of the advertisement.
     * @return PriceParsingStrategy
     */
    public function getStrategy(Source $source): PriceParsingStrategy
    {
        return match ($source) {
            Source::Olx => new OlxPriceParsingStrategy(),
            default => throw new InvalidArgumentException('Unsupported source: '.$source->value),
        };
    }
}
