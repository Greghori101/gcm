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
        Schema::create('prescription_medicine', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_qsp');
            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('qte');
            $table->string('unit');
            $table->string('form');
            $table->string('dosage');
            $table->string('frequency');
            $table->string('periodicity');
            $table->json('conditions')->nullable();
            $table->foreignUuid('prescription_id')->nullable()->index();
            $table->foreignUuid('medicine_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_medicine');
    }
};
