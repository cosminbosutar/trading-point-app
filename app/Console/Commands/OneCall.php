<?php

namespace App\Console\Commands;

use App\Services\AlphaVantageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class OneCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:one-call';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command used for extracting and logging 1 data set from Alpha Vantage API.';

    protected $alphaVantageService;


    public function __construct(AlphaVantageService $alphaVantageService)
    {
        parent::__construct();

        $this->alphaVantageService = $alphaVantageService;
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** Get the last 100 intraday stock price changes. */
        Log::debug(print_r($this->alphaVantageService->getIntradayStockPrice('AAPL'), 1));
    }
}
