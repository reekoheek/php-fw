<? Apu::import("/tag/FormTag.php") ?>
<script type="text/javascript" src="themes/prototype.js"></script>
<script type="text/javascript" src="themes/apu.js"></script>
<script type="text/javascript" src="<?=Apu::theme()?>/init.js"></script>

<style>
@IMPORT url("<?=Apu::theme()?>/main.css");
@IMPORT url("<?=Apu::theme()?>/application.css");
</style>

<div class="Frame">
	<div class="Title"><?=Msg::get("LookupAction.view.title")?></div>
	<div class="Message"><?=Msg::message("LookupAction.view.description")?></div>
	<div>
		<table class="Form">
			<tr>
				<td><?=Msg::get("lookup.type")?></td>
				<td>:</td>
				<td><?=nl2br($this->lookup["type"])?></td>
			</tr>
			<tr>
				<td><?=Msg::get("lookup.code")?></td>
				<td>:</td>
				<td><?=nl2br($this->lookup["code"])?></td>
			</tr>
			<tr>
				<td><?=Msg::get("lookup.name")?></td>
				<td>:</td>
				<td><?=nl2br($this->lookup["name"])?></td>
			</tr>
			<tr>
				<td><?=Msg::get("lookup.description")?></td>
				<td>:</td>
				<td><?=nl2br($this->lookup["description"])?></td>
			</tr>
			<tr>
				<td><?=Msg::get("lookup.priority")?></td>
				<td>:</td>
				<td><?=nl2br($this->lookup["priority"])?></td>
			</tr>
			<tr>
				<td colspan="3" class="Command">
					<?=FormTag::back("command.back", "lookup")?>
				</td>
			</tr>
		</table>
	</div>
</div>