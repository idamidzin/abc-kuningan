<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
    		[
    			'nama_lengkap' => 'Yusuf',
    			'username' => 'admin',
    			'password' => bcrypt('1234'),
                'email' => 'idamidzin@gmail.com',
                'role' => '1',
                'verifikasi' => 1,
                'alamat' => null,
                'nohp' => null,
                'kategori_id' => null,
                'jenis_kelamin' => null,
                'tanggal_lahir' => null,
                'is_status' => true,
                'foto' => null,
            ],
            [
                'nama_lengkap' => 'Idam Idzin Dimiati',
                'username' => 'idam',
                'password' => bcrypt('1234'),
                'email' => 'idamidzin@gmail.com',
                'role' => '2',
                'verifikasi' => 1,
                'alamat' => 'Desa Cipasung, Rt10/Rw04 Kec. Darma',
                'nohp' => '082129960156',
                'kategori_id' => 3,
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1998-01-15',
                'is_status' => true,
                'foto' => null,
            ],
            [
                'nama_lengkap' => 'Ahmad Burhanudin',
                'username' => 'ahmad',
                'password' => bcrypt('1234'),
                'email' => 'ahmadburhan@gmail.com',
                'role' => '2',
                'verifikasi' => 1,
                'alamat' => 'Desa Cibening, Rt02/Rw08 Kec. Bungursari',
                'nohp' => '089121160156',
                'kategori_id' => 3,
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1998-06-12',
                'is_status' => true,
                'foto' => null,
            ]
        ]);
    }
}
