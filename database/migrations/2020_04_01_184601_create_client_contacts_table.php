<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->uuid();
            $table->uuid('contact_type_id');
            $table->uuid('client_id');

            $table->string('contact');
            $table->string('department');
            $table->string('phone');
            $table->string('mobile_phone');
            $table->string('email');

            $table->timestamps();

            $table->foreign('contact_type_id')->references('id')->on('contact_types');
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
        Schema::dropIfExists('client_contacts');
    }
}
