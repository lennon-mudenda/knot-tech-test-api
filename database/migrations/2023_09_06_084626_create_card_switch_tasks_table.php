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
        Schema::create('card_switch_tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique()->index();
            $table->uuid('card_uuid')->nullable()->index();
            $table->uuid('previous_card_uuid')->nullable()->index();
            $table->uuid('merchant_uuid')->nullable()->index();
            $table->uuid('status_uuid')->nullable()->index();
            $table->uuid('user_uuid')->nullable()->index();
            $table->unsignedBigInteger('card_id');
            $table->unsignedBigInteger('previous_card_id')->nullable();
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('card_uuid')->references('uuid')->on('cards')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('card_id')->references('id')->on('cards')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('previous_card_uuid')->references('uuid')->on('cards')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('previous_card_id')->references('id')->on('cards')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('merchant_uuid')->references('uuid')->on('merchants')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('merchant_id')->references('id')->on('merchants')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('status_uuid')->references('uuid')->on('statuses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('status_id')->references('id')->on('statuses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_uuid')->references('uuid')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_switch_tasks');
    }
};
