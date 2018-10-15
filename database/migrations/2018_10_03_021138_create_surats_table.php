<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->increments('id_sp2d');
            $table->integer('id_skpd')->unsigned();
            $table->integer('id_jenis_sp2d')->unsigned();
            $table->string('nomor_surat')->unique();
            $table->date('tgl_terbit');
            $table->text('uraian')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('arsip')->default(0);
            $table->timestamps();

            $table->foreign('id_skpd')
                    ->references('id_skpd')
                    ->on('skpds')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

            $table->foreign('id_jenis_sp2d')
                    ->references('id_jenis_sp2d')
                    ->on('jenis_surats')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surats');
    }
}
