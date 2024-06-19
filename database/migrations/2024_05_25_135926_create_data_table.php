<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelurahan_id'); // Tambahkan kolom ini
            $table->string('nama_umkm');
            $table->bigInteger('laba_bersih');
            $table->bigInteger('omset');
            $table->bigInteger('jumlah_karyawan');
            $table->bigInteger('modal');
            $table->bigInteger('usia');
            $table->string('lokasi');
            $table->timestamps();

            // Definisikan foreign key
            $table->foreign('kelurahan_id')->references('id')->on('kelurahans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data', function (Blueprint $table) {
            // Drop foreign key terlebih dahulu sebelum drop tabel
            $table->dropForeign(['kelurahan_id']);
        });

        Schema::dropIfExists('data');
    }
}