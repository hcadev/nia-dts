<?php defined("SYSPATH") or die("No direct script access.");

class Controller_Login extends Controller_Template {
	public function action_index()
	{
		if ($post = $this->request->post())
		{
			$users = new Model_Users;
			list($success, $account) = $users->authenticate($post);

			if ($success)
			{
				Session::instance()->set('user', $account);
				$this->redirect('home');
			}
			else $this->template->set('login_error', 'incorrect account details');
		}
	}
}