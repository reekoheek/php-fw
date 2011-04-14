<? Apu::import("/tag/FormTag.php") ?>
<script type="text/javascript" src="<?=Apu::base()?>/themes/prototype.js"></script>
<script type="text/javascript" src="<?=Apu::base()?>/themes/scriptaculous.js"></script>
<script type="text/javascript" src="<?=Apu::base()?>/themes/apu.js"></script>
<script type="text/javascript" src="<?=Apu::theme()?>/init.js"></script>

<style>
@IMPORT url("<?=Apu::theme()?>/main.css");
@IMPORT url("<?=Apu::theme()?>/application.css");
</style>

<form method="post" action="/lookup/editOk">
<input type="hidden" name="id" value="<?=$this->lookup["id"]?>">
<div class="Frame">
	<div class="Title"><?=Msg::get("LookupAction.edit.title")?></div>
	<div class="Message"><?=Msg::message("LookupAction.edit.description")?></div>
	<div>
		<table class="Form">
			<tr>
				<td><?=Msg::get("lookup.type")?></td>
				<td>:</td>
				<td><?=FormTag::text("lookup.type", $this->lookup["type"])?></td>
			</tr>
			<tr>
				<td><?=Msg::get("lookup.code")?></td>
				<td>:</td>
				<td><?=FormTag::text("lookup.code", $this->lookup["code"])?></td>
			</tr>
			<tr>
				<td><?=Msg::get("lookup.name")?></td>
				<td>:</td>
				<td><?=FormTag::text("lookup.name", $this->lookup["name"])?></td>
			</tr>
			<tr>
				<td><?=Msg::get("lookup.description")?></td>
				<td>:</td>
				<td><?=FormTag::textArea("lookup.description", $this->lookup["description"])?></td>
			</tr>
			<tr>
				<td><?=Msg::get("lookup.priority")?></td>
				<td>:</td>
				<td><?=FormTag::text("lookup.priority", $this->lookup["priority"])?></td>
			</tr>
			<tr>
				<td colspan="3" class="Command">
					<?=FormTag::submit("command.edit")?>
					<?=FormTag::reset("command.reset")?>
					<?=FormTag::back("command.back", "lookup.php")?>
				</td>
			</tr>
		</table>
	</div>
</div>
</form>
<div id="ac" class="AutocompleterPopup" style="display: none;"></div>
<script type="text/javascript">
new Autocompleter.Local('lookup.type','ac',
	<?=JSON::encode($_REQUEST["lookup.type"])?>, 
	{ tokens: [], fullSearch: true, partialSearch: true }
);
</script>