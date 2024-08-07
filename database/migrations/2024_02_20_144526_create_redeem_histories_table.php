<?php

use App\Models\Rewards;
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
        Schema::create('redeem_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Rewards::class);

            $table->string('redeemed_name')->nullable();
            $table->string('redeemed_image')->nullable();
            $table->bigInteger('redeemed_points')->nullable();
            $table->integer('redeemed_quantity')->nullable();
            $table->string('redeemed_status')->nullable();
            $table->string('redeemed_by')->nullable();
            $table->mediumText('redeemed_user_note')->nullable();
            $table->integer('expiry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redeem_histories');
    }
};
