<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('restrict');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->text('medications');
            $table->text('instructions')->nullable();
            $table->date('prescription_date');
            $table->date('valid_until')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['patient_id', 'prescription_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};

