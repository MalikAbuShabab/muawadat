<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsViewedToP2pBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p2p_bids', function (Blueprint $table) {
            $table->boolean('is_viewed')->default(false)->after('confirm_ownership_transfer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p2p_bids', function (Blueprint $table) {
            $table->dropColumn('is_viewed');
        });
    }
}
