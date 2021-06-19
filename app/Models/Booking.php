<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class Booking extends Model
{
	use SoftDeletes;

	protected $table = 'booking';
	protected $fillable = [
		'user_id',
		'paket_id',
		'lapang_id',
		'hari',
		'tanggal_mulai',
		'tanggal_selesai',
		'nama_group',
		'jam_mulai',
		'jam_selesai',
		'jumlah_hari',
		'keterangan',
		'harga',
		'status',
		'diskon',
		'bukti_pembayaran',
		'is_member',
	];

	protected $appends = ['hashid'];

	public function getHashIdAttribute()
	{
		return \Hashids::encode( $this->attributes['id'] );
	}

	public function User()
	{
		return $this->belongsTo( User::class, 'user_id' );
	}

	public function Paket()
	{
		return $this->belongsTo( Paket::class, 'paket_id' );
	}

	public function Lapang()
	{
		return $this->belongsTo( Lapang::class, 'lapang_id' );
	}
	
}
