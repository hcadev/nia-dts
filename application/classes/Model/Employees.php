<?php defined("SYSPATH") or die("No direct script access.");

class Model_Employees extends Model_Database {
	public function create(&$employee)
	{
		$employee = $this->clean($employee);

		if (empty($errors = $this->validate($employee)))
		{
			try
			{
				Database::instance()->begin();

				if ( ! empty($employee['replace']))
				{
					$positions = $this->get_positions(array('System Administrator', 'Field Agent'));
					foreach ($positions AS $position) { $position_ids[] = $position['id']; }

					if (in_array($employee['position_id'], $position_ids))
					{
						DB::query(NULL, "UPDATE employees SET status = 'Inactive' WHERE status = 'Active' AND position_id = :position_id")
							->param(':position_id', $employee['position_id'])
							->execute();
					}
				}

				list($id, $rows) = DB::query(Database::INSERT, "INSERT INTO employees VALUES(NULL, :given_name, :middle_name, :last_name, :name_suffix, :username, :password, :email, :position_id, :status, NULL, NULL, NOW(), :user_id, NULL, NULL)")
					->parameters(array(
						':given_name' => $employee['given_name'],
						':middle_name' => $employee['middle_name'],
						':last_name' => $employee['last_name'],
						':name_suffix' => $employee['name_suffix'],
						':username' => $employee['username'],
						':password' => $employee['password'],
						':email' => $employee['email'],
						':position_id' => $employee['position_id'],
						':status' => empty($employee['replace']) ? 'Inactive' : 'Active',
						':user_id' => $employee['user_id'],
					))
					->execute();

				Database::instance()->commit();

				return array(TRUE, $id);
			}
			catch (Database_Exception $e)
			{
				Database::instance()->rollback();

				return array(FALSE, "Database error, unable to add employee.");
			}
		}
		else return array(FALSE, $errors);
	}

	public function get_info($id)
	{
		return DB::query(Database::SELECT, "SELECT e.*, p.name AS 'position' FROM employees e JOIN positions p ON e.position_id = p.id WHERE e.id = :id")
			->param(':id', $id)
			->execute()
			->current();
	}

	public function get_list($keyword)
	{
		$query = "SELECT e.*, p.name AS 'position'
				  FROM employees e
				  LEFT JOIN positions p ON e.position_id = p.id
				  WHERE (:keyword IS NULL OR DATE_FORMAT(date_created, '%M %d, %Y %h:%i:%s %p') LIKE :keyword OR given_name LIKE :keyword OR middle_name LIKE :keyword OR last_name LIKE :keyword OR name_suffix LIKE :keyword OR p.name LIKE :keyword)
				  ORDER BY last_name ASC, given_name ASC, middle_name ASC";

		return DB::query(Database::SELECT, $query)
			->param(':keyword', empty($keyword) ? NULL : '%'.$keyword.'%')
			->execute()
			->as_array();
	}

	public function get_positions(array $except = NULL)
	{
		$query = "SELECT * FROM positions";
		$query .= empty($except) ? '' : ' WHERE name NOT IN :except';
		$query .= ' ORDER BY name ASC';

		return DB::query(Database::SELECT, $query)
			->param(':except', $except != NULL ? $except : array(0))
			->execute()
			->as_array();
	}

	public function get_recipient_info($position)
	{
		return DB::query(Database::SELECT, "SELECT e.*, p.name 'position' FROM employees e JOIN positions p ON e.position_id = p.id WHERE p.name = :position AND e.status = 'Active'")
			->param(':position', $position)
			->execute()
			->current();
	}

	public function update($employee, $user_id)
	{
		$employee = $this->clean($employee);

		if (empty($errors = $this->validate($employee)))
		{
			try
			{
				Database::instance()->begin();

				DB::query(NULL, "UPDATE employees SET given_name = :given_name, middle_name = :middle_name, last_name = :last_name, name_suffix = :name_suffix, username = :username, password = :password, email = :email, position_id = :position_id, last_modified = NOW(), last_modified_by = :last_modified_by WHERE id = :id")
					->parameters(array(
						':given_name' => $employee['given_name'],
						':middle_name' => $employee['middle_name'],
						':last_name' => $employee['last_name'],
						':name_suffix' => $employee['name_suffix'],
						':username' => $employee['username'],
						':password' => $employee['password'],
						':email' => $employee['email'],
						':position_id' => $employee['position_id'],
						':position_id' => $employee['position_id'],
						':last_modified_by' => $user_id,
						':id' => $employee['id']
					))
					->execute();

				Database::instance()->commit();

				return array(TRUE, NULL);
			}
			catch (Database_Exception $e)
			{
				Database::instance()->rollback();

				return array(FALSE, 'Database error, unable to update employee.');
			}
		}
		else return array(FALSE, $errors);
	}

