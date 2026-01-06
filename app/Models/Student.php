<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'gender', 'classroom_id'];

    // Relasi ke Kelas
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}