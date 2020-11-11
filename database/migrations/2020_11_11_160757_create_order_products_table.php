<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('budget_product_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');

            $table->text('description')->nullable();
            $table->timestamps();
            $table->integer('index');

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('budget_product_id')->references('id')->on('budget_product');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
