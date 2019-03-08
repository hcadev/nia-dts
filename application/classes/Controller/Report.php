<?php defined("SYSPATH") or die("No direct script access.");

class Controller_Report extends Controller_User {
	public function before()
	{
		parent::before();

		$this->template->set('active_page', 'Reports')
			->set('js', array('report'));
	}

	public function action_index()
	{
		$projects = new Model_Projects;
		$municipalities = $projects->get_municipalities();
		$provinces = $projects->get_provinces();

		$this->template->set('content', View::factory('pages/report_generation')
			->set('municipalities', $municipalities)
			->set('provinces', $provinces)
		);
	}

	public function action_status()
	{
		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			$from = $this->request->post('from');
			$to = $this->request->post('to');
			$filter = $this->request->query('filter');
			$location = $this->request->post('municipality');

			$projects = new Model_Projects;
			$reports = $projects->get_status_report($from, $to, $filter, $location);

			echo View::factory('reports/status')
				->set('from', $from)
				->set('to', $to)
				->set('filter', $filter)
				->set('location', $location)
				->set('reports', $reports);
		}
	}

	public function action_statistics()
	{
		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			$from = date('Y-m', strtotime($this->request->post('from')));
			$to= date('Y-m', strtotime($this->request->post('to')));

			$projects = new Model_Projects;
			$reports = $projects->get_statistics_report($from, $to);

			echo View::factory('reports/statistics')
				->set('from', $from)
				->set('to', $to)
				->set('reports', $reports);
		}
	}
}