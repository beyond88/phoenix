<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddCustomFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_login')->unique()->after('id');          // Username
            $table->string('user_pass')->after('user_login');             // Password (hashed)
            $table->string('user_nicename')->nullable()->after('user_pass'); // URL-friendly name
            $table->string('user_email')->unique()->after('user_nicename'); // Email address
            $table->string('user_url')->nullable()->after('user_email');  // User's website URL
            $table->timestamp('user_registered')->nullable()->after('user_url'); // Registration date
            $table->string('user_activation_key')->nullable()->after('user_registered'); // Activation key
            $table->integer('user_status')->default(0)->after('user_activation_key'); // Status
            $table->string('display_name')->nullable()->after('user_status'); // Display name
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_login', 'user_pass', 'user_nicename', 'user_email',
                'user_url', 'user_registered', 'user_activation_key',
                'user_status', 'display_name'
            ]);
        });
    }
}
