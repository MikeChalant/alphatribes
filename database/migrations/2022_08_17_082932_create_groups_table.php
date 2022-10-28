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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('group_category_id');
            $table->string('group_name');
            $table->string('image');
            $table->text('description')->nullable();
            $table->string('support_email')->nullable();
            $table->string('stripe_connect_email')->nullable();
            $table->string('lintree_website_url')->nullable();
            $table->string('group_type');
            $table->tinyInteger('paid_group');
            $table->string('payment_type')->nullable();
            $table->float('onetime_cost')->nullable();
            $table->float('daily_cost')->nullable();
            $table->float('weekly_cost')->nullable();
            $table->float('monthly_cost')->nullable();
            $table->float('yearly_cost')->nullable();
            $table->string('billing_currency')->nullable();
            $table->integer('trial_duration')->nullable();
            $table->integer('file_count')->default(0);
            $table->integer('audio_count')->default(0);
            $table->integer('video_count')->default(0);
            $table->integer('total_subscribers')->default(0);
            $table->tinyInteger('blocked')->default(0);
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
        Schema::dropIfExists('groups');
    }
};
