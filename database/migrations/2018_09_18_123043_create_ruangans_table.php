<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruangans', function (Blueprint $table) {
            $table->increments('id_ruangan');
            $table->integer('id_gedung')->unsigned();
            $table->string('kode_ruangan');
            $table->text('keterangan')->nullable();
            $table->boolean('status')->default('1');
            $table->timestamps();

            $table->foreign('id_gedung')->references('id_gedung')->on('gedungs')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruangans');
    }
}
