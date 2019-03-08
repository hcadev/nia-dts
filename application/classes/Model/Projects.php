<?php defined("SYSPATH") or die("No direct script access.");

class Model_Projects extends Model_Database {
	public function create(&$project)
	{
		$project = $this->clean($project);

		if (empty($errors = $this->validate($project)))
		{
			try
			{
				Database::instance()->begin();

				$query = "INSERT INTO projects VALUES(NULL, :date_proposed, :title, :name, :category, :description, :municipality_id, :cost, :area, :area_unit, NULL, NULL, 'Pending Approval', NOW(), :created_by, NULL, NULL, 0, 0, 0, 0)";

				list($id, $rows) = DB::query(Database::INSERT, $query)
					->parameters(array(
						':date_proposed' => $project['date_proposed'],
						':title' => $project['title'],
						':name' => $project['name'],
						':category' => $project['category'],
						':description' => $project['description'],
						':municipality_id' => $project['municipality_id'],
						':cost' => $project['cost'],
						':area' => $project['area'],
						':area_unit' => $project['area_unit'],
						':created_by' => $project['created_by'],
					))
					->execute();

				DB::query(NULL, "INSERT INTO project_attachments (SELECT :project_id, id, NULL, NULL, NULL, NULL FROM attachments ORDER BY sequence)")
					->param(':project_id', $id)
					->execute();

				Database::instance()->commit();

				return array(TRUE, $id);
			}
			catch (Database_Exception $e)
			{
				Database::instance()->rollback();

				return array(FALSE, "Database error, unable to create project.");
			}
		}
		else return array(FALSE, $errors);
	}

	public function update(&$project)
	{
		$project = $this->clean($project);

		if (empty($errors = $this->validate($project)))
		{
			try
			{
				Database::instance()->begin();

				$query = "UPDATE projects SET date_proposed = :date_proposed, title = :title, name = :name, category = :category, description = :description, municipality_id = :municipality_id, cost = :cost, area = :area, area_unit = :area_unit, last_modified = NOW(), last_modified_by = :last_modified_by, pa_progress = :pa_progress, fr_progress = :fr_progress WHERE id = :id";

				DB::query(NULL, $query)
					->parameters(array(
						':id' => $project['id'],
						':date_proposed' => $project['date_proposed'],
						':title' => $project['title'],
						':name' => $project['name'],
						':category' => $project['category'],
						':description' => $project['description'],
						':municipality_id' => $project['municipality_id'],
						':cost' => $project['cost'],
						':area' => $project['area'],
						':area_unit' => $project['area_unit'],
						':last_modified_by' => $project['last_modified_by'],
						':pa_progress' => empty($project['pa_progress']) ? 0 : $project['pa_progress'],
						':fr_progress' => empty($project['fr_progress']) ? 0 : $project['fr_progress'],
					))
					->execute();

				Database::instance()->commit();

				return array(TRUE, $project['id']);
			}
			catch (Database_Exception $e)
			{
				Database::instance()->rollback();

				return array(FALSE, "Database error, unable to update project.");
			}
		}
		else return array(FALSE, $errors);
	}

	public function delete($project)
	{
		try
		{
			Database::instance()->begin();

			DB::query(NULL, "UPDATE projects SET deleted = 1, last_modified = NOW(), last_modified_by = :last_modified_by WHERE id = :id")
				->parameters(array(
					':last_modified_by' => $project['last_modified_by'],
					':id' => $project['id'],
				))
				->execute();

			Database::instance()->commit();

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			Database::instance()->rollback();

			return array(FALSE, 'Database error, unable to delete project.');
		}
	}

	public function restore($project)
	{
		try
		{
			Database::instance()->begin();

			DB::query(NULL, "UPDATE projects SET deleted = 0, last_modified = NOW(), last_modified_by = :last_modified_by WHERE id = :id")
				->parameters(array(
					':last_modified_by' => $project['last_modified_by'],
					':id' => $project['id'],
				))
				->execute();

			Database::instance()->commit();

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			Database::instance()->rollback();

			return array(FALSE, 'Database error, unable to restore project.');
		}
	}

