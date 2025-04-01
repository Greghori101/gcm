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
        Schema::create('medicines', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('ne');
            $table->string('code');
            $table->string('name');
            $table->string('brand');
            $table->string('form');
            $table->string('dosage');
            $table->string('packaging');
            $table->string('list');
            $table->string('p1');
            $table->string('p2');
            $table->string('obs');
            $table->string('laboratory');
            $table->string('type');
            $table->string('period');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
