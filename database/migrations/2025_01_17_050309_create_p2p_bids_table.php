<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP2pBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p2p_bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->decimal('bid_amount', 15, 2);
            $table->enum('bid_status', ['open', 'matched', 'closed','rejected'])->default('open');
            $table->integer('is_raised')->default(0);
            $table->text('seller_reason')->nullable();
            $table->timestamp('match_date')->nullable();
            $table->timestamps();
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p2p_bids');
    }
}
