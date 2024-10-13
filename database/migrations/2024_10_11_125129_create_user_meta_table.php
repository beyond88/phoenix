<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_meta', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID as primary key
            $table->unsignedBigInteger('user_id'); // User ID referencing users table
            $table->string('meta_key'); // Meta key (e.g., wp_capabilities)
            $table->longText('meta_value')->nullable(); // Meta value (can store serialized data)
            $table->timestamps(); // Adds created_at and updated_at timestamps

            // Foreign key constraint on user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Index for user_id for better performance on user-specific queries
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_meta');
    }
}

