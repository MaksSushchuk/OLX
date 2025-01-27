<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Services\PriceTracker\PriceTrackerService;
use Illuminate\Http\JsonResponse;

final class SubscribeController extends Controller
{
    public function __construct(private readonly PriceTrackerService $priceTrackerService)
    {
    }

    public function __invoke(SubscribeRequest $request): JsonResponse
    {
        return response()
            ->json(
                data: [
                    'success' => $this->priceTrackerService->subscribe($request->url, $request->email),
                ]
            );
    }
}
