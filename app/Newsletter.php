<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
	protected $fillable = ['user_id','email', 'periode_newslettre','date_envoie_newslettre','envoi_newslettre'];

	public function user() {
		return $this->belongsTo('App\User');
	}
}
