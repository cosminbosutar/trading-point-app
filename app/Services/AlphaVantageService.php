<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AlphaVantageService
{
    public const OUTPUT_SIZE_COMPACT = 'compact';
    public const OUTPUT_SIZE_FULL = 'full';

    protected $apiKey;
    protected $baseUrl = 'https://www.alphavantage.co/query';

    public function __construct()
    {
        $this->apiKey = env('ALPHA_VANTAGE_API_KEY');
    }


    /**
     * Fetches intraday stock prices for a given symbol.
     *
     * @param string $symbol The stock symbol for which to fetch intraday price data.
     * @param string $outputSize The amount of data to return ('compact' for the last 100 data points, otherwise 'full').
     * @param string $interval The interval between price points (default is '1min').
     * @param string $dataType The format of the returned data ('json' or 'csv').
     *
     * @return mixed The intraday stock price data in the specified format, or null if the request fails.
     */
    public function getIntradayStockPrice($symbol, $outputSize = 'compact', $interval = '1min', $dataType = 'json')
    {
        $responseData = null;

        $response = Http::get("{$this->baseUrl}", [
            'function' => 'TIME_SERIES_INTRADAY',
            'symbol' => $symbol,
            'apikey' => $this->apiKey,
            'interval' => $interval,
            'outputsize' => $outputSize,
            'datatype' => $dataType
        ]);

        if ($response->successful()) {
            $decodedResponse = $response->json();

            if (array_key_exists('Time Series (1min)', $decodedResponse)) {
                $responseData = $decodedResponse['Time Series (1min)'];
            } elseif (array_key_exists('Information', $decodedResponse)) {
                Log::warning('API rate limit reached!!!!');
            }

        } elseif ($response->clientError()) {
            Log::warning('The following client error occured: {error_code} - {error_text}', [
                'error_code' => $response->status(),
                'error_text' => $response->body()
            ]);

        } elseif ($response->serverError()) {
            Log::warning('The following server error occured: {error_code} - {error_text}', [
                'error_code' => $response->status(),
                'error_text' => $response->body()
            ]);

        }

        return $responseData;
    }
}
