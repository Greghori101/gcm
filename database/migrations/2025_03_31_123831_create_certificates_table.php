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
        Schema::create('certificates', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->bigIncrements('nb')->unique();
            $table->string('period');
            $table->string('signature');
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
        Schema::dropIfExists('certificates');
    }
};
