<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class Pembayaran extends Model
{
	use SoftDeletes;

	protected $table = 'pembayaran';
	protected $fillable = [
		'diklat_id',
		'tanggal_bayar',
		'bukti_pembayaran',
	];

	protected $appends = ['hashid'];

	public function getHashIdAttribute()
	{
		return \Hashids::encode( $this->attributes['id'] );
	}

	public function Diklat()
	{
		return $this->belongsTo( Diklat::class, 'diklat_id' );
	}
}

