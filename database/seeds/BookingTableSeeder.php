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
                'paket_id' => 4,
                'lapang_id' => 2,
                'jadwal_id' => NULL,
                'nama_group' => 'PB Danton',
                'hari' => 'minggu',
                'tanggal_mulai' => '2021-06-06',
                'tanggal_selesai' => '2021-07-06',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '11:00:00',
                'jumlah_hari' => '30',
                'keterangan' => 'Booking member dong',
                'harga' => '370000',
                'status' => 0,
                'diskon' => NULL,
                'bukti_pembayaran' => NULL,
                'is_member' => false,
                'created_at' => '2021-06-01 00:00:00'
            ],
            [
                'user_id' => 3,
                'paket_id' => 5,
                'lapang_id' => 1,
                'jadwal_id' => 3,
                'nama_group' => NULL,
                'hari' => 'sabtu',
                'tanggal_mulai' => '2021-05-06',
                'tanggal_selesai' => '2021-06-06',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'jumlah_hari' => '30',
                'keterangan' => 'Pelatihan biar keren',
                'harga' => '600000',
                'status' => 0,
                'diskon' => NULL,
                'bukti_pembayaran' => NULL,
                'is_member' => false,
                'created_at' => '2021-06-02 00:00:00'
            ],
            [
                'user_id' => 2,
                'paket_id' => 5,
                'lapang_id' => 1,
                'jadwal_id' => 3,
                'nama_group' => NULL,
                'hari' => 'sabtu',
                'tanggal_mulai' => '2021-05-06',
                'tanggal_selesai' => '2021-06-06',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'jumlah_hari' => '30',
                'keterangan' => 'Pelatihan biar mantap lur',
                'harga' => '600000',
                'status' => 0,
                'diskon' => NULL,
                'bukti_pembayaran' => NULL,
                'is_member' => false,
                'created_at' => '2021-06-02 00:00:00'
            ]
        ]);
    }
}
