<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class Diklat extends Model
{
	use SoftDeletes;

	protected $table = 'diklat';
	protected $fillable = [
		'user_id',
		'tanggal_masuk',
		'is_aktif',
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
