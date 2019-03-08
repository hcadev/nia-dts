<?php defined("SYSPATH") or die("No direct script access.");

abstract class Controller_User extends Controller_Template {
	public $user = [];

	public function before()
	{
		parent::before();

		$this->user = Session::instance()->get('user', []);

		if ( ! empty($this->user))
		{
			// Update user
			$users = new Model_Users;
			$this->user = $users->get_updated_details($this->user);

			if ( ! empty($this->user))
			{
				$this->user['privileges'] = explode('|', $this->user['privileges']);
				$this->template->set_global('user', $this->user);

				$this->notify();
			}
			else
			{
				Session::instance()->destroy();
				$this->redirect('login');
			}
		}
		else $this->redirect('login');
	}

	public function check_privilege()
	{

	}

	private function notify()
	{
		$projects = new Model_Projects;
		$incoming = $projects->get_incoming($this->user['id']);

		$this->template->set('incoming', $incoming);
	}
}