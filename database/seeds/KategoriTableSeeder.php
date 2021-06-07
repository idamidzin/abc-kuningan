<?php

use Illuminate\Database\Seeder;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('kategori')->insert([
    		[
    			'nama' => 'Anak-anak',
    			'usia_mulai' => 12,
    			'usia_sampai' => 16,
    		],
    		[
    			'nama' => 'Remaja',
    			'usia_mulai' => 17,
    			'usia_sampai' => 20,
    		],
    		[
    			'nama' => 'Dewasa',
    			'usia_mulai' => 20,
    			'usia_sampai' => 25,
    		]
    	]);
    }
}
