<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP2pBidDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p2pBidDocuments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bid_id');
            $table->string('document_name')->nullable();  
            $table->string('document_path')->nullable(); 
            $table->string('file_type')->nullable()->comment('1 - image, 2 - video, 3 - file');
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('bid_id')->references('id')->on('p2p_bids')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p2pBidDocuments');
    }
}
