<?php
Apu::import("/action/BaseUserAction.php");
Apu::import("/todo/dao/LookupDao.php");

class LookupAction extends BaseUserAction {
	var $validation = "/todo/action/LookupAction_validation.php";

	var $lookup;
	var $id;
	var $list;

	function doSort() {
		$sort = $this->sort;
		$this->fetch("list");
		if ($this->list["sort"]["key"] == $this->sort) {
			if ($this->list["sort"]["order"] == "ASC") {
				$this->list["sort"]["order"] = "DESC";
			} else {
				$this->list["sort"]["order"] = "ASC";
			}
			$this->list["sort"]["key"] = $this->sort;
		} else {
			$this->list["sort"]["order"] = "ASC";
			$this->list["sort"]["key"] = $this->sort;
		}
		$this->save("list");
		Apu::redirect("lookup");
	}

	function doSearch() {
		$this->lookup = $this->list["filter"];
		$this->fetch("list");
		$this->list["filter"] = $this->lookup;
		$this->save("list");
		Apu::redirect("lookup");
	}

	function doIndex() {
		$this->fetch("list");
		$select = new Select("lookups");
		if (!empty($this->list["sort"]["key"])) {
			$select->addOrder($this->list["sort"]["key"], $this->list["sort"]["order"]);
			$this->serverDatas["sort"] = $this->list["sort"];
		}
		if (!empty($this->list["filter"])) {
			$filter = $this->list["filter"];
			$select->expressions = array();
			$select->add(Exp::like("type", $filter["type"], Exp::MATCH_BOTH));
			$select->add(Exp::like("code", $filter["code"], Exp::MATCH_BOTH));
		}
		$this->list["list"] = DB::query($select);
		Apu::dispatch("/todo/faces/lookup/lookup_list.php");
	}

	function doView() {
		$this->lookup = LookupDao::byId($this->id, "lookups");
		Apu::dispatch("/todo/faces/lookup/lookup_view.php");
	}

	function doAdd() {
		$this->fetch("lookup");
		$this->messages = Msg::fetch();
		$allType = LookupDao::findAllType();
		$_REQUEST["lookup.type"] = array();
		if (!empty($allType)) {
			reset($allType);
			while(list(,$type) = each($allType)) {
				$_REQUEST["lookup.type"][] = $type["type"];
			}
		}
		Apu::dispatch("/todo/faces/lookup/lookup_add.php");
		$this->remove("lookup");
		
	}

	function doAddOk() {
		$this->save("lookup");
		if (!empty($this->messages)) {
			Msg::save($this->messages);
			Apu::redirect("lookup/add");
		}
		if (empty($this->lookup["priority"])) {
			$this->lookup["priority"] = 0;
		}
		$this->lookup["createdBy"] = UserDao::loginUserName();
		$this->lookup["createdTime"] = new Raw("now()");
		$this->lookup["updatedBy"] = UserDao::loginUserName();
		$this->lookup["updatedTime"] = new Raw("now()");
		try {
			DB::persist("lookups", $this->lookup);
			$this->remove("lookup");
			Apu::redirect("lookup");
		} catch (Exception $e) {
			$this->addMsgString($e->getMessage());
			Msg::save($this->messages);
			Apu::redirect("lookup/add");
		}
	}

	function doEdit() {
		$this->fetch("lookup");
		if (empty($this->lookup)) {
			$this->lookup = LookupDao::byId($this->id);
		}

		$allType = LookupDao::findAllType();
		$_REQUEST["lookup.type"] = array();
		if (!empty($allType)) {
			reset($allType);
			while(list(,$type) = each($allType)) {
				$_REQUEST["lookup.type"][] = $type["type"];
			}
		}
		$this->messages = Msg::fetch();
		Apu::dispatch("/todo/faces/lookup/lookup_edit.php");
		$this->remove("lookup");
	}

	function doEditOk() {
		$lookup = LookupDao::byId($this->id);
		Bean::copy($this->lookup, $lookup, array("type", "code", "name", "description", "priority"));
		$this->lookup = $lookup;
		$this->save("lookup");

		if (!empty($this->messages)) {
			Msg::save($this->messages);
			Apu::redirect("lookup/edit");
		}
		if (empty($this->lookup["priority"])) {
			$this->lookup["priority"] = 0;
		}
		$this->lookup["updatedBy"] = LookupDao::loginUserName();
		$this->lookup["updatedTime"] = new Raw("now()");
		try {
			DB::persist("lookups", $this->lookup);
			$this->remove("lookup");
			Apu::redirect("lookup");
		} catch (Exception $e) {
			$this->addMsgString($e->getMessage());
			Msg::save($this->messages);
			Apu::redirect("lookup/edit");
		}
	}

	function doDel() {
		try {
			$this->lookup = LookupDao::byId($this->id);
			DB::delete("lookups", $this->lookup);
			Apu::redirect("lookup");
		} catch (Exception $e) {
			$this->addMsgString($e->getMessage());
			Msg::save($this->messages);
			Apu::redirect("lookup");
		}
	}
}
?>