<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kategori_id')->index();
            $table->unsignedInteger('lapang_id')->index();
            $table->string('jam_mulai', 30)->nullable();
            $table->string('jam_selesai', 30)->nullable();
            $table->string('hari', 40)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kategori_id')
                    ->references('id')
                    ->on('kategori')
                    ->onDelete('cascade');

            $table->foreign('lapang_id')
                    ->references('id')
                    ->on('lapang')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
}
