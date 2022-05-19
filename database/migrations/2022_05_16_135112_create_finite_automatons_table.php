<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finite_automatons', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of_state');
            $table->longText('start_state');
            $table->longText('final_state');
            $table->integer('number_of_symbol');
            $table->longText('symbol');
            $table->longText('transaction');
            $table->longText('transaction_epsilon');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finite_automatons');
    }
};