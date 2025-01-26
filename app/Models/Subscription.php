<?php

declare(strict_types=1);

namespace App\Models;

use App\Collections\SubscriptionCollection;
use App\Enums\Source;
use Illuminate\Database\Eloquent\Attributes\CollectedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $url
 * @property string $email
 * @property float $price
 * @property Source $source
 * @method static SubscriptionCollection<int, Subscription> all($columns = ['*'])
 * @method static SubscriptionCollection<int, Subscription> get($columns = ['*'])
 * @method static Builder<Subscription>|Subscription newModelQuery()
 * @method static Builder<Subscription>|Subscription newQuery()
 * @method static Builder<Subscription>|Subscription query()
 */
#[CollectedBy(SubscriptionCollection::class)]
final class Subscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'email',
        'price',
        'source'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'source' => Source::class,
        'price' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
