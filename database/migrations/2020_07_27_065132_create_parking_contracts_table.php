<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('owner_id', 20)->nullable(false);
            $table->string('vehicle_id', 10)->nullable(false);
            $table->unsignedBigInteger('plan_id')->nullable(false);
            $table->timestamp('start_date_plan')->nulleable(false);
            $table->timestamp('finish_date_plan')->nulleable(false);
            $table->boolean('is_active')->nulleable(false)->default(true);
            $table->timestamps();

            // Define model relations
            $table->foreign('owner_id')->references('document_number')->on('owners');
            $table->foreign('vehicle_id')->references('plate_number')->on('vehicles');
            $table->foreign('plan_id')->references('id')->on('plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parking_contracts');
    }
}
