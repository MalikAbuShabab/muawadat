<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('notifiable_id'); // Admin ID
            $table->string('notifiable_type')->nullable(); // Model type (e.g., App\Models\Admin)
            $table->string('type')->nullable(); // Notification type
            $table->json('data')->nullable(); // Notification content
            $table->timestamp('read_at')->nullable(); // Read timestamp
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
        Schema::dropIfExists('admin_notifications');
    }
}
