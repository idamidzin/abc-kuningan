<?php

use Illuminate\Database\Seeder;

class LapangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('lapang')->insert([
    		[
    			'nama' => 'Lapang A',
    			'foto' => 'lapang1.png',
                'keterangan' => 'Lapang ini '
    		],
    		[
    			'nama' => 'Lapang B',
    			'foto' => 'lapang2.jpg',
                'keterangan' => 'Lapang ini '
    		],
    		[
    			'nama' => 'Lapang C',
    			'foto' => 'lapang3.jpg',
                'keterangan' => 'Lapang ini tidak memiliki sesuatu'
    		]
    	]);
    }
}
