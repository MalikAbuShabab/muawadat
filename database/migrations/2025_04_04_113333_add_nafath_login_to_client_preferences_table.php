<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNafathLoginToClientPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_preferences', function (Blueprint $table) {
            $table->boolean('nafath_login')->default(0)->after('apple_login')->comment('1 - enable, 0 - disable');
            $table->text('nafath_client_id')->nullable();
            $table->text('nafath_client_secret')->nullable();
            $table->text('nafath_client_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_preferences', function (Blueprint $table) {
            $table->dropColumn('nafath_login');
            $table->dropColumn('nafath_client_id');
            $table->dropColumn('nafath_client_secret');
            $table->dropColumn('nafath_client_url');
        });
    }
}
