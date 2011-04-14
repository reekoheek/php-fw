<? Apu::import("/todo/dao/UserDao.php"); ?>
<style>
@IMPORT url("<?=Apu::theme()?>/main.css");
@IMPORT url("<?=Apu::theme()?>/application.css");

body {
	background-image: none;
}

h2 {
	font-family: Arial;
	margin: 5px 5px 5px 5px;
	color: #3333AA;
	border-bottom: 1px solid #3333AA;
}

#welcomeNote {
	font-family: Arial;
	margin: 5px 5px 5px 5px;
	color: #3333AA;
}

div.Frame {
	margin-top: 7px;
	margin-bottom: 3px;
}

</style>

<script type="text/javascript" src="themes/prototype.js"></script>

<h2>Todo App</h2>
<div id="welcomeNote">
	<?=Msg::get("welcome.note", array( UserDao::loginFullName() ))?><br/>
	<?=$_REQUEST["date"] ?>
</div>

<? reset($_REQUEST["menu"]); ?>
<? while (list($key, $menu) = each($_REQUEST["menu"])) { ?>
<div class="Frame">
	<div class="Title"><?=Msg::get($menu["name"])?></div>
	<? if (!empty($menu["children"])) { ?>
	<div>
		<? while (list($subKey, $subMenu) = each($menu["children"])) { ?>
			<a class="Menu" href="<?=$subMenu["action"]?>" style="display: block;padding:2px 2px 2px 2px" target="<?=(empty($subMenu["target"]))?"main":$subMenu["target"]?>"><?=Msg::get($subMenu["name"])?></a>
		<? } ?>
	</div>
	<? } ?>
</div>
<? } ?>