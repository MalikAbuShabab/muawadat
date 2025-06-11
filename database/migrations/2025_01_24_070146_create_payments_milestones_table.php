<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('bid_id');
            $table->unsignedBigInteger('created_by');
            $table->integer('total_milestone')->default(0);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('bid_id')->references('id')->on('p2p_bids')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('milestone_type')->default(0)->comment('0 = by project, 1 = by milestone');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->tinyInteger('is_approved')->default(0)->comment('0 = No, 1 = Yes');
            $table->enum('status', ['pending', 'completed', 'overdue'])->default('pending');
            $table->softDeletes();
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
        Schema::dropIfExists('payments_milestones');
    }
}
