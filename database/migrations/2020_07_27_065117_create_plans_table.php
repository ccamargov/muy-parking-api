<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->boolean('has_daily_payment')->nullable(false)->default(false);
            $table->decimal('daily_payment_charge')->nullable();
            $table->boolean('has_monthly_dynamic_payment')->nullable(false)->default(false);
            $table->decimal('monthly_dynamic_payment_charge')->nullable();
            $table->boolean('has_monthly_static_payment')->nullable(false)->default(false);
            $table->decimal('monthly_static_payment_charge')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