	public function get_info($id)
	{
		$query = "SELECT p.*, pap.file_count, pa.total_file_count, IFNULL(pt.sender_id, (SELECT e.id FROM employees e JOIN positions p ON e.position_id = p.id WHERE p.name = '".addslashes("Regional Irrigation Manager's Secretary")."' AND e.status = 'Active')) AS 'sender_id', IFNULL(s.sender_name, (SELECT CONCAT_WS('', last_name, ', ', given_name, ' ', middle_name, ' ', name_suffix) FROM employees e JOIN positions p ON e.position_id = p.id WHERE p.name = '".addslashes("Regional Irrigation Manager's Secretary")."' AND e.status = 'Active')) AS 'sender_name', pt.recipient_id, r.recipient_name, pt.status AS 'transition_status', pt.remarks, IFNULL(ps.name, '".addslashes("Regional Irrigation Manager's Secretary")."') AS 'sender_position', pr.name AS 'recipient_position', m.name 'municipality_name'
 				  FROM projects p
 				  LEFT JOIN municipalities m ON p.municipality_id = m.id
 				  LEFT JOIN (SELECT project_id, count(project_id) AS 'total_file_count' FROM project_attachments GROUP BY project_id) pa ON pa.project_id = p.id
 				  LEFT JOIN (SELECT project_id, count(filename) AS 'file_count' FROM project_attachments GROUP BY project_id) pap ON pap.project_id = p.id
 				  LEFT JOIN (SELECT project_id, sender_id, recipient_id, status, remarks FROM project_transition WHERE project_id = :id ORDER BY date_recorded DESC LIMIT 1) pt ON pt.project_id = p.id
 				  LEFT JOIN (SELECT id, CONCAT_WS('', last_name, ', ', given_name, ' ', middle_name, ' ', name_suffix) AS 'sender_name', position_id FROM employees) s ON s.id = pt.sender_id
 				  LEFT JOIN (SELECT id, CONCAT_WS('', last_name, ', ', given_name, ' ', middle_name, ' ', name_suffix) AS 'recipient_name', position_id FROM employees) r ON r.id = pt.recipient_id
 				  LEFT JOIN positions ps ON ps.id = s.position_id
 				  LEFT JOIN positions pr ON pr.id = r.position_id
 				  WHERE p.id = :id";

		return DB::query(Database::SELECT, $query)
			->param(':id', $id)
			->execute()
			->current();
	}

	public function get_list($keyword)
	{
		$query = "SELECT p.*, pap.file_count, pa.total_file_count, IFNULL(pt.sender_id, (SELECT e.id FROM employees e JOIN positions p ON e.position_id = p.id WHERE p.name = '".addslashes("Regional Irrigation Manager's Secretary")."' AND e.status = 'Active')) AS 'sender_id', IFNULL(s.sender_name, (SELECT CONCAT_WS('', last_name, ', ', given_name, ' ', middle_name, ' ', name_suffix) FROM employees e JOIN positions p ON e.position_id = p.id WHERE p.name = '".addslashes("Regional Irrigation Manager's Secretary")."' AND e.status = 'Active')) AS 'sender_name', pt.recipient_id, r.recipient_name, pt.status AS 'transition_status', pt.remarks, IFNULL(ps.name, '".addslashes("Regional Irrigation Manager's Secretary")."') AS 'sender_position', pr.name AS 'recipient_position'
 				  FROM projects p
 				  LEFT JOIN (SELECT project_id, count(project_id) AS 'total_file_count' FROM project_attachments GROUP BY project_id) pa ON pa.project_id = p.id
 				  LEFT JOIN (SELECT project_id, count(filename) AS 'file_count' FROM project_attachments GROUP BY project_id) pap ON pap.project_id = p.id
 				  LEFT JOIN (SELECT a.project_id, a.sender_id, a.recipient_id, a.status, a.remarks FROM project_transition a JOIN (SELECT project_id, MAX(date_recorded) 'date_recorded' FROM project_transition GROUP BY project_id) b ON a.project_id = b.project_id AND a.date_recorded = b.date_recorded) pt ON pt.project_id = p.id
 				  LEFT JOIN (SELECT id, CONCAT_WS('', last_name, ', ', given_name, ' ', middle_name, ' ', name_suffix) AS 'sender_name', position_id FROM employees) s ON s.id = pt.sender_id
 				  LEFT JOIN (SELECT id, CONCAT_WS('', last_name, ', ', given_name, ' ', middle_name, ' ', name_suffix) AS 'recipient_name', position_id FROM employees) r ON r.id = pt.recipient_id
 				  LEFT JOIN positions ps ON ps.id = s.position_id
 				  LEFT JOIN positions pr ON pr.id = r.position_id
 				  WHERE (:keyword IS NULL OR p.id LIKE :keyword OR DATE_FORMAT(p.date_proposed, '%M %d, %Y') LIKE :keyword OR p.name LIKE :keyword OR p.status LIKE :keyword)
 				  ORDER BY p.date_created DESC";

		return DB::query(Database::SELECT, $query)
			->param(':keyword', empty($keyword) ? NULL : '%'.$keyword.'%')
			->execute()
			->as_array();
	}

