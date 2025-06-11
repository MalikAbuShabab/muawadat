<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('growth_opportunity')->nullable();
            $table->string('financial_data')->nullable();
            $table->string('matrics')->nullable();
            $table->string('data_room')->nullable();
            $table->string('marketing')->nullable();
            $table->string('price')->nullable();
            $table->string('offer_type')->nullable();
            $table->string('proposed_price')->nullable();
            $table->string('notes_offer')->nullable();
            $table->string('phone')->nullable();
            $table->string('email_address')->nullable();
            $table->string('share_precentage')->nullable();
            $table->string('start_date')->nullable();
            $table->text('sale_reason')->nullable();
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
        Schema::dropIfExists('financial_infos');
    }
}
