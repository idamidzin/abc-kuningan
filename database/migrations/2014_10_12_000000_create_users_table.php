<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role', 2);
            $table->string('nama_lengkap');
            $table->string('username');
            $table->string('password')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('alamat')->nullable();
            $table->string('kk_ktp')->nullable();
            $table->string('nohp', 15)->nullable();
            $table->char('jenis_kelamin', 1)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->boolean('is_status')->default(0)->nullable();
            $table->unsignedInteger('kategori_id')->index()->nullable();
            $table->string('foto')->nullable();
            $table->boolean('verifikasi')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kategori_id')
                    ->references('id')
                    ->on('kategori')
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
        Schema::dropIfExists('users');
    }
}
