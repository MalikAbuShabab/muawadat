<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToP2pBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p2p_bids', function (Blueprint $table) {
            $table->tinyInteger('confirm_term_condition')->default(0)->comment('0 = not confirmed, 1 = confirmed');
            $table->tinyInteger('confirm_processed_payment')->default(0)->comment('0 = not confirmed, 1 = confirmed');
            $table->tinyInteger('confirm_ownership_transfer')->default(0)->comment('0 = not confirmed, 1 = confirmed');
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
            $table->dropColumn(['confirm_term_condition', 'confirm_processed_payment', 'confirm_ownership_transfer']);
        });
    }
}
