<?php

namespace App\Console\Commands;

use App\Jobs\GetFullIntradayData;
use App\Services\AlphaVantageService;
use Illuminate\Console\Command;

class InitialDataExtraction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initial-data-extraction';

    protected $alphaVantageService;


    public function __construct(AlphaVantageService $alphaVantageService)
    {
        parent::__construct();

        $this->alphaVantageService = $alphaVantageService;
    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** Get the list of stockes to be imported every minute. */
        $symbols = explode(';', env('ALPHA_VANTAGE_STOCKS_LIST', ''));

        /**
         * Parse all specified symbols and schedule an every minute job
         *  to extract the data from the Alpha Vantage API.
         */
        foreach ($symbols as $symbol) {
            GetFullIntradayData::dispatch($this->alphaVantageService, $symbol);
        }
    }
}
