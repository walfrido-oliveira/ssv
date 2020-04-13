<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');

            $table->string('client_id', 14)->unique();
            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->string('im')->nullable();
            $table->string('ie')->nullable();
            $table->enum('type', ['PJ', 'PF']);
            $table->string('home_page')->nullable();
            $table->text('description')->nullable();

            $table->string('adress');
            $table->string('adress_number');
            $table->string('adress_district');
            $table->string('adress_city');
            $table->char('adress_state', 2);
            $table->char('adress_cep', 8);
            $table->string('adress_comp')->nullable();

            $table->string('logo')->nullable();

            $table->timestamps();

            $table->foreign('activity_id')->references('id')->on('activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
