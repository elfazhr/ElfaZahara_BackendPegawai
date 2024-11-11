<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiJabatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai_jabatan', function (Blueprint $table) {
            $table->id('id_pegawai_jabatan');
            $table->string('NIP', 20);
            $table->foreignId('kode_jabatan')->constrained('jabatan', 'ID_Jabatan');
            $table->foreign('NIP')->references('NIP')->on('pegawai')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai_jabatan');
    }
}
