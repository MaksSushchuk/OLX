<?php

declare(strict_types=1);

namespace App\Collections;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Collection;

/**
 * @template TKey of array-key
 * @template TModel of Subscription
 *
 * @extends Collection<TKey, TModel>
 */
final class SubscriptionCollection extends Collection
{
}
