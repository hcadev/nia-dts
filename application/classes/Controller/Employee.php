<?php defined("SYSPATH") or die("No direct script access.");

class Controller_Employee extends Controller_User {
	public function before()
	{
		parent::before();

		$this->template->set('active_page', 'Employees')
			->set('js', array('employee'));
	}

	public function action_list()
	{
		$keyword = $this->request->query('keyword') != FALSE ? $this->request->query('keyword') : NULL;

		$employees = new Model_Employees;
		$list = $employees->get_list($keyword);

		$this->template->set('content', View::factory('pages/employee_list')
			->set('keyword', $keyword)
			->set('employees', $list));
	}

	public function action_new()
	{
		$employees = new Model_Employees;
		$positions = $employees->get_positions(array('System Administrator'));

		$form = View::factory('forms/employee')
			->set('success', FALSE)
			->set('positions', $positions);

		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			if ($post = $this->request->post())
			{
				$post['user_id'] = $this->user['id'];

				list($success, $response) = $employees->create($post);

				if ($success)
				{
					$form->set('success', TRUE)
						->set('id', $response);

					$json['post_status'] = 'Success';
				}
				else
				{
					$form->set('employee', $post)
						->set('errors', $response);

					$json['post_status'] = 'Failed';
				}

				$json['html'] = $form->render();

				echo json_encode($json);
			}
			else echo $form;
		}
	}

	public function action_view()
	{
		$keyword = $this->request->query('keyword') != NULL ? $this->request->query('keyword') : NULL;

		$audit = new Model_Audit;
		$trail = $audit->get_list($keyword, $this->request->param('id'));

		$employees = new Model_Employees;
		$employee = $employees->get_info($this->request->param('id'));
		$positions = $employees->get_positions(array('System Administrator'));

		$form = View::factory('forms/employee')
			->set('employee', $employee)
			->set('positions', $positions)
			->set('success', FALSE);

		if ($post = $this->request->post())
		{
			$post = array_merge($employee, $post);
			$post['password'] = $employee['id'] != $this->user['id'] ? $employee['password'] : $post['password'];
			$post['confirm_password'] = $employee['id'] != $this->user['id'] ? $employee['password'] : $post['confirm_password'];

			list($success, $response) = $employees->update($post, $this->user['id']);

			if ($success) $form->set('success_update', TRUE);
			else $form->set('errors', $response);
		}

		$this->template->set('content', View::factory('pages/employee_view')
			->set('trail', $trail)
			->set('form', $form));
	}

	public function action_block()
	{
		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			if ($this->request->post())
			{
				$employees = new Model_Employees;
				list($success, $response) = $employees->block($this->request->post('id'), $this->user['id']);

				if ($success) $json['post_status'] = 'Success';
				else $json['post_status'] = $response;

				echo json_encode($json);
			}
		}
	}

	public function action_allow()
	{
		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			if ($this->request->post())
			{
				$employees = new Model_Employees;
				list($success, $response) = $employees->allow($this->request->post('id'), $this->user['id']);

				if ($success) $json['post_status'] = 'Success';
				else $json['post_status'] = $response;

				echo json_encode($json);
			}
		}
	}

	public function action_delete()
	{
		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			if ($this->request->post())
			{
				$employees = new Model_Employees;
				list($success, $response) = $employees->delete($this->request->post('id'));

				if ($success) $json['post_status'] = 'Success';
				else $json['post_status'] = $response;

				echo json_encode($json);
			}
		}
	}
}