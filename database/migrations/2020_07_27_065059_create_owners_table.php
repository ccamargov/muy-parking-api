<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->string('document_number', 20)->nullable(false)->unique();;
            $table->string('names', 50)->nullable(false);
            $table->string('surnames', 50)->nullable();
            $table->string('tel_contact', 20)->nullable(false);
            $table->string('email_contact', 40)->nullable();
            $table->boolean('is_resident')->default(false);
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
        Schema::dropIfExists('owners');
    }
}