	public function get_incoming($user_id)
	{
		return DB::query(Database::SELECT, "SELECT pt.*, p.name FROM project_transition pt LEFT JOIN projects p ON pt.project_id = p.id WHERE pt.status = 'Sent' AND pt.recipient_id = :id ORDER BY pt.date_recorded ASC")
			->param(':id', $user_id)
			->execute()
			->as_array();
	}

	public function get_municipalities()
	{
		return DB::query(Database::SELECT, "SELECT * FROM municipalities ORDER BY name ASC")
			->execute()
			->as_array();
	}

	public function get_provinces()
	{
		return DB::query(Database::SELECT, "SELECT DISTINCT SUBSTRING_INDEX(name, ',', -1) 'name' FROM municipalities ORDER BY name ASC")
			->execute()
			->as_array();
	}

	public function get_attachments($id)
	{
		$query = "SELECT pa.*, a.*, ctr.revisions FROM project_attachments pa
				  JOIN attachments a ON pa.attachment_id = a.id
				  LEFT JOIN (SELECT count(id) 'revisions', project_id, attachment_id FROM project_attachment_revisions GROUP BY project_id, attachment_id) ctr ON ctr.project_id = pa.project_id AND ctr.attachment_id = pa.attachment_id
				  WHERE pa.project_id = :id
				  ORDER BY a.sequence ASC";

		return DB::query(Database::SELECT, $query)
			->param(':id', $id)
			->execute()
			->as_array();
	}

	public function get_attachment_info($project_id, $attachment_id)
	{
		$query = "SELECT pa.*, a.category, a.sub_category, a.name, e.given_name, e.middle_name, e.last_name, e.name_suffix
				  FROM project_attachments pa
				  LEFT JOIN attachments a ON pa.attachment_id = a.id
				  LEFT JOIN employees e ON pa.uploaded_by = e.id
				  WHERE pa.project_id = :project_id AND pa.attachment_id = :attachment_id";

		return DB::query(Database::SELECT, $query)
			->parameters(array(
				':project_id' => $project_id,
				':attachment_id' => $attachment_id,
			))
			->execute()
			->current();
	}

	public function get_attachment_revisions($project_id, $attachment_id)
	{
		$query = "SELECT * FROM project_attachment_revisions WHERE project_id = :project_id AND attachment_id = :attachment_id ORDER BY date_uploaded DESC";

		return DB::query(Database::SELECT, $query)
			->parameters(array(
				':project_id' => $project_id,
				':attachment_id' => $attachment_id,
			))
			->execute();
	}

