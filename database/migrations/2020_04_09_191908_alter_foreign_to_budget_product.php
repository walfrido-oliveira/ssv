<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterForeignToBudgetProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_product', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
            $table->dropForeign(['product_id']);

            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_product', function (Blueprint $table) {
            $table->dropForeign(['budget_id']);
        });
    }
}
