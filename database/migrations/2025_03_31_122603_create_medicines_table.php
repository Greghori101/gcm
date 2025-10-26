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
            $table->uuid('id')->primary()->unique();
            $table->string('ne');
            $table->string('code');
            $table->string('name');
            $table->string('brand');
            $table->string('form')->nullable();
            $table->text('dosage')->nullable();
            $table->text('packaging')->nullable();
            $table->string('list')->nullable();
            $table->string('p1')->nullable();
            $table->string('p2')->nullable();
            $table->text('obs')->nullable();
            $table->text('laboratory')->nullable();
            $table->string('type')->nullable();
            $table->string('period')->nullable();
            $table->string('country')->nullable();
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
