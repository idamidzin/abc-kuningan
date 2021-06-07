<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class Lapang extends Model
{
	use SoftDeletes;

	protected $table = 'lapang';
	protected $fillable = [
		'nama',
		'keterangan',
		'foto',
	];

	protected $appends = ['hashid'];

	public function getHashIdAttribute()
	{
		return \Hashids::encode( $this->attributes['id'] );
	}
}
