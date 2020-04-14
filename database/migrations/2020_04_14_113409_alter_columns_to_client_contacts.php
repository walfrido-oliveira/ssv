<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsToClientContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_contacts', function (Blueprint $table) {
            $table->string('contact')->nullable(true)->change();
            $table->string('department')->nullable(true)->change();
            $table->string('phone')->nullable(true)->change();
            $table->string('mobile_phone')->nullable(true)->change();
            $table->string('email')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_contacts', function (Blueprint $table) {
            //$table->dropColumn('contact');
        });
    }
}
