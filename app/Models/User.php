<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hashids\Hashids;

class User extends Authenticatable
{
	use Notifiable,SoftDeletes;
	
	protected $table = 'users';
	protected $fillable = [
		'role',
		'nama_lengkap',
		'username',
		'password',
		'email',
		'alamat',
		'kk_ktp',
		'nohp',
		'jenis_kelamin',
		'tanggal_lahir',
		'is_status',
		'kategori_id',
		'foto',
		'verifikasi',
	];

	protected $appends = ['hashid'];

	public function getHashIdAttribute()
	{
		return \Hashids::encode( $this->attributes['id'] );
	}

	protected $hidden = [
		'password'
	];
}
