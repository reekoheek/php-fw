<?php
Apu::import("/dao/BaseDao.php");

class LookupDao extends BaseDao {
	const TABLE = "lookups";
	
	function byId($id) {
		return parent::byId($id, LookupDao::TABLE);
	}
	
	function findAllType() {
		$select = new Select("lookups");
		$select->addField(Exp::raw("distinct `type`"));
		$result = DB::query($select);
		return $result;
	}
}
?>