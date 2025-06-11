<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP2pWithdrawOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p2p_withdraw_otps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bid_id'); // Reference to the bid
            $table->unsignedBigInteger('user_id'); // Reference to the user
            $table->string('email')->nullable(); // Email where OTP was sent
            $table->string('otp_code')->nullable(); // OTP Code
            $table->boolean('is_used')->default(false); // Whether the OTP is used
            $table->timestamp('expires_at')->nullable(); // Expiry timestamp
            $table->timestamps();
            $table->foreign('bid_id')->references('id')->on('p2p_bids')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p2p_withdraw_otps');
    }
}
