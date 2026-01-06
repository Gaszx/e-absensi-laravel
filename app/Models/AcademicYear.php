<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    // 1. Daftar kolom yang boleh diisi via form
    protected $fillable = [
        'name',      // Contoh: "2025/2026"
        'semester',  // Contoh: "Ganjil" atau "Genap"
        'is_active', // Contoh: 1 (Aktif) atau 0 (Tidak Aktif)
    ];

    // 2. Casting Tipe Data
    // Mengubah kolom is_active dari 1/0 di database menjadi true/false di PHP
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // 3. Relasi ke Table Kelas (One to Many)
    // "Satu Tahun Ajaran bisa memiliki banyak Kelas"
    // Contoh: Tahun 2025/2026 punya kelas X RPL 1, X RPL 2, dst.
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    // 4. Scope Helper (Opsional)
    // Ini memudahkan kita memanggil tahun yang aktif di Controller.
    // Cara pakainya nanti: AcademicYear::active()->first();
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}