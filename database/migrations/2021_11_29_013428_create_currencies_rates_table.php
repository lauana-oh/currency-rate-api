<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('from', 3);
            $table->char('to', 3);
            $table->float('quote', 16, 4);
            $table->date('date');
            $table->timestamps();

            $table->unique(['from', 'to', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_rates');
    }
}
