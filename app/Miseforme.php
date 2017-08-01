<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Miseforme extends Model
{
	protected $fillable = ['user_id','nombre_sidebar', 'article_par_page','color_background','color_widget'];

	public function user() {
		return $this->belongsTo('App\User');
	}
}
