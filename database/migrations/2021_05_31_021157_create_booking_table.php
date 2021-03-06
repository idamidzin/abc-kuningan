<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('paket_id')->index();
            $table->unsignedInteger('lapang_id')->nullable()->index();
            $table->unsignedInteger('jadwal_id')->nullable()->index();
            $table->string('hari', 10)->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('nama_group', 90)->nullable();
            $table->string('jam_mulai', 20)->nullable();
            $table->string('jam_selesai', 20)->nullable();
            $table->string('jumlah_hari', 50)->nullable();
            $table->string('keterangan')->nullable();
            $table->string('harga', 70)->nullable();
            $table->string('status', 2)->nullable();
            $table->string('diskon', 70)->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->boolean('status_pembayaran')->default(0)->nullable();
            $table->string('kategori_pembayaran', 1)->nullable();
            $table->boolean('is_member')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('paket_id')
                    ->references('id')
                    ->on('paket')
                    ->onDelete('cascade');

            $table->foreign('lapang_id')
                    ->references('id')
                    ->on('lapang')
                    ->onDelete('cascade');

            $table->foreign('jadwal_id')
                    ->references('id')
                    ->on('Jadwal')
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
        Schema::dropIfExists('booking');
    }
}
