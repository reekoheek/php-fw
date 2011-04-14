<? Apu::import("/tag/FormTag.php"); ?>
<style>
@IMPORT url("<?=Apu::theme()?>/main.css");
@IMPORT url("<?=Apu::theme()?>/application.css");
</style>

<script type="text/javascript" src="<?=Apu::base()?>/themes/prototype.js"></script>
<script type="text/javascript" src="<?=Apu::base()?>/themes/apu.js"></script>
<script type="text/javascript" src="<?=Apu::theme()?>/init.js"></script>
<script type="text/javascript">
if (window.top.location.href != window.location.href) {
	window.top.location.href = window.location.href;
}

var windowOnLoad = function(evt) {
	Position.absolutize($('login'));
	Position.centerize($('login'));
	$('centerized').style.position = "relative";
	Position.centerize($('centerized'));
}
Event.observe(window, "load", windowOnLoad);
Event.observe(window, "resize", windowOnLoad);
</script>

<form method="post" action="login/login">
<div class="Frame" style="width: 400px" id="login">
	<div class="Title"><?=Msg::get("LoginAction.title")?></div>
	<div class="Message"><?=Msg::message("LoginAction.description")?></div>
	<div style="height: 130px">
		<table id="centerized"><tr><td>
		<img src="themes/apu/img/security.gif"/>
		</td><td>
		<table class="Form">
			<tr>
				<td class="Label"><?=Msg::get("login.username")?></td>
				<td>:</td>
				<td><?=FormTag::text("login.username", $this->login["username"])?></td>
			</tr>
			<tr>
				<td class="Label"><?=Msg::get("login.password")?></td>
				<td>:</td>
				<td><?=FormTag::password("login.password", $this->login["password"])?></td>
			</tr>
			<tr>
				<td colspan="3" class="Command">
					<?=FormTag::submit("command.login")?>
				</td>
			</tr>
		</table>
		</td></tr></table>
	</div>
</div>
</form>