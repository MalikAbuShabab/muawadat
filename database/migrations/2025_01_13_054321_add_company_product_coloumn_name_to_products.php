<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyProductColoumnNameToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
           $table->string('company_name')->nullable();
           $table->string('company_type')->nullable();
           $table->string('company_website')->nullable();
           $table->string('company_sale_type')->nullable();
           $table->string('company_launch_date')->nullable();
           $table->string('company_team_size')->nullable();
           $table->string('company_business_model')->nullable();
           $table->string('country_id')->nullable();
           $table->string('company_technology')->nullable();
           $table->boolean('is_company_list')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
