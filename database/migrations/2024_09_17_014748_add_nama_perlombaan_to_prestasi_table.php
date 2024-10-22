<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->string('nama_perlombaan')->after('nis'); // Menambahkan kolom nama_perlombaan
        });
    }

    public function down()
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropColumn('nama_perlombaan'); // Menghapus kolom jika rollback
        });
    }
};
