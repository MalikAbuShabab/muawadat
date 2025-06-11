<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawBidContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_bid_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bid_id');
            $table->unsignedBigInteger('withdraw_by');
            $table->text('reason')->nullable();
            $table->text('otp')->nullable();
            $table->tinyInteger('otp_verify')->default(0)->comment('0 = Not, 1 = Yes');
            $table->timestamp('withdrawn_at')->useCurrent();
            $table->foreign('bid_id')->references('id')->on('p2p_bids')->onDelete('cascade');
            $table->foreign('withdraw_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraw_bid_contracts');
    }
}
