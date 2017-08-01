<?php

namespace App\Repositories;
use App\Theme;

/**
* 
*/
class GetKeywords
{
	public $user;
	public $querySearched = "";
	public $querySearcheds = "";
	
	function __construct($user)
	{
		$this->user = $user;
	}

	public function getKeywordsByThemes($themes = [])
	{
		$this->querySearcheds = '';
		foreach ($themes as $theme) {
			foreach ($theme->keywords as $keyword)
				$this->querySearcheds .= '"'.$keyword->name.'" ';
		}

		return $this->querySearcheds;
	}
	public function getKeywordsByTheme($theme) {

		$this->querySearcheds = '';
		foreach ($theme->keywords as $keyword)
			$this->querySearcheds .= '"'.$keyword->name.'" ';
		

		return $this->querySearcheds;

	}
	public function get() {
		$this->querySearched = '';
		if ($this->user->role->name === 'SuperAdmin') {
			foreach ($this->user->groupe->themes as $theme) {
				foreach ($theme->keywords as $keyword)
					$this->querySearched .= '"'.$keyword->name.'" ';
			}
		}

		else {
			$tmps = explode(',', $this->user->sousGroupe->themes);
			
			foreach ($tmps as $tmp) {
				$themes = Theme::where('name', $tmp)->get();
				foreach ($themes as $theme) {
					$keywords = $theme->keywords;
					foreach ($keywords as $keyword) {
						$this->querySearched .= '"'.$keyword->name.'" ';
					}
				}
			}
		}

		return $this->querySearched;
	}
	
}