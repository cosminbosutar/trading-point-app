<?php

namespace App\Jobs;

use App\Events\NewHighestPrice;
use App\Models\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class CacheLatest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $symbol;

    /**
     * Create a new job instance.
     */
    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** Get the last price saved in DB. */
        $lastStockPrices = Stock::where('symbol', $this->symbol)->orderBy('timestamp', 'desc')->take(2)->get();

        if ($lastStockPrices && (2 === $lastStockPrices->count())) {
            $firstStockPrice = $lastStockPrices->first();
            $secondStockPrice = $lastStockPrices->last();

            /** Clear the cache in needed. */
            if (Cache::has($this->symbol . '_highest')) {
                Cache::delete($this->symbol . '_highest');
            }

            /** Cache the highest stock price. */
            Cache::add($this->symbol . '_highest', $firstStockPrice->close, 60/*seconds*/);

            /** Calculate the movement percentage and the move direction. */
            $movePercentage = (($firstStockPrice->close - $secondStockPrice->close) / $secondStockPrice->close) * 100;
            $moveDirection = ($secondStockPrice->close < $firstStockPrice->close) ? ('up') : (($secondStockPrice->close > $firstStockPrice->close) ? ('down') : ('same'));

            /** Broadcast the new highest price. */
            NewHighestPrice::dispatch($this->symbol, $firstStockPrice->close, $movePercentage, $moveDirection);
        }
    }
}
