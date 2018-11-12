<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArsipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsips', function (Blueprint $table) {
            $table->increments('id_arsip');
            $table->integer('id_sp2d')->unsigned();
            $table->integer('id_box')->unsigned();
            $table->date('tgl_diarsipkan');
            $table->date('tgl_perkiraan_retensi');
            $table->string('qr_arsip')->default('kode-qr-arsip.png');
            $table->boolean('status_retensi')->default('0');
            $table->text('keterangan')->nullable();
            $table->boolean('status')->default('1');
            $table->timestamps();

            $table->foreign('id_sp2d')
                    ->references('id_sp2d')
                    ->on('surats')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

            $table->foreign('id_box')
                    ->references('id_box')
                    ->on('boxes')
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
        Schema::dropIfExists('arsips');
    }
}
