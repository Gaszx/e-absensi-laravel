<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom subject_id (Boleh kosong/nullable karena Admin tidak punya mapel)
            // onUpdate/onDelete set null artinya: jika Mapel dihapus, gurunya tidak ikut terhapus (hanya jadi kosong mapelnya)
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onUpdate('cascade')->onDelete('set null')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropColumn('subject_id');
        });
    }
};