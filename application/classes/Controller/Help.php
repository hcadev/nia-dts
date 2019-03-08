<?php defined("SYSPATH") or die("No direct script access.");

class Controller_Help extends Controller_User {
	public function action_index()
	{
		$this->template->set('content', View::factory('pages/help'))
			->set('active_page', '');
	}
}