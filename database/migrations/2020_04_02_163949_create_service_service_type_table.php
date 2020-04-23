<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceServiceTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_service_type', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('service_type_id');

            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('service_type_id')->references('id')->on('service_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_service_type');
    }
}