	public function upload_attachment($file, $project_id, $attachment_id, $user_id, $replace = FALSE)
	{
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

		if ($ext != 'pdf') return array(FALSE, array('file' => 'must be a pdf file'));

		Database::instance()->begin();

		$attachment_info = $this->get_attachment_info($project_id, $attachment_id);

		$filepath = 'assets/projects/'.$project_id.'/';
		$filepath .= empty($attachment_info['category']) ? '' : str_replace(' ', '_', $attachment_info['category']).'/';
		$filepath .= empty($attachment_info['sub_category']) ? '' : str_replace(' ', '_', $attachment_info['sub_category']).'/';

		$filename = str_replace(array(' ', '/'), '', $attachment_info['name']).strtotime('now').'.'.$ext;

		try
		{
			if ( ! is_dir($filepath)) mkdir($filepath, NULL, TRUE);
			move_uploaded_file($file['tmp_name'], $filepath.$filename);
		}
		catch (Exception $e)
		{
			return array(FALSE, 'Storage error, unable to upload attachment.');
		}

		try
		{
			if ($replace)
			{
				DB::query(Database::INSERT, "INSERT INTO project_attachment_revisions (SELECT NULL, project_id, attachment_id, filepath, filename, date_uploaded, uploaded_by FROM project_attachments WHERE project_id = :project_id AND attachment_id = :attachment_id)")
					->parameters(array(
						':project_id' => $project_id,
						':attachment_id' => $attachment_id
					))
					->execute();
			}

			DB::query(NULL, "UPDATE project_attachments SET filepath = :filepath, filename = :filename, date_uploaded = NOW(), uploaded_by = :uploaded_by WHERE project_id = :project_id AND attachment_id = :attachment_id")
				->parameters(array(
					':project_id' => $project_id,
					':attachment_id' => $attachment_id,
					':filepath' => $filepath,
					':filename' => $filename,
					':uploaded_by' => $user_id,
				))
				->execute();
		}
		catch (Database_Exception $e)
		{
			Database::instance()->rollback();

			return array(FALSE, 'Database error, unable to upload attachment.');
		}

		Database::instance()->commit();

		return array(TRUE, NULL);
	}

	public function delete_attachment($project_id, $attachment_id, $user_id)
	{
		$attachment_info = $this->get_attachment_info($project_id, $attachment_id);

		Database::instance()->begin();

		try
		{
			unlink($attachment_info['filepath'].$attachment_info['filename']);
		}
		catch (Exception $e)
		{
			return array(FALSE, 'Storage error, unable to delete attachment.');
		}

		try
		{
			// This is to log the current user as the deleter of this attachment, see triggers
			DB::query(NULL, "UPDATE project_attachments SET filepath = NULL, filename = NULL, date_uploaded = NULL, uploaded_by = :uploaded_by WHERE project_id = :project_id AND attachment_id = :attachment_id")
				->parameters(array(
					':uploaded_by' => $user_id,
					':project_id' => $project_id,
					':attachment_id' => $attachment_id,
				))
				->execute();

			// This is to indicate that the attachment is deleted
			DB::query(NULL, "UPDATE project_attachments SET filepath = NULL, filename = NULL, date_uploaded = NULL, uploaded_by = NULL WHERE project_id = :project_id AND attachment_id = :attachment_id")
				->parameters(array(
					':project_id' => $project_id,
					':attachment_id' => $attachment_id,
				))
				->execute();
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, 'Database error, unable to delete attachment.');
		}

		Database::instance()->commit();

