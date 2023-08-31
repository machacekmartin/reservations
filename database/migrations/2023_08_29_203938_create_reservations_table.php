<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->timestamp('remind_at')->nullable();
            $table->timestamp('canceled_at')->nullable();

            $table->unsignedInteger('guest_count');
            $table->boolean('fulfilled')->default(false);
            $table->string('note')->nullable();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('restaurant_id')->constrained();
        });
    }
};
