<?php

use App\Enums\TicketStatus;
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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->nullable()->index();
            $table->foreignUuid('queue_id')->nullable()->index();
            $table->unsignedInteger('number'); // daily number
            $table->date('ticket_date'); // date for daily reset
            $table->enum('status', [
                TicketStatus::Pending->value,
                TicketStatus::Completed->value,
                TicketStatus::Canceled->value,
                TicketStatus::Expired->value
            ])->default(TicketStatus::Pending->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
