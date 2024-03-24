<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\CacheLatest;
use App\Jobs\GetCompactIntradayData;
use App\Services\AlphaVantageService;


/** Get the list of stocks to be imported every minute. */
$symbols = explode(';', env('ALPHA_VANTAGE_STOCKS_LIST', ''));
$alphaVantageService = new AlphaVantageService;


/**
 * Parse all specified symbols and schedule an every minute job
 *  to extract the data from the Alpha Vantage API.
 */
foreach ($symbols as $symbol) {
    Schedule::job(new GetCompactIntradayData($alphaVantageService, $symbol))->everyMinute();
}


/**
 * Parse all specified symbols and schedule an every minute job
 *  to extract the latest price from DB, cache it and broadcast it.
 */
foreach ($symbols as $symbol) {
    Schedule::job(new CacheLatest($symbol))->everyMinute();
}
