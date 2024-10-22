<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabel guru
        Schema::create('guru', function (Blueprint $table) {
            $table->string('c_guru')->primary();
            $table->string('nip');
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('no_telp');
            $table->string('email');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // Tabel orangtua
        Schema::create('orangtua', function (Blueprint $table) {
            $table->string('c_orangtua')->primary();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('no_telp');
            $table->string('pekerjaan');
            $table->string('hubungan_dengan_santri');
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // Tabel kelas
        Schema::create('kelas', function (Blueprint $table) {
            $table->string('c_kelas')->primary();
            $table->string('nama_kelas');
            $table->string('tingkat');
            $table->string('wali_kelas');
            $table->foreign('wali_kelas')->references('c_guru')->on('guru');
            $table->timestamps();
        });

        // Tabel santri
        Schema::create('santri', function (Blueprint $table) {
            $table->string('c_santri')->primary();
            $table->string('nis')->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('no_telp');
            $table->string('foto')->nullable();
            $table->string('c_kelas');
            $table->string('c_orangtua');
            $table->foreign('c_kelas')->references('c_kelas')->on('kelas');
            $table->foreign('c_orangtua')->references('c_orangtua')->on('orangtua');
            $table->timestamps();
        });

        // Tabel hafalan
        Schema::create('hafalan', function (Blueprint $table) {
            $table->id('id_hafalan');
            $table->string('nis');
            $table->string('surat');
            $table->string('ayat');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('guru_pembimbing');
            $table->foreign('nis')->references('nis')->on('santri');
            $table->foreign('guru_pembimbing')->references('c_guru')->on('guru');
            $table->timestamps();
        });

        // Tabel prestasi
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id('id_prestasi');
            $table->string('nis');
            $table->string('jenis_prestasi');
            $table->string('penyelenggara');
            $table->date('tanggal');
            $table->string('peringkat');
            $table->foreign('nis')->references('nis')->on('santri');
            $table->timestamps();
        });

        // Tabel kegiatan
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->string('nis');
            $table->string('jenis_kegiatan');
            $table->string('nama_kegiatan');
            $table->date('tanggal');
            $table->string('tempat');
            $table->foreign('nis')->references('nis')->on('santri');
            $table->timestamps();
        });

        // Tabel pelanggaran
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id('id_pelanggaran');
            $table->string('nis');
            $table->string('jenis_pelanggaran');
            $table->text('deskripsi');
            $table->date('tanggal');
            $table->string('sanksi');
            $table->foreign('nis')->references('nis')->on('santri');
            $table->timestamps();
        });

        // Tabel admin
        Schema::create('admin', function (Blueprint $table) {
            $table->string('c_admin')->primary();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelanggaran');
        Schema::dropIfExists('kegiatan');
        Schema::dropIfExists('prestasi');
        Schema::dropIfExists('hafalan');
        Schema::dropIfExists('santri');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('orangtua');
        Schema::dropIfExists('guru');
        Schema::dropIfExists('admin');
    }
};