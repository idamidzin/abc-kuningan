<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class Paket extends Model
{
	use SoftDeletes;

	protected $table = 'paket';
	protected $fillable = [
		'nama',
		'jumlah_jam',
		'jumlah_hari',
		'diskon',
		'harga',
		'for_use',
		'deskripsi'
	];

	protected $appends = ['hashid'];

	public function getHashIdAttribute()
	{
		return \Hashids::encode( $this->attributes['id'] );
	}
}
