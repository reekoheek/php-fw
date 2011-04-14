<?php
global $MENU;
$MENU["menu.task"]["action"] = "";
$MENU["menu.task.newTask"]["action"] = "task/add";

$MENU["menu.view"]["action"] = "";
$MENU["menu.view.all"]["action"] = "";

$MENU["menu.manage"]["action"] = "";
$MENU["menu.manage.project"]["action"] = "project";
$MENU["menu.manage.user"]["action"] = "user";
$MENU["menu.manage.myProfile"]["action"] = "profile";

$MENU["menu.admin"]["action"] = "";
$MENU["menu.admin.lookup"]["action"] = "lookup";

$MENU["menu.system"]["action"] = "";
$MENU["menu.system.refresh"]["action"] = "task.php/refresh";
$MENU["menu.system.logout"]["action"] = "login/logout";
$MENU["menu.system.logout"]["target"] = "_top";
?>