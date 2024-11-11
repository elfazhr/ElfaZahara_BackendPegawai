<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->string('NIP', 20)->primary();
            $table->string('Nama', 100);
            $table->string('Tempat_Lahir', 50);
            $table->text('Alamat');
            $table->date('Tanggal_Lahir');
            $table->enum('Jenis_Kelamin', ['L', 'P']);
            $table->string('Agama', 50);
            $table->string('NPWP', 20)->nullable();
            $table->string('Foto', 255)->nullable();
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
        Schema::dropIfExists('pegawai');
    }
}
