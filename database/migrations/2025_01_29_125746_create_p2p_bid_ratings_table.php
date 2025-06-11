<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateP2pBidRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p2p_bid_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bid_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('rated_user_id');
            $table->tinyInteger('rating')->unsigned()->comment('1 to 5 stars'); // 1-5 Star rating
            $table->decimal('average_rating', 3, 2)->nullable()->comment('Calculated average rating');
            $table->json('feedback')->comment('Stores multiple feedback options as JSON'); // Multiple selections
            $table->text('suggestion')->nullable()->comment('User additional comments'); // Optional text feedback
            $table->softDeletes();
            $table->timestamps();
            // Foreign key constraints
            $table->foreign('bid_id')->references('id')->on('p2p_bids')->onDelete('cascade'); // Bidding transaction
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // User giving the rating
            $table->foreign('rated_user_id')->references('id')->on('users')->onDelete('cascade'); // User being rated
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p2p_bid_ratings');
    }
}
