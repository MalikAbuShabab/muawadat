<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // if linked to users
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('google_business')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('x')->nullable();
            $table->string('wiki')->nullable();
            $table->string('youtube')->nullable();
            $table->tinyInteger('status')->default(0)->comment('1 for enable ,2 for disable')->nullable();
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
        Schema::dropIfExists('social_links');
    }
}
