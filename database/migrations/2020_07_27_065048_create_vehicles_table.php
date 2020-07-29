<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->string('plate_number', 10)->nullable(false)->unique();
            $table->string('color', 15)->nullable();
            $table->string('brand', 70)->nullable();
            $table->string('type', 20)->nullable();
            $table->string('model', 4)->nullable(false);
            $table->string('chassis_number', 17)->nullable(false);
            $table->boolean('is_vip')->default(false);
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
        Schema::dropIfExists('vehicles');
    }
}
