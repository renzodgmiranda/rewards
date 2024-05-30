<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('account')->nullable();
            $table->bigInteger('points')->default('0');
            $table->integer('tier')->nullable();
            $table->bigInteger('used_points')->default(0);
            $table->bigInteger('srs_points')->default(0);
            $table->bigInteger('hw_points')->default(0);
            $table->bigInteger('tw_points')->default(0);
            $table->bigInteger('q1_points')->default(0);
            $table->bigInteger('q2_points')->default(0);
            $table->bigInteger('q3_points')->default(0);
            $table->bigInteger('q4_points')->default(0);
            $table->bigInteger('items_redeemed')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
