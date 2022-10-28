<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('country_id')->nullable();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('user_image')->nullable();
            $table->string('about')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('website_lintree_url')->nullable();
            $table->string('email')->nullable()->unique();
            $table->tinyInteger('privacy_about')->default(1);
            $table->tinyInteger('privacy_last_seen')->default(1);
            $table->string('ip_address')->nullable();
            $table->string('live_status')->default('offline');
            $table->timestamp('last_seen')->nullable();
            $table->integer('otp')->nullable();
            $table->timestamp('otp_expires')->nullable();
            $table->string('dynamic_token')->nullable();
            $table->integer('socket_connection_id')->default(0);
            $table->string('stripe_connect_account_id')->nullable();
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
        Schema::dropIfExists('users');
    }
};
