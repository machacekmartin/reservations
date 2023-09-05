<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('label');
            $table->boolean('available');
            $table->unsignedInteger('capacity');
            $table->json('location');
            $table->json('size');
        });
    }
};
