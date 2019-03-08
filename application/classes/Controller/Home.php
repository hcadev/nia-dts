<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_User {
	public function action_index()
	{
		$this->template->set('active_page', 'Home')
			->set('content', View::factory('pages/home'));
	}

} // End Welcome
