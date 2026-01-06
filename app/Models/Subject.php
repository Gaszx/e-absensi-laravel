<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Satu Mapel punya banyak Jadwal
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}