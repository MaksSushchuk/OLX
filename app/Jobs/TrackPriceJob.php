<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\Source;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use App\Services\PriceTracker\Factories\PriceParsingStrategyFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

final class TrackPriceJob implements ShouldQueue
{
    use Queueable;

    private const REPEAT_DELAY = 15;

    private PriceParsingStrategyFactory $strategyFactory;

    public function __construct()
    {
        $this->strategyFactory = new PriceParsingStrategyFactory();
    }

    public function handle(SubscriptionRepository $subscriptionRepository): void
    {
        $subscriptions = $subscriptionRepository
            ->getGroupedByUrl(['url', 'price', 'email', 'source']);

        foreach ($subscriptions as $url => $groupedSubscriptions) {
            $this->processUrlSubscriptions($url, $groupedSubscriptions);
        }

        $this->repeat();
    }

    private function processUrlSubscriptions(string $url, $groupedSubscriptions): void
    {
        $emails = $groupedSubscriptions->pluck('email')->toArray();
        $firstSubscription = $groupedSubscriptions->first();
        $currentPrice = $this->checkPrice($url, $firstSubscription->source);

        if ($this->hasPriceChanged($currentPrice, $firstSubscription->price)) {
            $this->updateSubscriptionsPrice($url, $currentPrice);
            $this->notifyAllUsers($emails, $url, $currentPrice);
        }
    }

    private function hasPriceChanged(?float $currentPrice, ?float $lastPrice): bool
    {
        return $currentPrice !== null && $currentPrice !== $lastPrice;
    }

    private function updateSubscriptionsPrice(string $url, float $currentPrice): void
    {
        Subscription::query()
            ->where('url', $url)
            ->update(['price' => $currentPrice]);
    }

    private function notifyAllUsers(array $emails, string $url, float $newPrice): void
    {
        foreach ($emails as $email) {
            $this->notifyUser($email, $url, $newPrice);
        }
    }

    private function checkPrice(string $url, Source $source): ?float
    {
        $strategy = $this->strategyFactory->getStrategy($source);

        return $strategy->tryParsePrice($url);
    }

    private function notifyUser(string $email, string $url, float $newPrice): void
    {
        $data = [
            'url' => $url,
            'price' => $newPrice,
        ];

        Mail::send('emails.price_change', $data, function ($message) use ($email, $url) {
            $message->to($email)
                ->subject('Price Changed for Ad: '.$url);
        });
    }

    private function repeat(): void
    {
        self::dispatch()->delay(now()->addSeconds(self::REPEAT_DELAY));
    }
}
