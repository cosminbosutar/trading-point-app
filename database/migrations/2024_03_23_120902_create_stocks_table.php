<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            $table->string('symbol', 15)->index();
            $table->timestamp('timestamp')->index();
            $table->float('open');
            $table->float('high');
            $table->float('low');
            $table->float('close')->index();
            $table->unsignedBigInteger('volume'); // Probably can be of type unsignedInteger

            $table->timestamps();

            $table->unique(['symbol', 'timestamp']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
