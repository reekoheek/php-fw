<?php
Apu::import("/action/BaseUserAction.php");
Apu::import("/todo/action/menu.php");

class MenuAction extends BaseUserAction {
	function doIndex() {
		reset($GLOBALS["MENU"]);
		$menus = array();
		while (list($id, $menu) = each($GLOBALS["MENU"])) {
			$menu["name"] = $id;
			MenuAction::insertMenu($menus, ltrim($id, 'menu.'), $menu);
			
		}
		$_REQUEST["menu"] = $menus;
		$date = new Date();
		$_REQUEST["date"] = $date->__toString();
		Apu::dispatch("/todo/faces/menu/menu.php");
	}
	
	function insertMenu(&$menus, $id, $menu) {
		$pos = strpos($id, '.');
		if ($pos != false) {
			MenuAction::insertMenu($menus[substr($id, 0, $pos)]["children"], substr($id, $pos + 1), $menu);  
		} else {
			$menus[$id] = $menu;
		}
	}
}
?>