<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInProductMeasurementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('product_measurement', function (Blueprint $table) {
        // $table->dropForeign(['key_id']);
                

        // $table->foreign('key_id')
        //         ->references('measurement_key_id')
        //         ->on('measurements')
        //         ->onDelete('cascade')
        //         ->onUpdate('restrict');
        // });      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::table('product_measurement', function (Blueprint $table) {
                $table->dropForeign(['key_id']);
                $table->foreign('key_id')
                      ->references('id')
                      ->on('measurements')
                      ->onDelete('cascade')
                      ->onUpdate('restrict');
            });   
    }
}