		return array(TRUE, NULL);
	}

	public function start($project_id, $completion_date, $user_id)
	{
		try
		{
			DB::query(NULL, "UPDATE projects SET start_date = NOW(), completion_date = :completion_date, status = 'Ongoing Construction', last_modified = NOW(), last_modified_by = :last_modified_by WHERE id = :id")
				->parameters(array(
					':id' => $project_id,
					':completion_date' => $completion_date,
					':last_modified_by' => $user_id,
				))
				->execute();

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, 'Database error, unable to start project.');
		}
	}

	public function extend($project_id, $completion_date, $user_id)
	{
		try
		{
			DB::query(NULL, "UPDATE projects SET start_date = NOW(), completion_date = :completion_date, status = 'Ongoing Construction', last_modified = NOW(), last_modified_by = :last_modified_by WHERE id = :id")
				->parameters(array(
					':id' => $project_id,
					':completion_date' => $completion_date,
					':last_modified_by' => $user_id,
				))
				->execute();

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, 'Database error, unable to extend project.');
		}
	}

	public function complete($project_id, $user_id)
	{
		try
		{
			DB::query(NULL, "UPDATE projects SET completion_date = NOW(), last_modified = NOW(), last_modified_by = :last_modified_by, status = 'Completed' WHERE id = :id")
				->parameters(array(
					':id' => $project_id,
					':last_modified_by' => $user_id,
				))
				->execute();

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, 'Database error, unable to complete project.');
		}
	}

	public function send($project_id, $sender_id, $recipient_id, $remarks)
	{
		try
		{
			DB::query(NULL, "INSERT INTO project_transition VALUES(NULL, :project_id, :sender_id, :recipient_id, :remarks, 'Sent', NOW())")
				->parameters(array(
					':project_id' => $project_id,
					':sender_id' => $sender_id,
					':recipient_id' => $recipient_id,
					':remarks' => $remarks,
				))
				->execute();

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, 'Database error, unable to send project.');
		}
	}

	public function receive($project_id)
	{
		try
		{
			DB::query(NULL, "UPDATE project_transition SET status = 'Received', date_recorded = NOW() WHERE project_id = :project_id AND status = 'Sent'")
				->param(':project_id', $project_id)
				->execute();

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, 'Database error, unable to receive project.');
		}
	}

	public function approve($project_id, $recipient_id, $recipient_position)
	{
		try
		{
			DB::query(NULL, "UPDATE project_transition SET status = 'Approved', date_recorded = NOW() WHERE project_id = :project_id AND status = 'Received' AND recipient_id = :recipient_id")
				->parameters(array(
					':project_id' => $project_id,
					':recipient_id' => $recipient_id,
				))
				->execute();

			DB::query(NULL, "UPDATE projects SET approvals = approvals + 1 WHERE id = :id")
				->param(':id', $project_id)
				->execute();

			if($recipient_position == 'Regional Irrigation Manager')
			{
				DB::query(NULL, "UPDATE projects SET status = 'Approved' WHERE id = :id")
					->param(':id', $project_id)
					->execute();
			}

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, 'Database error, unable to approve project.');
		}
	}

	public function decline($project_id, $recipient_id)
	{
		try
		{
			DB::query(NULL, "UPDATE project_transition SET status = 'Declined', date_recorded = NOW() WHERE project_id = :project_id AND status = 'Received' AND recipient_id = :recipient_id")
				->parameters(array(
					':project_id' => $project_id,
					':recipient_id' => $recipient_id,
				))
				->execute();

			DB::query(NULL, "UPDATE projects SET approvals = IF(approvals = 0, 0, approvals - 1) WHERE id = :id")
				->param(':id', $project_id)
				->execute();

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, 'Database error, unable to decline project.');
		}
	}

	public function history($project_id)
	{
		$query = "SELECT pt.*,
				  sender.given_name 'sender_given_name', sender.middle_name 'sender_middle_name', sender.last_name 'sender_last_name', sender.name_suffix 'sender_name_suffix',
				  ps.name 'sender_position',
				  recipient.given_name 'recipient_given_name', recipient.middle_name 'recipient_middle_name', recipient.last_name 'recipient_last_name', recipient.name_suffix 'recipient_name_suffix',
				  pr.name 'recipient_position'
				  FROM project_transition pt
				  LEFT JOIN employees sender ON pt.sender_id = sender.id
				  LEFT JOIN positions ps ON ps.id = sender.position_id
				  LEFT JOIN employees recipient ON pt.recipient_id = recipient.id
				  LEFT JOIN positions pr ON pr.id = recipient.position_id
				  WHERE pt.project_id = :project_id
				  ORDER BY pt.date_recorded DESC";

		return DB::query(Database::SELECT, $query)
			->param(':project_id', $project_id)
			->execute();
	}

	public function get_reports($project_id)
	{
		return DB::query(Database::SELECT, "SELECT pr.*, ctr.revisions FROM project_reports pr LEFT JOIN (SELECT count(id) 'revisions', project_id, report_id FROM project_report_revisions GROUP BY report_id, project_id) ctr ON ctr.project_id = pr.project_id AND ctr.report_id = pr.id WHERE pr.project_id = :project_id")
			->param(':project_id', $project_id)
			->execute()
			->as_array();
	}

	public function get_report_info($id)
	{
		return DB::query(Database::SELECT, "SELECT r.*, e.given_name, e.middle_name, e.last_name, e.name_suffix FROM project_reports r LEFT JOIN employees e ON r.uploaded_by = e.id WHERE r.id = :id")
			->param(':id', $id)
			->execute()
			->current();
	}

	public function get_report_revisions($id)
	{
		$query = "SELECT * FROM project_report_revisions WHERE report_id = :id ORDER BY date_uploaded DESC";

		return DB::query(Database::SELECT, $query)
			->param(':id', $id)
			->execute();
	}

	public function upload_report($project_id, $file, $post, $user_id, $replace = FALSE, $id = NULL)
	{
		if (empty(str_replace(' ', '', $post['title']))) return array(FALSE, array('title' => 'must not be empty'));
		if (empty(str_replace(' ', '', $post['pa_progress']))) return array(FALSE, array('pa_progress' => 'must not be empty'));
		if (empty(str_replace(' ', '', $post['fr_progress']))) return array(FALSE, array('fr_progress' => 'must not be empty'));
		if (empty(ctype_digit($post['pa_progress']))) return array(FALSE, array('pa_progress' => 'must be a valid number'));
		if (empty(ctype_digit($post['fr_progress']))) return array(FALSE, array('fr_progress' => 'must be a valid number'));

		$post['title'] = trim(preg_replace('/\s+/', ' ', $post['title']));

		if ( ! empty($file))
		{
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			if ($ext != 'pdf') return array(FALSE, array('file' => 'must be a pdf file'));

			$filepath = 'assets/projects/'.$project_id.'/Reports/';
			$filename = str_replace(array(' ', '/'), '', $post['title']).strtotime('now').'.'.$ext;;

			try
			{
				if ( ! is_dir($filepath)) mkdir($filepath, NULL, TRUE);
				move_uploaded_file($file['tmp_name'], $filepath.$filename);
			}
			catch (Exception $e)
			{
				return array(FALSE, 'Storage error, unable to upload report.');
			}
		}
		elseif ( ! $replace && empty($file))
			return array(FALSE, array('file', 'must not be empty'));

		Database::instance()->begin();

		try
		{
			if ($replace)
			{
				$old_info = $this->get_report_info($id);

				DB::query(NULL, "UPDATE projects SET pa_progress = pa_progress + (:new_pa_progress - :old_pa_progress), fr_progress = fr_progress + (:new_fr_progress - :old_fr_progress) WHERE id = :id")
					->parameters(array(
						':id' => $project_id,
						':new_pa_progress' => $post['pa_progress'],
						':new_fr_progress' => $post['fr_progress'],
						':old_pa_progress' => $old_info['pa_progress'],
						':old_fr_progress' => $old_info['fr_progress'],
					))
					->execute();

				DB::query(NULL, "UPDATE project_reports SET title = :title, pa_progress = :pa_progress, fr_progress = :fr_progress WHERE id = :id")
					->parameters(array(
						':id' => $id,
						':title' => $post['title'],
						':pa_progress' => $post['pa_progress'],
						':fr_progress' => $post['fr_progress'],
					))
					->execute();

				if ( ! empty($file))
				{
					DB::query(NULL, "INSERT INTO project_report_revisions (SELECT NULL, id, project_id, title, filepath, filename, date_uploaded, uploaded_by FROM project_reports WHERE id = :id)")
						->param(':id', $id)
						->execute();

					DB::query(NULL, "UPDATE project_reports SET filename = :filename, date_uploaded = NOW(), uploaded_by = :uploaded_by WHERE id = :id")
						->parameters(array(
							':id' => $id,
							':filename' => $filename,
							':uploaded_by' => $user_id,
						))
						->execute();
				}
			}
			else
			{
				DB::query(NULL, "UPDATE projects SET pa_progress = pa_progress + :pa_progress, fr_progress = fr_progress + :fr_progress WHERE id = :id")
					->parameters(array(
						':id' => $project_id,
						':pa_progress' => $post['pa_progress'],
						':fr_progress' => $post['fr_progress'],
					))
					->execute();

				DB::query(NULL, "INSERT INTO project_reports VALUES(NULL, :project_id, :title, :filepath, :filename, NOW(), :uploaded_by, :pa_progress, :fr_progress)")
					->parameters(array(
						':project_id' => $project_id,
						':title' => $post['title'],
						':filepath' => $filepath,
						':filename' => $filename,
						':uploaded_by' => $user_id,
						':pa_progress' => $post['pa_progress'],
						':fr_progress' => $post['fr_progress']
					))
					->execute();
			}
		}
		catch (Database_Exception $e)
		{
			Database::instance()->rollback();

			return array(FALSE, 'Database error, unable to upload report.');
		}

		Database::instance()->commit();

		return array(TRUE, NULL);
	}

	public function delete_report($id, $user_id)
	{
		$report_info = $this->get_report_info($id);

		Database::instance()->begin();

		try
		{
			unlink($report_info['filepath'].$report_info['filename']);
		}
		catch (Exception $e)
		{
			return array(FALSE, 'Storage error, unable to delete report.');
		}

		try
		{
			// This is to log the current user as the deleter of this report, see triggers
			DB::query(NULL, "UPDATE project_reports SET filepath = NULL, filename = NULL, date_uploaded = NULL, uploaded_by = :uploaded_by WHERE id = :id")
				->parameters(array(
					':uploaded_by' => $user_id,
					':id' => $id,
				))
				->execute();

			// Delete report
			DB::query(NULL, "DELETE FROM project_reports WHERE id = :id")
				->param(':id', $id)
				->execute();
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, 'Database error, unable to delete report.');
		}

		Database::instance()->commit();

		return array(TRUE, NULL);
	}

	private function clean($project)
	{
		foreach ($project AS $key => $value)
		{
			$value = preg_match('/cost|area/', $key) ? trim(str_replace(array(' ', ','), '', $value)) : trim(preg_replace('/\s+/', ' ', $value));
			$project[$key] = empty($value) ? NULL : $value;
		}

		return $project;
	}

	private function validate($project)
	{
		if (preg_match('/([0-9]{4})-(0[1-9]{1}|1[0-2]{1})-(0[1-9]{1}|[1-2][0-9]|3[0-1])/', $project['date_proposed']))
		{
			$date = explode('-', $project['date_proposed']);
		}

		$validation = Validation::factory($project)
			->rule('date_proposed', 'not_empty')
			->rule('date_proposed', 'range', array(strtotime($project['date_proposed']), strtotime('1970-01-01'), strtotime(date('Y-m-d'))))
			->rule('date_proposed', 'regex', array(':value', '/([0-9]{4})-(0[1-9]{1}|1[0-2]{1})-(0[1-9]{1}|[1-2][0-9]|3[0-1])/'))
			->rule('date_proposed', 'date', array(empty($date) ? FALSE : (checkdate($date[1], $date[2], $date[0]) ? $project['date_proposed'] : FALSE)))
			->rule('title', 'not_empty')
			->rule('title', 'alpha_numeric', array(str_replace(array(' ', '#', '%', '&', '(', ')', '-', '+', ',', '.', '/'), '', $project['title'])))
			->rule('name', 'not_empty')
			->rule('name', 'alpha_numeric', array(str_replace(array(' ', '#', '%', '&', '(', ')', '-', '+', ',', '.', '/'), '', $project['name'])))
			->rule('category', 'in_array', array(':value', array('Communal Irrigation System', 'Communal Irrigation Project', 'National Irrigation System', 'Small Irrigation System', 'Small Irrigation Project', 'Pump Irrigation System', 'Pump Irrigation Project')))
			->rule('description', 'not_empty')
			->rule('description', 'alpha_numeric', array(str_replace(array(' ', '#', '%', '&', '(', ')', '-', '+', ',', '.', '/'), '', $project['description'])))
			->rule('cost', 'not_empty')
			->rule('cost', 'numeric')
			->rule('cost', 'range', array(':value', 1, abs($project['cost'])))
			->rule('area', 'not_empty')
			->rule('area', 'numeric')
			->rule('area', 'range', array(':value', 1, abs($project['area'])));

		return $validation->check() ? [] : $validation->errors('project');
	}

	public function get_status_report($from, $to, $filter, $location)
	{
		$query = "SELECT p.*, pap.file_count, pa.total_file_count, m.name 'municipality_name'
 				  FROM projects p
 				  LEFT JOIN municipalities m ON p.municipality_id = m.id
 				  LEFT JOIN (SELECT project_id, count(project_id) AS 'total_file_count' FROM project_attachments GROUP BY project_id) pa ON pa.project_id = p.id
 				  LEFT JOIN (SELECT project_id, count(filename) AS 'file_count' FROM project_attachments GROUP BY project_id) pap ON pap.project_id = p.id
 				  WHERE ((p.start_date BETWEEN :from AND :to) OR (p.completion_date BETWEEN :from AND :to) OR (:from BETWEEN p.start_date AND p.completion_date) OR (:to BETWEEN p.start_date AND p.completion_date))";

		switch ($filter)
		{
			case 'ongoing':
				$query .= " AND status = 'Ongoing Construction'";
				break;

			case 'completed':
				$query .= " AND status = 'Completed'";
				break;
		}

		$location = strpos($location, 'Whole') === 0 ? ($location == 'Whole CAR' ? '' : '%'.trim(str_replace('Whole ', '', $location))) : '%'.$location.'%';
		$query .= empty($location) ? '' : ' AND m.name LIKE :location';

		$query .= " ORDER BY p.id ASC, p.name ASC";

		return DB::query(Database::SELECT, $query)
			->parameters(array(
				':from' => $from,
				':to' => $to,
				':location' => $location,
			))
			->execute()
			->as_array();
	}

	public function get_statistics_report($from, $to)
	{
		$query = "SELECT a.date, a.count 'cis_start', c.count 'nis_start', b.count 'cis_completed', d.count 'nis_completed'
				  FROM (SELECT DATE_FORMAT(start_date, '%Y-%m') 'date', count(start_date) 'count' FROM projects WHERE start_date IS NOT NULL AND category = 'Communal Irrigation System' GROUP BY DATE_FORMAT(start_date, '%Y-%m')) a
				  LEFT JOIN (SELECT DATE_FORMAT(completion_date, '%Y-%m') 'date', count(completion_date) 'count' FROM projects WHERE completion_date IS NOT NULL AND category = 'Communal Irrigation System' AND status = 'Completed' GROUP BY DATE_FORMAT(completion_date, '%Y-%m')) b ON a.date = b.date
				  LEFT JOIN (SELECT DATE_FORMAT(start_date, '%Y-%m') 'date', count(start_date) 'count' FROM projects WHERE start_date IS NOT NULL AND category = 'National Irrigation System' GROUP BY DATE_FORMAT(start_date, '%Y-%m')) c ON b.date = c.date
				  LEFT JOIN (SELECT DATE_FORMAT(completion_date, '%Y-%m') 'date', count(completion_date) 'count' FROM projects WHERE completion_date IS NOT NULL AND category = 'National Irrigation System' AND status = 'Completed' GROUP BY DATE_FORMAT(completion_date, '%Y-%m')) d ON c.date = d.date
				  WHERE a.date BETWEEN :from AND :to
				  ORDER BY a.date ASC";

		return DB::query(Database::SELECT, $query)
			->parameters(array(
				':from' => $from,
				':to' => $to,
			))
			->execute();
	}
}