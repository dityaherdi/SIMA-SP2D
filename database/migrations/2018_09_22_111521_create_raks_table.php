<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raks', function (Blueprint $table) {
            $table->increments('id_rak');
            $table->integer('id_ruangan')->unsigned();
            $table->string('kode_rak');
            $table->string('qr_rak')->default('kode-rak-qr.png');
            $table->text('keterangan')->nullable();
            $table->boolean('status')->default('1');
            $table->timestamps();

            $table->foreign('id_ruangan')
                    ->references('id_ruangan')
                    ->on('ruangans')
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
        Schema::dropIfExists('raks');
    }
}
