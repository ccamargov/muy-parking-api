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
            $table->foreignId('parking_contract_id')->constrained('parking_contracts')->nulleable(false);
            // Ticket data
            $table->timestamp('entry_time');
            $table->timestamp('exit_time');
            $table->decimal('charge_paid', 2, 2);
            $table->decimal('exchange_value', 2, 2);
            $table->timestamp('payment_time');
            $table->decimal('total_stay_mins', 1, 1);
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
