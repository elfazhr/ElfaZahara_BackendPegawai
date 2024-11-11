<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiUnitKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai_unit_kerja', function (Blueprint $table) {
            $table->id('id_pegawai_unitkerja');
            $table->string('NIP', 20);
            $table->foreignId('kode_unit')->constrained('penugasan', 'ID_Penugasan');
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
        Schema::dropIfExists('pegawai_unit_kerja');
    }
}
