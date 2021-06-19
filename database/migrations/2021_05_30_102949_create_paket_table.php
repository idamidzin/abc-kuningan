<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->string('jumlah_jam', 50)->nullable();
            $table->string('jumlah_hari', 50)->nullable();
            $table->string('diskon', 70)->nullable();
            $table->string('harga')->nullable();
            $table->string('harga_perbulan')->nullable();
            $table->string('gambar')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('for_use', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket');
    }
}
