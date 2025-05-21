<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahapan_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tahapan');
            $table->enum('kegiatan' ,['Budidaya', 'Panen', 'Pasca Panen']);
            $table->enum('jenis_kopi' ,['Arabika', 'Robusta']);
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
        Schema::dropIfExists('tahapan_kegiatans');
    }
};
