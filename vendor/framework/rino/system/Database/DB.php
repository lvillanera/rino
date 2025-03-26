<?php 

namespace Rino\Database;
use Rino\Database\ClassPdo as CL_PDO;

class DB
{

	protected static $insertId;

	public static function insert($table,$data = array())
	{
		$db = new CL_PDO;

		$_sql = "INSERT INTO " . $table . " SET ";

		$comp = '';
		foreach ($data as $c => $v) {
			$comp .= $c . " =:" . $c . ",";
		}
		
		$_sql.= trim($comp,",");

		$db->pdo->prepare($_sql)->execute($data);

		self::$insertId = $db->pdo->lastInsertId();

	}

	public static function update($table, $data, $expr,$operator='=', $value) {

		$db = new CL_PDO;

		$_sql = "UPDATE " . $table . " SET ";
		$comp = '';
		foreach ($data as $c => $v) {
			$comp .= $c . " =:" . $c . ",";
		}
		$_sql.= trim($comp,",");

		$_sql .= " WHERE " . $expr . " =:" . $expr;

		$data[$expr] = $value;

		$status = $db->pdo->prepare($_sql)->execute($data);

		return $status;
	}

	public static function last_id()
	{
		return self::$insertId;
	}

}


 ?>