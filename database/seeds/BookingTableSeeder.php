<?php

use Illuminate\Database\Seeder;

class BookingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('booking')->insert([
    		[
    			'user_id' => 2,
                'paket_id' => 1,
                'lapang_id' => 2,
                'tanggal_mulai' => '2021-06-06',
                'tanggal_selesai' => '2021-06-06',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '09:00:00',
                'jumlah_hari' => '0',
                'keterangan' => 'Booking mang',
                'harga' => '35000',
                'status' => 0,
                'diskon' => NULL,
                'bukti_pembayaran' => 'bukti.jpeg',
                'is_member' => false,
            ]
        ]);
    }
}
