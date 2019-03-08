<?php defined("SYSPATH") or die("No direct script access.");

class Model_Users extends Model_Database {
	public function authenticate($data)
	{
		$query = "SELECT e.*, p.name AS 'position', pr.privileges
				  FROM employees e
				  LEFT JOIN positions p ON e.position_id = p.id
				  LEFT JOIN (SELECT position_id, GROUP_CONCAT(name SEPARATOR '|') AS 'privileges' FROM privileges JOIN actions ON action_id = actions.id GROUP BY position_id) pr ON p.id = pr.position_id
				  WHERE username = :username AND password = :password AND status = 'Active'";

		$account =  DB::query(Database::SELECT, $query)
			->parameters(array(
				':username' => $data['username'],
				':password' => $data['password'],
			))
			->execute()
			->current();

		if (empty($account)) return array(FALSE, NULL);

		try
		{
			DB::query(NULL, "UPDATE employees SET last_login = NOW() WHERE id = :id")
				->param(':id', $account['id'])
				->execute();

			return array(TRUE, $account);
		}
		catch (Database_Exception $e)
		{
			return array(FALSE, NULL);
		}
	}

	public function get_updated_details($account)
	{
		$query = "SELECT e.*, p.name AS 'position', pr.privileges
				  FROM employees e
				  LEFT JOIN positions p ON e.position_id = p.id
				  LEFT JOIN (SELECT position_id, GROUP_CONCAT(name SEPARATOR '|') AS 'privileges' FROM privileges JOIN actions ON action_id = actions.id GROUP BY position_id) pr ON p.id = pr.position_id
				  WHERE username = :username AND password = :password AND status = 'Active'";

		return DB::query(Database::SELECT, $query)
			->parameters(array(
				':username' => $account['username'],
				':password' => $account['password'],
			))
			->execute()
			->current();
	}

	public function logout($id)
	{
		DB::query(NULL, "UPDATE employees SET last_logout = NOW() WHERE id = :id")
			->param(':id', $id)
			->execute();
	}
}