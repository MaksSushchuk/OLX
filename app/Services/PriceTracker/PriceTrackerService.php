<?php

declare(strict_types=1);

namespace App\Services\PriceTracker;

use App\DTOs\SubscriptionDTO;
use App\Enums\Source;
use App\Jobs\TrackPriceJob;
use App\Repositories\SubscriptionRepository;
use App\Services\PriceTracker\Factories\PriceParsingStrategyFactory;

final readonly class PriceTrackerService
{
    public function __construct(
        private SubscriptionRepository $repository,
        private PriceParsingStrategyFactory $parsingStrategyFactory
    ) {
    }

    public function subscribe(string $url, string $email, Source $source = Source::Olx): bool
    {
        $strategy = $this->parsingStrategyFactory->getStrategy($source);
        $price = $strategy->tryParsePrice($url);

        if (is_null($price)) {
            return false;
        }

        $subscriptionDTO = new SubscriptionDTO($url, $email, $price, $source);
        $this->repository->create($subscriptionDTO);

        TrackPriceJob::dispatch();

        return true;
    }
}
