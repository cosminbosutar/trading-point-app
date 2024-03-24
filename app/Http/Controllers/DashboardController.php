<?php

namespace App\Http\Controllers;

use App\Models\Stock;

class DashboardController extends Controller
{
    public const LAST_PRICES_COUNT = 10;

    public function index()
    {
        $dashboardData = [];

        /** Get the list of stockes to be imported every minute. */
        $symbols = explode(';', env('ALPHA_VANTAGE_STOCKS_LIST', ''));

        foreach ($symbols as $symbol) {
            /** Get the last self::LAST_PRICES_COUNT prices and max price. */
            $lastStockPrices = Stock::where('symbol', $symbol)->orderBy('timestamp', 'desc')->take(self::LAST_PRICES_COUNT)->get(['timestamp', 'close']);
            $maxStockPrice = Stock::where('symbol', $symbol)->orderBy('timestamp', 'desc')->first();

            /**
             * Check if we have at least 2 elements to calculate
             *  the movement percentage and the move direction.
             */
            $movePercentage = 0;
            $moveDirection = 'same';
            if ($lastStockPrices && (2 === $lastStockPrices->count())) {
                /** Get the first and second prices. */
                $firstStockPrice = $lastStockPrices->first();
                $secondStockPrice = $lastStockPrices->get(1);

                /** Calculate the movement percentage and the move direction. */
                $movePercentage = (($firstStockPrice->close - $secondStockPrice->close) / $secondStockPrice->close) * 100;
                $moveDirection = ($secondStockPrice->close < $firstStockPrice->close) ? ('up') : (($secondStockPrice->close > $firstStockPrice->close) ? ('down') : ('same'));
            }

            $dashboardData[$symbol] = [
                'max' => ($maxStockPrice) ? ($maxStockPrice->close) : (0),
                'movePercentage' => $movePercentage,
                'moveDirection' => $moveDirection,
                'graphLabels' => $lastStockPrices->pluck('timestamp')->all(),
                'graphData' => $lastStockPrices->pluck('close')->all()
            ];
        }

        return view('dashboard', compact('dashboardData'));
    }
}
