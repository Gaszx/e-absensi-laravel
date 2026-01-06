<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Schedule;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Tahun Ajaran
        $year = AcademicYear::create([
            'name' => '2025/2026',
            'semester' => 'Ganjil',
            'is_active' => true,
        ]);

        // 2. Buat Kelas
        $class = Classroom::create([
            'name' => 'XII RPL 1',
            'academic_year_id' => $year->id,
        ]);

        // 3. Buat Mapel
        $subject = Subject::create([
            'name' => 'Pemrograman Web',
        ]);

        // 4. Buat Akun ADMIN
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'admin',
        ]);

        // 5. Buat Akun GURU
        $teacher = User::create([
            'name' => 'Pak Budi Santoso',
            'email' => 'budi@sekolah.com',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'guru',
        ]);

        // 6. Buat Siswa Dummy (5 Orang)
        $students = ['Ahmad', 'Budi', 'Chika', 'Dedi', 'Eka'];
        foreach ($students as $name) {
            Student::create([
                'name' => $name,
                'gender' => 'L', // Anggap Laki-laki dulu biar cepat
                'classroom_id' => $class->id,
            ]);
        }

        // 7. Buat Jadwal Mengajar untuk Pak Budi
        // Kita set hari ini (dalam bahasa Inggris) agar nanti pas dashboard dibuka langsung muncul
        // Tapi untuk dummy kita set 'Monday' (Senin) dulu sebagai contoh
        Schedule::create([
            'classroom_id' => $class->id,
            'subject_id' => $subject->id,
            'user_id' => $teacher->id,
            'day' => 'Monday', // Senin
            'start_time' => '07:00',
            'end_time' => '09:00',
        ]);
    }
}