<?php defined("SYSPATH") or die("No direct script access.");

class Controller_Logout extends Controller_User {
	public function action_index()
	{
		$users = new Model_Users;
		$users->logout($this->user['id']);

		Session::instance()->destroy();
		$this->redirect('login');
	}
}