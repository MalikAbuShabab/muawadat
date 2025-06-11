<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoulmnorderVendorProductIdInVendorOrderStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // if (!Schema::hasTable('vendor_order_statuses')) {
            Schema::table('vendor_order_statuses', function (Blueprint $table) {
                $table->integer('order_vendor_product_id')->nullable();
            });
        // };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_order_statuses', function (Blueprint $table) {
            //
        });
    }
}
