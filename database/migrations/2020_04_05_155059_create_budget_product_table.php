<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_id');
            $table->unsignedBigInteger('product_id');

            $table->integer('amount');

            $table->timestamps();

            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_product');
    }
}
