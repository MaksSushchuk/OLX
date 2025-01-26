<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Collections\SubscriptionCollection;
use App\DTOs\SubscriptionDTO;
use App\Models\Subscription;

final readonly class SubscriptionRepository
{
    public function __construct(private Subscription $model)
    {
    }

    public function getGroupedByUrl(array $columns = ['*']): SubscriptionCollection
    {
        return $this->model::query()
            ->select(columns: $columns)
            ->get()
            ->groupBy('url');
    }

    public function create(SubscriptionDTO $dto)
    {
        return $this->model::query()
            ->create($dto->toArray());
    }
}
