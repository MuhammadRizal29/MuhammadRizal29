<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('kegiatan', function (Blueprint $table) {
        $table->dropForeign(['nis']); // Hapus foreign key constraint
        $table->dropColumn('nis'); // Hapus kolom 'nis'
    });
}

public function down()
{
    Schema::table('kegiatan', function (Blueprint $table) {
        $table->string('nis');
        $table->foreign('nis')->references('nis')->on('santri');
    });
}

};
