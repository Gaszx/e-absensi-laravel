<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // 1. IZINKAN KOLOM INI DIISI (Solusi Error MassAssignment)
    protected $fillable = [
        'schedule_id',
        'student_id',
        'date',
        'status',
        'note',
    ];

    // 2. Relasi ke Siswa (Opsional, buat nanti rekap laporan)
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // 3. Relasi ke Jadwal (Opsional)
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}