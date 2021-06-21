<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('diklat_id')->nullable()->index();
            $table->unsignedInteger('booking_id')->nullable()->index();
            $table->date('tanggal_bayar')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('diklat_id')
                    ->references('id')
                    ->on('diklat')
                    ->onDelete('cascade');

            $table->foreign('booking_id')
                    ->references('id')
                    ->on('booking')
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
        Schema::dropIfExists('pembayaran');
    }
}
