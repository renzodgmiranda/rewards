<?php

use App\Models\User;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);

            $table->string('post_owner')->nullable();
            $table->string('post_title')->nullable();
            $table->string('post_image')->nullable();
            $table->longText('post_body')->nullable();
            $table->text('post_users')->nullable();
            $table->string('post_owner_profile', 2048)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
