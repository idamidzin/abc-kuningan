<?php

use Illuminate\Database\Seeder;

class PaketTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('paket')->insert([
    		[
    			'nama' => 'Paket 1 (Booking)',
    			'jumlah_jam' => '60',
    			'jumlah_hari' => '0',
    			'diskon' => null,
    			'harga' => '35000',
                'harga_perbulan' => NULL,
                'gambar' => 'paket1.jpg',
    			'for_use' => 'non-member'
    		],
    		[
    			'nama' => 'Paket 2 (Booking)',
    			'jumlah_jam' => '120',
    			'jumlah_hari' => '0',
    			'diskon' => null,
    			'harga' => '70000',
                'harga_perbulan' => NULL,
                'gambar' => 'paket2.jpg',
    			'for_use' => 'non-member'
    		],
    		[
    			'nama' => 'Paket 3 (Booking)',
    			'jumlah_jam' => '180',
    			'jumlah_hari' => '0',
    			'diskon' => null,
    			'harga' => '105000',
                'harga_perbulan' => NULL,
                'gambar' => 'paket3.jpg',
    			'for_use' => 'non-member'
    		],
            [
                'nama' => 'Paket Member',
                'jumlah_jam' => '180',
                'jumlah_hari' => '30',
                'diskon' => null,
                'harga' => '370000',
                'harga_perbulan' => NULL,
                'gambar' => 'paket-member.jpg',
                'for_use' => 'member'
            ],
            [
                'nama' => 'Pelatihan',
                'jumlah_jam' => '240',
                'jumlah_hari' => '30',
                'diskon' => null,
                'harga' => '900000',
                'harga_perbulan' => '600000',
                'gambar' => 'paket-diklat.jpg',
                'for_use' => 'diklat'
            ]
    	]);
    }
}