	public function block($id, $user_id)
	{
		try
		{
			DB::query(NULL, "UPDATE employees SET status = 'Inactive', last_modified = NOW(), last_modified_by = :last_modified_by WHERE id = :id")
				->parameters(array(
					':id' => $id,
					':last_modified_by' => $user_id
				))
				->execute();

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, 'Database error, unable to deactivate employee.');
		}
	}

	public function allow($id, $user_id)
	{
		try
		{
			Database::instance()->begin();

			$employee = $this->get_info($id);
			$positions = $this->get_positions(array('System Administrator', 'Field Agent'));
			$position_ids = [];
			foreach ($positions AS $position)
			{
				$position_ids[] = $position['id'];
			}

			DB::query(NULL, "UPDATE employees SET status = 'Active', last_modified = NOW(), last_modified_by = :last_modified_by WHERE id = :id")
				->parameters(array(
					':id' => $id,
					':last_modified_by' => $user_id
				))
				->execute();

			if (in_array($employee['position_id'], $position_ids))
			{
				DB::query(NULL, "UPDATE employees SET status = 'Inactive' WHERE position_id = :position_id AND id != :id")
					->parameters(array(
						':id' => $employee['id'],
						':position_id' => $employee['position_id'],
					))
					->execute();
			}

			Database::instance()->commit();

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			Database::instance()->rollback();
			return array(FALSE, 'Database error, unable to activate employee.');
		}
	}

	public function delete($id)
	{
		try
		{
			DB::query(NULL, "DELETE FROM employees WHERE id = :id")
				->param(':id', $id)
				->execute();

			return array(TRUE, NULL);
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, 'Database error, unable to delete employee.');
		}
	}

	private function clean($employee)
	{
		foreach ($employee AS $key => $value)
		{
			$value = trim(preg_replace('/\s+/', ' ', $value));
			$employee[$key] = empty($value) ? NULL : $value;
		}

		return $employee;
	}

	private function validate($employee)
	{
		// Additional validations
		$positions = $this->get_positions();
		// Extract ids from positions
		$position_ids = [];
		foreach ($positions AS $position)
		{
			$position_ids[] = $position['id'];
		}

		// Get used usernames and emails
		$usernames = DB::query(Database::SELECT, "SELECT GROUP_CONCAT(username SEPARATOR ',') FROM employees  WHERE id != :id")->param(':id', empty($employee['id']) ? 0 : $employee['id'])->execute()->current();
		$emails = DB::query(Database::SELECT, "SELECT GROUP_CONCAT(email SEPARATOR ',') FROM employees WHERE id != :id")->param(':id', empty($employee['id']) ? 0 : $employee['id'])->execute()->current();

		$validation = Validation::factory($employee)
			->rule('given_name', 'not_empty')
			->rule('middle_name', 'not_empty')
			->rule('last_name', 'not_empty')
			->rule('username', 'not_empty')
			->rule('password', 'not_empty')
			->rule('email', 'not_empty')
			->rule('position_id', 'not_empty')
			->rule('given_name', 'alpha', array(str_replace(array('-', ' '), '', $employee['given_name'])))
			->rule('middle_name', 'alpha', array(str_replace(array('-', ' '), '', $employee['middle_name'])))
			->rule('last_name', 'alpha', array(str_replace(array('-', ' '), '', $employee['last_name'])))
			->rule('name_suffix', 'alpha', array(str_replace(array('-', ' '), '', $employee['name_suffix'])))
			->rule('username', 'alpha_numeric')
			->rule('username', 'in_array', array(':value', in_array($employee['username'], $usernames) ? array('#') : array($employee['username'])))
			->rule('password', 'alpha_numeric')
			->rule('password', 'min_length', array(':value', 8))
			->rule('confirm_password', 'matches', array(':validation', 'confirm_password', 'password'))
			->rule('email', 'email')
			->rule('email', 'in_array', array(':value', in_array($employee['email'], $emails) ? array('#') : array($employee['email'])))
			->rule('position_id', 'in_array', array(':value', $position_ids));

		return $validation->check() ? [] : $validation->errors('employee');
	}
}