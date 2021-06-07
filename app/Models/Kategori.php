<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class Kategori extends Model
{
	use SoftDeletes;

	protected $table = 'kategori';
	protected $fillable = [
		'nama',
		'usia_mulai',
		'usia_sampai',
	];

	protected $appends = ['hashid'];

	public function getHashIdAttribute()
	{
		return \Hashids::encode( $this->attributes['id'] );
	}
}
