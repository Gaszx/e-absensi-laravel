<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    
    // Pastikan fillable dan relasi lain tetap ada
    protected $fillable = ['name', 'academic_year_id'];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    
    // Satu Kelas punya banyak Jadwal
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}