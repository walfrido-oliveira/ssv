<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('budget_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('payment_method_id');

            $table->timestamp('due_date');
            $table->timestamps();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'in_process', 'paid'])->default('pending');

            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billings');
    }
}
