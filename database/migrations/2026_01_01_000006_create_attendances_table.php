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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Jadwal (biar tau ini absen mapel apa & kelas apa)
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            
            // Relasi ke Siswa
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            
            // Tanggal Absen
            $table->date('date');
            
            // Status: Hadir, Sakit, Izin, Alpha. 
            // NULLABLE = Boleh kosong (belum diabsen guru)
            $table->enum('status', ['hadir', 'sakit', 'izin', 'alpha'])->nullable();
            
            $table->text('note')->nullable(); // Catatan tambahan (opsional)
            
            $table->timestamps(); // created_at akan mencatat jam input
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
