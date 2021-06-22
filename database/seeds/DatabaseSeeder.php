<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(KategoriTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(LapangTableSeeder::class);
        $this->call(PaketTableSeeder::class);
        $this->call(JadwalTableSeeder::class);
    }
}

