<?php
class MysqlDriver extends BaseClass {
	function meta($table, $schema = "DEFAULT") {
		$db = $GLOBALS["CFG_DB"]->CON[$schema]->DB;
		$link = MysqlDriver::connect($schema);
		$result = mysql_list_fields($db, $table, $link);
		$count = mysql_num_fields($result);
		$fields = array();
		for($i = 0; $i < $count; $i++) {
			$field["name"] = mysql_field_name($result, $i);
			$field["length"] = mysql_field_len($result, $i);
			$field["type"] = mysql_field_type($result, $i);
			$field["flags"] = mysql_field_flags($result, $i);
			$fields[] = $field;
		}
		mysql_free_result($result);
		return $fields;
	}

	function object($object) {
		if ($object instanceof Raw) {
			return $object->value();
		} else if ($object instanceof Exp) {
			return "(".$object->expressionString().")";
		} else {
			return "`".String::dasherize($object)."`";
		}
	}

	function escape($value, $name, $meta) {
		if ($value instanceof Raw) {
			return $value->value();
		} else if ($value instanceof Exp) {
			return "(".$value->expressionString().")";
		} else if (is_null($value)) {
			return "NULL";
		} else {
			reset($meta);
			$fieldMeta = "";
			while (list($key, $fmeta) = each($meta)) {
				if ($fmeta["name"] == $name) {
					$fieldMeta = $fmeta;
					break;
				}
			}
			// TODO baru bisa int sama default disamakan dengan string
			if ($fieldMeta["type"] == "int") {
				$value = intval($value);
				if (!is_int($value)) {
					throw new Exception("Field $name must be numeric: $value");
				}
				return $value;
			} else if ($fieldMeta["type"] == "datetime") {
				if ($value instanceof Date) {
					return "'".mysql_escape_string($value->__toString())."'";
				} else {
					return "'".mysql_escape_string($value)."'";
				}
			} else {
				return "'".mysql_escape_string($value)."'";
			}
		}
	}

	function connect($schema = "DEFAULT") {
		$link = $GLOBALS[DB_SCOPE][$schema]["LINK"];
		if (!isset($link)) {
			$con = $GLOBALS["CFG_DB"]->CON[$schema];
			$host = $con->HOST;
			$user = $con->USER;
			$pwd = $con->PWD;
			$db = $con->DB;
			$driver = $con->DRIVER;
			$link = mysql_pconnect($host, $user, $pwd);
			if ($link == false) {
				throw new Exception("Cannot create connection to $host with user $user driver $driver");
			}
			$status = mysql_select_db($db, $link);
			if ($status == false) {
				throw new Exception("Cannot select db $db driver $driver");
			}
			$GLOBALS[DB_SCOPE][$schema]["LINK"] = $link;
		}
		return $link;
	}

	function query($query, $schema = "DEFAULT") {
		$q = "";
		if ($query instanceof Query) {
			$q = $query->sql();
		} else {
			$q = $query;
		}
		$link = MysqlDriver::connect($schema);
		$result = mysql_query($q, $link);
		$rows = array();
		if ($result) {
			if (is_bool($result)) {
				return $result;
			}
			
			$fieldNames = array();
			$camelizeNames = array();
			$fieldTypes = array();
			$fieldCount = mysql_num_fields($result);
			for ($i = 0; $i < $fieldCount; $i++) {
				$fieldNames[$i] = mysql_field_name($result, $i);
				$camelizeNames[$i] = String::camelize($fieldNames[$i]);
				$fieldTypes[$i] = mysql_field_type($result, $i);  
			}
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$r = array();
				for ($i = 0; $i < $fieldCount; $i++) {
					if ($fieldTypes[$i] == "datetime") {
						$r[$camelizeNames[$i]] = &new Date($row[$fieldNames[$i]]);
					} else {
						$r[$camelizeNames[$i]] = &$row[$fieldNames[$i]];
					}
				}
				$r["__ID__"] = $row["id"];
				$rows[] = &$r;
			}
			mysql_free_result($result);
			return $rows;
		} else {
			return false;
		}

	}

	function unique($query, $schema = "DEFAULT") {
		$rows = MysqlDriver::query($query, $schema);
		if (empty($rows)) {
			return false;
		} else {
			return $rows[0];
		}
	}

	function error($schema = "DEFAULT") {
		$link = MysqlDriver::connect($schema);
		return mysql_error($link);
	}
}
?>