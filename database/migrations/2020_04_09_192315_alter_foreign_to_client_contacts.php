<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterForeignToClientContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_contacts', function (Blueprint $table) {
            $table->dropForeign(['contact_type_id']);
            $table->dropForeign(['client_id']);

            $table->foreign('contact_type_id')->references('id')->on('contact_types')->onDelete('cascade');

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
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
            $table->dropForeign(['contact_type_id']);
            $table->dropForeign(['client_id']);
        });
    }
}
