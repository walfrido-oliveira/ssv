<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('budget_id');
            $table->unsignedBigInteger('client_id');

            $table->text('observation');
            $table->enum('status', ['created', 'finished', 'inactived'])->default('created');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->foreign('client_id')->references('id')->on('clients');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_order');
    }
}
