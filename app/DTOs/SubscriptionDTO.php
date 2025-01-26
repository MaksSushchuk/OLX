<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\Source;

final readonly class SubscriptionDTO
{
    /**
     * SubscriptionDTO constructor.
     */
    public function __construct(
        private string $url,
        private string $email,
        private float $price,
        private Source $source
    ) {
    }

    /**
     * Get the URL of the advertisement.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get the email address of the subscriber.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get the current price of the advertisement.
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Get the source/website of the advertisement.
     *
     * @return Source
     */
    public function getSource(): Source
    {
        return $this->source;
    }

    /**
     * Convert the SubscriptionDTO to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'url' => $this->getUrl(),
            'email' => $this->getEmail(),
            'price' => $this->getPrice(),
            'source' => $this->getSource(),
        ];
    }
}
