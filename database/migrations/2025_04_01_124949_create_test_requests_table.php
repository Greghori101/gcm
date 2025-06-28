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
        Schema::create('test_requests', function (Blueprint $table) {
            $table->uuid('id');
            $table->bigIncrements('nb')->unique();
            $table->json('past_medical_history');
            $table->string('visit_purpose');
            $table->string('conclusion');
            $table->json('requests');
            $table->date('date');
            $table->string('purpose');
            $table->foreignUuid('doctor_id')->nullable()->index();
            $table->foreignUuid('patient_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_requests');
    }
};
