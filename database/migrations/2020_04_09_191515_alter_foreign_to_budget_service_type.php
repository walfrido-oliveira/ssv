<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterForeignToBudgetServiceType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_service_type', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
            $table->dropForeign(['service_type_id']);

            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade');

            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_service_type', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
        });
    }
}
