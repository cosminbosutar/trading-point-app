<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Services\AlphaVantageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetFullIntradayData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $alphaVantageService;
    protected $symbol;

    /**
     * Create a new job instance.
     */
    public function __construct(AlphaVantageService $alphaVantageService, $symbol)
    {
        $this->alphaVantageService = $alphaVantageService;
        $this->symbol = $symbol;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** Get the last 100 intraday stock price changes. */
        $stockPrices = $this->alphaVantageService->getIntradayStockPrice($this->symbol, AlphaVantageService::OUTPUT_SIZE_FULL);

        /** Check if we received any data. */
        if ($stockPrices) {
            /** Get the last timestamp saved in DB. */
            $lastStockPrice = Stock::where('symbol', $this->symbol)->orderBy('timestamp', 'desc')->first();
            /** Create a local buffer that holds all the new stock prices and a counter. */
            $newStockPrices = [];
            $newStockPricesCount = 0;

            foreach ($stockPrices as $dateKey => $stockPrice) {
                if (!$lastStockPrice || ($lastStockPrice && $lastStockPrice->timestamp->lt($dateKey))) {
                    $newStockPrices[] = [
                        'symbol' => $this->symbol,
                        'timestamp' => $dateKey,
                        'open' => $stockPrice['1. open'],
                        'high' => $stockPrice['2. high'],
                        'low' => $stockPrice['3. low'],
                        'close' => $stockPrice['4. close'],
                        'volume' => $stockPrice['5. volume']
                    ];

                    $newStockPricesCount++;
                }

                /** CHeck if we saved 1000 new rows. */
                if (1000 === $newStockPricesCount) {
                    /** Bulk insert every 1000 rows. */
                    Stock::insert($newStockPrices);

                    /** Reset the local buffer and counter. */
                    $newStockPrices = [];
                    $newStockPricesCount = 0;
                }
            }

            /** Save the last batch of data. */
            Stock::insert($newStockPrices);
        }
    }
}
