<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('budget_type_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('transport_method_id');
            $table->unsignedBigInteger('client_contact_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('user_id');

            $table->decimal('amount', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->date('validity');
            $table->text('description')->nullable();

            $table->timestamps();

            $table->foreign('budget_type_id')->references('id')->on('budget_types');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('transport_method_id')->references('id')->on('transport_methods');
            $table->foreign('client_contact_id')->references('id')->on('client_contacts');
            $table->foreign('client_id')->references('id')->on('clients');
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
        Schema::dropIfExists('budget');
    }
}
