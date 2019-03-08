<?php defined("SYSPATH") or die("No direct script access.");

class Controller_Audit extends Controller_User {
	public function before()
	{
		parent::before();

		$this->template->set('active_page', 'Audit Trail');
	}

	public function action_activities()
	{
		$keyword = $this->request->query('keyword') != NULL ? $this->request->query('keyword') : NULL;

		$audit = new Model_Audit;
		$trail = $audit->get_list($keyword);

		$view = View::factory('pages/audit')
			->set('trail', $trail)
			->set('keyword', $keyword);

		$this->template->set('content', $view);
	}
}