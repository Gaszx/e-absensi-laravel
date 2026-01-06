<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'classroom_id',
        'subject_id',
        'user_id',
        'day',
        'start_time',
        'end_time',
    ];

    // Relasi ke Kelas
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // Relasi ke Mapel
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Relasi ke Guru (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}