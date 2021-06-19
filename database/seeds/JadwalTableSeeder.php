<?php

use Illuminate\Database\Seeder;

class JadwalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jadwal')->insert([
    		[
    			'kategori_id' => 1,
    			'lapang_id' => 1,
    			'jam_mulai' => '08:00:00',
    			'jam_selesai' => '12:00:00',
    			'hari' => 'minggu',
    		],
    		[
    			'kategori_id' => 2,
    			'lapang_id' => 2,
    			'jam_mulai' => '08:00:00',
    			'jam_selesai' => '12:00:00',
    			'hari' => 'minggu',
    		],
    		[
    			'kategori_id' => 3,
    			'lapang_id' => 3,
    			'jam_mulai' => '08:00:00',
    			'jam_selesai' => '12:00:00',
    			'hari' => 'minggu',
    		]
    	]);
    }
}
