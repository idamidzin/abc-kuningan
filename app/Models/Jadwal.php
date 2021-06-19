<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hashids\Hashids;

class Jadwal extends Model
{
	use SoftDeletes;

	protected $table = 'jadwal';
	protected $fillable = [
		'kategori_id',
		'jam_mulai',
		'jam_selesai',
		'hari',
		'lapang_id',
	];

	protected $appends = ['hashid'];

	public function getHashIdAttribute()
	{
		return \Hashids::encode( $this->attributes['id'] );
	}

	public function Kategori()
	{
		return $this->belongsTo( Kategori::class, 'kategori_id' );
	}

	public function Lapang()
	{
		return $this->belongsTo( Lapang::class, 'lapang_id' );
	}
}
