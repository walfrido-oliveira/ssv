<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetServiceType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_service_type', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('budget_id');
            $table->unsignedBigInteger('service_type_id');

            $table->timestamps();

            $table->foreign('budget_id')->references('id')->on('budgets');
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
        Schema::dropIfExists('budget_service_type');
    }
}
