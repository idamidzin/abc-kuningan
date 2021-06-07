<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class HistoriLatihan extends Model
{
	use SoftDeletes;

	protected $table = 'histori_latihan';
	protected $fillable = [
		'user_id',
		'jadwal_id',
		'tanggal',
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
}

