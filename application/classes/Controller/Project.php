<?php defined("SYSPATH") or die("No direct script access.");

class Controller_Project extends Controller_User {
	public function before()
	{
		parent::before();

		$this->template->set('active_page', 'Projects')
			->set('js', array('project'));
	}

	public function action_list()
	{
		$keyword = $this->request->query('keyword') != FALSE ? $this->request->query('keyword') : NULL;

		$projects = new Model_Projects;
		$list = $projects->get_list($keyword);

		$this->template->set('content', View::factory('pages/project_list')
			->set('keyword', $keyword)
			->set('projects', $list));
	}

	public function action_new()
	{
		$projects = new Model_Projects;
		$municipalities = $projects->get_municipalities();

		$form = View::factory('forms/project')
			->set('municipalities', $municipalities)
			->set('success', FALSE);

		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			if ($post = $this->request->post())
			{
				$post['created_by'] = $this->user['id'];
				list($success, $response) = $projects->create($post);

				if ($success)
				{
					$post['id'] = $response;

					$form->set('project', $post)
						->set('success', TRUE)
						->set('action', 'add');

					$json['post_status'] = 'Success';
				}
				else
				{
					$form->set('project', $post)
						->set('errors', $response);

					$json['post_status'] = 'Failed';
				}

				$json['html'] = $form->render();

				echo json_encode($json);
			}
			else echo $form;
		}
	}

	public function action_send()
	{
		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			$projects = new Model_Projects;
			$project = $projects->get_info($this->request->query('project_id'));

			$employees = new Model_Employees;
			$employee = [];
			if (empty($project['recipient_id']) || $project['recipient_position'] == 'Regional Irrigation Manager\'s Secretary') $employee = $employees->get_recipient_info('Head of Planning & Design Unit');
			elseif ($project['transition_status'] == 'Approved' &&  $project['recipient_position'] == 'Head of Planning & Design Unit') $employee = $employees->get_recipient_info('Head of Planning & Design Section');
			elseif ($project['transition_status'] == 'Approved' &&  $project['recipient_position'] == 'Head of Planning & Design Section') $employee = $employees->get_recipient_info('Division Manager');
			elseif ($project['transition_status'] == 'Approved' && $project['recipient_position'] == 'Division Manager') $employee = $employees->get_recipient_info('Regional Irrigation Manager');
			elseif ($project['transition_status'] == 'Approved' && $project['recipient_position'] == 'Regional Irrigation Manager') $employee = $employees->get_recipient_info('Regional Irrigation Manager\'s Secretary');
			elseif ($project['transition_status'] == 'Declined' && $project['recipient_position'] == 'Head of Planning & Design Unit') $employee = $employees->get_recipient_info('Regional Irrigation Manager\'s Secretary');
			elseif ($project['transition_status'] == 'Declined' && $project['recipient_position'] == 'Head of Planning & Design Section') $employee = $employees->get_recipient_info('Head of Planning & Design Unit');
			elseif ($project['transition_status'] == 'Declined' && $project['recipient_position'] == 'Division Manager') $employee = $employees->get_recipient_info('Head of Planning & Design Section');
			elseif ($project['transition_status'] == 'Declined' && $project['recipient_position'] == 'Regional Irrigation Manager') $employee = $employees->get_recipient_info('Division Manager');

			$form = View::factory('dialogs/send_project')
				->set('employee', $employee)
				->set('project', $project);

			if ($post = $this->request->post())
			{
				list($success, $response) = $projects->send($project['id'], $this->user['id'], $post['recipient_id'], $post['remarks']);

				if ($success) $json['post_status'] = 'Success';
				else
				{
					$form->set('error', $response);

					$json['post_status'] = 'Failed';
					$json['html'] = $form->render();
				}

				echo json_encode($json);
			}
			else echo $form;
		}
	}

	public function action_receive()
	{
		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			$projects = new Model_Projects;
			list($success, $response) = $projects->receive($this->request->query('project_id'));

			if ($success) echo 'Success';
		}
	}

	public function action_edit()
	{
		$form = View::factory('forms/project')
			->set('success', FALSE);

		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			$projects = new Model_Projects;
			$project = $projects->get_info($this->request->query('id'));
			$municipalities = $projects->get_municipalities();

			$form->set('municipalities', $municipalities)
				->set('project', $project);

			if ($post = $this->request->post())
			{
				$post = array_merge($project, $post);
				$post['last_modified_by'] = $this->user['id'];

				list($success, $response) = $projects->update($post);

				if ($success)
				{
					$form->set('project', $post)
						->set('success', TRUE)
						->set('action', 'update');

					$json['post_status'] = 'Success';
				}
				else
				{
					$form->set('project', $post)
						->set('errors', $response);

					$json['post_status'] = 'Failed';
				}

				$json['html'] = $form->render();

				echo json_encode($json);
			}
			else echo $form;
		}
	}

	public function action_delete()
	{
		$form = View::factory('dialogs/delete_project');

		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			$projects = new Model_Projects;
			$project = $projects->get_info($this->request->query('id'));

			$form->set('project', $project);

			if ($this->request->post())
			{
				$project['last_modified_by'] = $this->user['id'];

				list($success, $response) = $projects->delete($project);

				if ($success)
				{
					$form->set('project', $project)
						->set('id', $response);

					$json['post_status'] = 'Success';
				}
				else
				{
					$form->set('project', $project)
						->set('error', $response);

					$json['post_status'] = 'Failed';
				}

				$json['html'] = $form->render();

				echo json_encode($json);
			}
			else echo $form;
		}
	}

	public function action_restore()
	{
		$form = View::factory('dialogs/restore_project');

		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			$projects = new Model_Projects;
			$project = $projects->get_info($this->request->query('id'));

			$form->set('project', $project);

			if ($this->request->post())
			{
				$project['last_modified_by'] = $this->user['id'];

				list($success, $response) = $projects->restore($project);

				if ($success)
				{
					$form->set('project', $project)
						->set('id', $response);

					$json['post_status'] = 'Success';
				}
				else
				{
					$form->set('project', $project)
						->set('error', $response);

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
		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			if ($this->request->query('project') != FALSE && $this->request->query('project') == 'start') $this->start_project();
			elseif ($this->request->query('project') != FALSE && $this->request->query('project') == 'extend') $this->extend_project();
			elseif ($this->request->query('project') != FALSE && $this->request->query('project') == 'complete') $this->complete_project();
			elseif ($this->request->query('project') != FALSE && $this->request->query('project') == 'send') $this->send_project();
			elseif ($this->request->query('project') != FALSE && $this->request->query('project') == 'receive') $this->receive_project();
			elseif ($this->request->query('project') != FALSE && $this->request->query('project') == 'approve') $this->approve_project();
			elseif ($this->request->query('project') != FALSE && $this->request->query('project') == 'decline') $this->decline_project();
			elseif ($this->request->query('project') != FALSE && $this->request->query('project') == 'history') $this->project_history();
			elseif ($this->request->query('project') != FALSE && $this->request->query('project') == 'edit') $this->edit_project();
			elseif ($this->request->query('project') != FALSE && $this->request->query('project') == 'progress') $this->set_project_progress();

			if ($this->request->query('attachment') != FALSE && $this->request->query('attachment') == 'upload') $this->upload_attachment();
			elseif ($this->request->query('attachment') != FALSE && $this->request->query('attachment') == 'view') $this->view_attachment();
//			elseif ($this->request->query('attachment') != FALSE && $this->request->query('attachment') == 'delete') $this->delete_attachment();
			elseif ($this->request->query('attachment') != FALSE && $this->request->query('attachment') == 'replace') $this->replace_attachment();

			if ($this->request->query('report') != FALSE && $this->request->query('report') == 'upload') $this->upload_report();
//			elseif ($this->request->query('report') != FALSE && $this->request->query('report') == 'delete') $this->delete_report();
			elseif ($this->request->query('report') != FALSE && $this->request->query('report') == 'replace') $this->replace_report();
			elseif ($this->request->query('report') != FALSE && $this->request->query('report') == 'view') $this->view_report();
		}
		else
		{
			$projects = new Model_Projects;
			$project = $projects->get_info($this->request->param('id'));
			$attachments = $projects->get_attachments($project['id']);
			$reports = $projects->get_reports($project['id']);

			$this->template->set('content', View::factory('pages/project_view')
				->set('project', $project)
				->set('attachments', $attachments)
				->set('reports', $reports));
		}
	}

	private function start_project()
	{
		$projects = new Model_Projects;
		list($success, $response) = $projects->start($this->request->param('id'), $this->request->post('completion_date'), $this->user['id']);

		if ($success) $json['post_status'] = 'Success';
		else
		{
			$json['post_status'] = 'Failed';
			$json['error'] = $response;
		}

		echo json_encode($json);
	}

	private function extend_project()
	{
		$projects = new Model_Projects;
		$project = $projects->get_info($this->request->param('id'));

		$form = View::factory('dialogs/extend_project')
			->set('project', $project);

		if ($post = $this->request->post())
		{
			list($success, $response) = $projects->extend($project['id'], $post['completion_date'], $this->user['id']);

			if ($success) $json['post_status'] = 'Success';
			else
			{
				$form->set('error', $response);

				$json['post_status'] = 'Failed';
				$json['html'] = $form->render();
			}

			echo json_encode($json);
		}
		else echo $form;
	}

	private function complete_project()
	{
		$form = View::factory('dialogs/complete_project');

		if ($post = $this->request->post())
		{
			$projects = new Model_Projects;
			list($success, $response) = $projects->complete($this->request->param('id'), $this->user['id']);

			if ($success) $json['post_status'] = 'Success';
			else
			{
				$form->set('error', $response);

				$json['post_status'] = 'Failed';
				$json['html'] = $form->render();
			}

			echo json_encode($json);
		}
		else echo $form;
	}

	private function send_project()
	{
		$projects = new Model_Projects;
		$project = $projects->get_info($this->request->param('id'));

		$employees = new Model_Employees;
		$employee = [];
		if (empty($project['recipient_id']) || $project['recipient_position'] == 'Regional Irrigation Manager\'s Secretary') $employee = $employees->get_recipient_info('Head of Planning & Design Unit');
		elseif ($project['transition_status'] == 'Approved' &&  $project['recipient_position'] == 'Head of Planning & Design Unit') $employee = $employees->get_recipient_info('Head of Planning & Design Section');
		elseif ($project['transition_status'] == 'Approved' &&  $project['recipient_position'] == 'Head of Planning & Design Section') $employee = $employees->get_recipient_info('Division Manager');
		elseif ($project['transition_status'] == 'Approved' && $project['recipient_position'] == 'Division Manager') $employee = $employees->get_recipient_info('Regional Irrigation Manager');
		elseif ($project['transition_status'] == 'Approved' && $project['recipient_position'] == 'Regional Irrigation Manager') $employee = $employees->get_recipient_info('Regional Irrigation Manager\'s Secretary');
		elseif ($project['transition_status'] == 'Declined' && $project['recipient_position'] == 'Head of Planning & Design Unit') $employee = $employees->get_recipient_info('Regional Irrigation Manager\'s Secretary');
		elseif ($project['transition_status'] == 'Declined' && $project['recipient_position'] == 'Head of Planning & Design Section') $employee = $employees->get_recipient_info('Head of Planning & Design Unit');
		elseif ($project['transition_status'] == 'Declined' && $project['recipient_position'] == 'Division Manager') $employee = $employees->get_recipient_info('Head of Planning & Design Section');
		elseif ($project['transition_status'] == 'Declined' && $project['recipient_position'] == 'Regional Irrigation Manager') $employee = $employees->get_recipient_info('Division Manager');

		$form = View::factory('dialogs/send_project')
			->set('employee', $employee)
			->set('project', $project);

		if ($post = $this->request->post())
		{
			list($success, $response) = $projects->send($project['id'], $this->user['id'], $post['recipient_id'], $post['remarks']);

			if ($success) $json['post_status'] = 'Success';
			else
			{
				$form->set('error', $response);

				$json['post_status'] = 'Failed';
				$json['html'] = $form->render();
			}

			echo json_encode($json);
		}
		else echo $form;
	}

	private function receive_project()
	{
		$projects = new Model_Projects;
		list($success, $response) = $projects->receive($this->request->param('id'));

		if ($success) echo 'Success';
	}

	private function approve_project()
	{
		$projects = new Model_Projects;
		list($success, $response) = $projects->approve($this->request->param('id'), $this->user['id'], $this->user['position']);

		if ($success) echo 'Success';
	}

	private function decline_project()
	{
		$projects = new Model_Projects;
		list($success, $response) = $projects->decline($this->request->param('id'), $this->user['id']);

		if ($success) echo 'Success';
	}

	private function project_history()
	{
		$projects = new Model_Projects;
		$history = $projects->history($this->request->param('id'));

		echo View::factory('dialogs/project_history')
			->set('history', $history);
	}

	private function edit_project()
	{
		$form = View::factory('forms/project')
			->set('success', FALSE);

		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			$projects = new Model_Projects;
			$project = $projects->get_info($this->request->param('id'));
			$municipalities = $projects->get_municipalities();

			$form->set('municipalities', $municipalities)
				->set('project', $project);

			if ($post = $this->request->post())
			{
				$post = array_merge($project, $post);
				$post['last_modified_by'] = $this->user['id'];

				list($success, $response) = $projects->update($post);

				if ($success)
				{
					$form->set('project', $post)
						->set('success', TRUE)
						->set('action', 'update');

					$json['post_status'] = 'Success';
				}
				else
				{
					$form->set('project', $post)
						->set('errors', $response);

					$json['post_status'] = 'Failed';
				}

				$json['html'] = $form->render();

				echo json_encode($json);
			}
			else echo $form;
		}
	}

	public function set_project_progress()
	{
		$form = View::factory('dialogs/project_progress')
			->set('success', FALSE);

		if ($this->request->is_ajax())
		{
			$this->auto_render = FALSE;

			$projects = new Model_Projects;
			$project = $projects->get_info($this->request->param('id'));

			$form->set('project', $project);

			if ($post = $this->request->post())
			{
				$post = array_merge($project, $post);
				$post['last_modified_by'] = $this->user['id'];

				list($success, $response) = $projects->update($post);

				if ($success)
				{
					$form->set('project', $post)
						->set('success', TRUE)
						->set('action', 'update');

					$json['post_status'] = 'Success';
				}
				else
				{
					$form->set('project', $post)
						->set('errors', $response);

					$json['post_status'] = 'Failed';
				}

				$json['html'] = $form->render();

				echo json_encode($json);
			}
			else echo $form;
		}
	}

	private function upload_attachment()
	{
		$form = View::factory('forms/attachment');

		if ( ! empty($_FILES['file']))
		{
			$projects = new Model_Projects();
			list($success, $response) = $projects->upload_attachment($_FILES['file'], $this->request->param('id'), $this->request->query('attachment_id'), $this->user['id']);

			if ($success) $json['post_status'] = 'Success';
			else
			{
				$json['post_status'] = 'Failed';
				$json['html'] = $form->set('error', is_string($response) ? $response : NULL)
					->set('errors', is_array($response) ? $response : NULL)
					->render();
			}

			echo json_encode($json);
		}
		else echo $form;
	}

	private function view_attachment()
	{
		$projects = new Model_Projects;

		echo View::factory('pages/attachment_view')
			->set('attachment', $projects->get_attachment_info($this->request->param('id'), $this->request->query('attachment_id')))
			->set('revisions', $projects->get_attachment_revisions($this->request->param('id'), $this->request->query('attachment_id')));
	}

	private function delete_attachment()
	{
		$projects = new Model_Projects;
		$attachment_info = $projects->get_attachment_info($this->request->param('id'), $this->request->query('attachment_id'));

		$form = View::factory('dialogs/delete_attachment')
			->set('attachment', $attachment_info);

		if ($this->request->post())
		{
			list($success, $response) = $projects->delete_attachment($this->request->param('id'), $attachment_info['attachment_id'], $this->user['id']);

			if ($success) $json['post_status'] = 'Success';
			else
			{
				$form->set('attachment', $attachment_info)
					->set('error', $response);

				$json['html'] = $form->render();
				$json['post_status'] = 'Failed';
			}

			echo json_encode($json);
		}
		else echo $form;
	}

	private function replace_attachment()
	{
		$form = View::factory('forms/attachment');

		if ( ! empty($_FILES['file']))
		{
			$projects = new Model_Projects();
			list($success, $response) = $projects->upload_attachment($_FILES['file'], $this->request->param('id'), $this->request->query('attachment_id'), $this->user['id'], TRUE);

			if ($success) $json['post_status'] = 'Success';
			else
			{
				$json['post_status'] = 'Failed';
				$json['html'] = $form->set('error', is_string($response) ? $response : NULL)
					->set('errors', is_array($response) ? $response : NULL)
					->render();
			}

			echo json_encode($json);
		}
		else echo $form;
	}

	private function upload_report()
	{
		$projects = new Model_Projects();
		$form = View::factory('forms/report')
			->set('project', $projects->get_info($this->request->param('id')));

		if ($this->request->post())
		{
			list($success, $response) = $projects->upload_report($this->request->param('id'), empty($_FILES['file']) ? [] : $_FILES['file'], $this->request->post(), $this->user['id']);

			if ($success) $json['post_status'] = 'Success';
			else
			{
				$form->set('report', $this->request->post())
					->set('error', is_string($response) ? $response : NULL)
					->set('errors', is_array($response) ? $response : NULL);

				$json['post_status'] = 'Failed';
				$json['html'] = $form->render();
			}

			echo json_encode($json);
		}
		else echo $form;
	}

	private function replace_report()
	{
		$projects = new Model_Projects();
		$form = View::factory('forms/report')
			->set('replace', TRUE)
			->set('project', $projects->get_info($this->request->param('id')))
			->set('report', $projects->get_report_info($this->request->query('report_id')));

		if ($this->request->post())
		{
			list($success, $response) = $projects->upload_report($this->request->param('id'), empty($_FILES['file']) ? [] : $_FILES['file'], $this->request->post(), $this->user['id'], TRUE, $this->request->query('report_id'));

			if ($success) $json['post_status'] = 'Success';
			else
			{
				$form->set('report', $this->request->post())
					->set('error', is_string($response) ? $response : NULL)
					->set('errors', is_array($response) ? $response : NULL);

				$json['post_status'] = 'Failed';
				$json['html'] = $form->render();
			}

			echo json_encode($json);
		}
		else echo $form;
	}

	private function delete_report()
	{
		$projects = new Model_Projects;
		$report_info = $projects->get_report_info($this->request->query('report_id'));

		$form = View::factory('dialogs/delete_report')
			->set('report', $report_info);

		if ($this->request->post())
		{
			list($success, $response) = $projects->delete_report($report_info['id'], $this->user['id']);

			if ($success) $json['post_status'] = 'Success';
			else
			{
				$form->set('report', $report_info)
					->set('error', $response);

				$json['html'] = $form->render();
				$json['post_status'] = 'Failed';
			}

			echo json_encode($json);
		}
		else echo $form;
	}

	private function view_report()
	{
		$projects = new Model_Projects;

		echo View::factory('pages/report_view')
			->set('report', $projects->get_report_info($this->request->query('report_id')))
			->set('revisions', $projects->get_report_revisions($this->request->query('report_id')));
	}
}