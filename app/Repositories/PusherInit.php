<?php

namespace App\Repositories;

use Pusher;
use Illuminate\Support\Facades\Auth;

/**
* 
*/
class PusherInit
{
	public $pusher;
	
	function __construct()
	{
		# code...
	}

	public function init()
	{
		$this->pusher = new Pusher("ca090a3a1702d459b7eb", "516c1f889e0c50177abf", "331263");

		$data['message'] = 'De nouveaux articles sont disponible';

		$this->pusher->trigger('notifications', 'Notification', $data);

		return $this->pusher;
	}
}