<?php

declare(strict_types=1);

namespace App\Services\PriceTracker\Strategies;

use App\Services\PriceTracker\Abstracts\PriceParsingStrategy;
use App\Services\PriceTracker\Exceptions\HttpRequestException;
use App\Services\PriceTracker\Exceptions\PriceParsingException;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class OlxPriceParsingStrategy extends PriceParsingStrategy
{
    /**
     * @throws PriceParsingException
     * @throws HttpRequestException
     */
    protected function parsePrice(string $url): float
    {
        $response = $this->fetchHtml($url);
        $priceText = $this->extractPriceText($response->body(), $url);

        return $this->sanitizePrice($priceText);
    }

    /**
     * Fetch the HTML content of the given URL.
     *
     * @throws HttpRequestException
     */
    private function fetchHtml(string $url): Response
    {
        $response = Http::get($url);

        if ($response->failed()) {
            throw new HttpRequestException($url, $response->status());
        }

        return $response;
    }

    /**
     * Extract the price text from the HTML body.
     *
     * @throws PriceParsingException
     */
    private function extractPriceText(string $html, string $url): string
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $priceNode = $xpath->query('//div[@data-testid="prices-wrapper"]//h3[@class="css-fqcbii"]');

        if ($priceNode->length === 0) {
            throw new PriceParsingException($url);
        }

        return $priceNode->item(0)->textContent;
    }

    /**
     * Sanitize the price text and convert it to a float.
     */
    private function sanitizePrice(string $priceText): float
    {
        return (float) str_replace([' ', 'грн.', 'грн'], '', $priceText);
    }
}
