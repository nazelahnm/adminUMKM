<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelurahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelurahans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelurahan');
            $table->unsignedBigInteger('tahun_id'); // Mengubah menjadi tahun_id
            $table->timestamps();

            // Definisi foreign key
            $table->foreign('tahun_id')->references('id')->on('tahuns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kelurahans', function (Blueprint $table) {
            $table->dropForeign(['tahun_id']); // Menghapus constraint foreign key
        });

        Schema::dropIfExists('kelurahans');
    }
}
