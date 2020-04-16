<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTableToBudgetServiceType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_service_type', function (Blueprint $table) {
            $table->dropForeign('budget_service_type_budget_id_foreign');
            $table->dropForeign('budget_service_type_service_type_id_foreign');
        });

        Schema::rename('budget_service_type', 'budget_service');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_service_type', function (Blueprint $table) {
            //
        });
    }
}
