<?php defined("SYSPATH") or die("No direct script access.");

class Model_Audit extends Model_Database {
	public function get_list($keyword, $employee_id = NULL)
	{
		return DB::query(Database::SELECT, "SELECT a.*, e.given_name, e.middle_name, e.last_name, e.name_suffix FROM audit a JOIN employees e ON a.employee_id = e.id WHERE (:keyword IS NULL OR (e.last_name LIKE :keyword OR e.given_name LIKE :keyword OR e.middle_name LIKE :keyword OR e.name_suffix LIKE :keyword	OR CONCAT_WS('', e.last_name, ', ', e.given_name, ' ', e.middle_name, ' ', e.name_suffix) LIKE :keyword OR CONCAT_WS('', e.given_name, ' ', e.middle_name, ' ', e.last_name, ' ', e.name_suffix) LIKE :keyword OR DATE_FORMAT(a.date_recorded, '%M %d, %Y %h:%i:%s %r') LIKE :keyword OR a.action LIKE :keyword)) AND (:employee_id IS NULL OR e.id = :employee_id) ORDER BY a.date_recorded ASC")
			->parameters(array(
				':keyword' => empty($keyword) ? NULL : '%'.$keyword.'%',
				':employee_id' => $employee_id,
			))
			->execute()
			->as_array();
	}
}