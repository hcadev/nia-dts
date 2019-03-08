<?php defined("SYSPATH") or die("No direct script access.");

class Controller_Notification extends Controller_User {
	public function before()
	{
		parent::before();
	}

	public function action_alert()
	{
		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;
			echo 'alert';
		}
	}
}