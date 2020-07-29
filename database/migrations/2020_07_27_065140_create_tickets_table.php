<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            // Define model relations
            $table->foreignId('parking_contract_id')->constrained('parking_contracts')->nullable(false);
            // Ticket data
            $table->timestamp('entry_time')->nullable(false);
            $table->timestamp('exit_time')->nullable();
            $table->decimal('charge_paid', 2, 2)->nullable();
            $table->decimal('exchange_value', 2, 2)->nullable();
            $table->timestamp('payment_time')->nullable();
            $table->decimal('total_stay_mins', 1, 1)->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
