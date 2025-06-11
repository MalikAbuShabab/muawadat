<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdentityDocVerifiedToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('front_identity_doc_verified')->default(false)->after('is_phone_verified');
            $table->boolean('back_identity_doc_verified')->default(false)->after('front_identity_doc_verified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('front_identity_doc_verified');
            $table->dropColumn('back_identity_doc_verified');
        });
    }
}
