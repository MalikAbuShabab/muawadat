<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRedeemedColumnToUserReferrals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_refferals', function (Blueprint $table) {
            $table->boolean('redeemed')->default(true); // Initialize the redeemed column with true
                                                        // since all previous referrals until this point
                                                        // are to be considered redeemed.
        });

        Schema::table('user_refferals', function (Blueprint $table) {
            $table->boolean('redeemed')->default(false)->change(); // Set all future user referrals to not be
                                                                   // redeemed by default.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_referrals', function (Blueprint $table) {
            $table->dropColumn('redeemed');
        });
    }
}
