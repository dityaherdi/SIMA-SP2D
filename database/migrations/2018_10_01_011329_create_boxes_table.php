<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->increments('id_box');
            $table->integer('id_rak')->unsigned();
            $table->string('kode_box');
            $table->tinyInteger('kapasitas')->unsigned(0);
            $table->tinyInteger('jml_arsip')->unsigned(0);
            $table->boolean('status_retensi_box')->default('0');
            $table->string('qr_box')->default('kode-box-qr.png');
            $table->text('keterangan')->nullable();
            $table->boolean('status')->default('1');
            $table->timestamps();

            $table->foreign('id_rak')
                    ->references('id_rak')
                    ->on('raks')
                    ->onDelete('cascade')
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
        Schema::dropIfExists('boxes');
    }
}
