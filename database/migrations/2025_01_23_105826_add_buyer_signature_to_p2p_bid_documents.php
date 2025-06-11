<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyerSignatureToP2pBidDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('p2pBidDocuments', function (Blueprint $table) {
            $table->text('buyer_signature')->nullable();
            $table->string('doc_type')->nullable();
            $table->integer('upload_buyer_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('p2p_bid_documents', function (Blueprint $table) {
            //
        });
    }
}
