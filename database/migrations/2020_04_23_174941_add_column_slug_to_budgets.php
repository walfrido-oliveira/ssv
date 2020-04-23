<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSlugToBudgets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_types', function (Blueprint $table) {
            $table->string('slug');
        });
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('slug');
        });
        Schema::table('transport_methods', function (Blueprint $table) {
            $table->string('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_types', function (Blueprint $table) {
            $table->dropColumn(['slug']);
        });
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('slug');
        });
        Schema::table('transport_methods', function (Blueprint $table) {
            $table->string('slug');
        });
    }
}
