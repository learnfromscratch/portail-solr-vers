<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SousGroupe extends Model
{
    protected $fillable = [
    	'name', 'groupe_id'
    ];

    public function groupe()
    {
    	return $this->belongsTo('App\Groupe');
    }

    public function users()
    {
    	return $this->hasMany('App\User');
    }
}
