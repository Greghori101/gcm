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
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->text('firstname');
            $table->text('lastname');
            $table->date('birthdate');
            $table->text('phone_number')->unique();
            $table->string('blood_type');
            $table->string('gender');
            $table->json('medical_history')->nullable();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
