<?php

namespace Database\Seeders;

use App\Models\Stock;
// use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $timestamp = Carbon::now()->subHours(600);

        for ($i=0; $i < 36000; $i++) {
            Stock::factory()->create([
                'timestamp' => $timestamp->format('Y-m-d H:i:s')
            ]);

            $timestamp->addMinute();
        }
    }
}
