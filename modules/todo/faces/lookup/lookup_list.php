<? Apu::import("/util/Format.php"); ?>
<? Apu::import("/tag/FormTag.php"); ?>
<script type="text/javascript" src="<?=Apu::base()?>/themes/prototype.js"></script>
<script type="text/javascript" src="<?=Apu::base()?>/themes/apu.js"></script>
<script type="text/javascript" src="<?=Apu::theme()?>/init.js"></script>
<script type="text/javascript">
var LookupList = {
	search : function(evt) {
		var obj = Event.element(evt);
		$('searchFrame').toggle();
		LookupList.move(obj);
	},
	move: function(obj) {
		if ($('searchFrame').visible()) {
			Position.absolutize($('searchFrame'));
			var position = Position.positionedOffset(obj);
			$('searchFrame').style.top = position[1] + obj.getHeight() + 5;
			$('searchFrame').style.left = position[0] + obj.getWidth() + 8 - $('searchFrame').getWidth();
		}
	},
	close: function(evt) {
		var obj = Event.element(evt);
		var frameId = obj.readAttribute("frameId");
		$(frameId).toggle();
	},
	clear: function(evt) {
		var obj = Event.element(evt);
		document.forms[0]["list.filter.type"].value = "";
		document.forms[0]["list.filter.code"].value = "";
		document.forms[0].submit();
	},
	add: function(evt) {
		window.location.href = "lookup/add";
	}
}
Event.observe(window, "resize", function() {
	LookupList.move($('search'));
});
</script>

<style>
@IMPORT url("<?=Apu::theme()?>/main.css");
@IMPORT url("<?=Apu::theme()?>/application.css");
</style>

<table class="List">
	<tr>
		<th class="Sortable" sort="id"><?=Msg::get("lookup.id")?></th>
		<th class="Sortable" sort="type"><?=Msg::get("lookup.type")?></th>
		<th class="Sortable" sort="code"><?=Msg::get("lookup.code")?></th>
		<th class="Sortable" sort="name"><?=Msg::get("lookup.name")?></th>
		<th class="Sortable" sort="description"><?=Msg::get("lookup.description")?></th>
		<th class="Sortable" sort="priority"><?=Msg::get("lookup.priority")?></th>
		<th class="Sortable" sort="createdBy"><?=Msg::get("lookup.createdBy")?></th>
		<th class="Sortable" sort="createdTime"><?=Msg::get("lookup.createdTime")?></th>
		<th class="Sortable" sort="updatedBy"><?=Msg::get("lookup.updatedBy")?></th>
		<th class="Sortable" sort="updatedTime"><?=Msg::get("lookup.updatedTime")?></th>
		<th>
			<a href="lookup/add">
				<img src="<?=Apu::theme()?>/img/new.png" />
			</a>
		</th>
	</tr>
	<? if (!empty($this->list["list"])) { ?>
	<? reset($this->list["list"]); ?>
	<? while(list($i,$row) = each($this->list["list"])) { ?>
	<tr class="Row<?=$i%2?>" rowId="<?=$row["id"]?>">
		<td align="right"><?=$row["id"]?></td>
		<td><?=$row["type"]?></td>
		<td><?=$row["code"]?></td>
		<td><?=$row["name"]?></td>
		<td><?=$row["description"]?></td>
		<td align="right"><?=$row["priority"]?></td>
		<td><?=$row["createdBy"]?></td>
		<td><?=Format::datetime("format.datetime", $row["createdTime"])?></td>
		<td><?=$row["updatedBy"]?></td>
		<td><?=Format::datetime("format.datetime", $row["updatedTime"])?></td>
		<td>
			<a href="lookup/edit/?<?=$row["id"]?>">
				<img src="<?=Apu::theme()?>/img/edit.png" />
			</a>
			<a href="lookup/del/?<?=$row["id"]?>" onclick="return confirm('<?=Msg::get("message.confirm.delete")?>')">
				<img src="<?=Apu::theme()?>/img/del.png" />
			</a>
		</td>
	</tr>
	<?} ?>
	<? } else { ?>
	<tr>
		<td colspan="100" align="center"><?=Msg::get("message.emptyRow") ?></td>
	</tr>
	<? } ?>
	<tr valign="middle">
		<td colspan="100">
			<div style="float: left;">
				<a href="" id="first" onclick="return false;">
					<img src="<?=Apu::theme()?>/img/first.gif" style="float: left;"/>
				</a>
				<a href="" id="prev" onclick="return false;">
					<img src="<?=Apu::theme()?>/img/prev.gif" style="float: left;"/>
				</a>
				<input type="text" class="Text" style="margin: 0 0 0 0;width: 70px; float: left;text-align: center;" value="<?=Msg::get("message.page", array(1,1)) ?>"/>
				<a href="" id="next" onclick="return false;">
					<img src="<?=Apu::theme()?>/img/next.gif" style="float: left;"/>
				</a>
				<a href="" id="last" onclick="return false;">
					<img src="<?=Apu::theme()?>/img/last.gif" style="float: left;"/>
				</a>
			</div>
			<div style="float: right;">
				<a href="" id="add" onclick="return false;">
					<img src="<?=Apu::theme()?>/img/add.gif" style="float: left;"/>
				</a>
				<script type="text/javascript">
					Event.observe($('add'), "click", LookupList.add);
				</script>
				<a href="" id="search" onclick="return false;">
					<img src="<?=Apu::theme()?>/img/search.gif" style="float: left;"/>
				</a>
				<script type="text/javascript">
					Event.observe($('search'), "click", LookupList.search);
				</script>
			</div>			
		</td>
	</tr>
</table>

<form method="post" action="lookup/search">
<div class="Frame" id="searchFrame" style="width: 250px;display: none">
	<div class="Title"><?=Msg::get("LookupAction.search.title")?></div>
	<div class="Message"><?=Msg::message("LookupAction.search.description")?></div>
	<div align="center">
		<table class="Form">
			<tr>
				<td><?=Msg::get("lookup.type")?></td>
				<td>:</td>
				<td><?=FormTag::text("list.filter.type", $this->list["filter"]["type"])?></td>
			</tr>
			<tr>
				<td><?=Msg::get("lookup.code")?></td>
				<td>:</td>
				<td><?=FormTag::text("list.filter.code", $this->list["filter"]["code"])?></td>
			</tr>
			<tr>
				<td colspan="3" class="Command">
					<?=FormTag::submit("command.search")?>
					<input type="button" class="Button" id="clear" value="<?=Msg::get("command.clear")?>"/>
					<script type="text/javascript">					
					Event.observe($('clear'), "click", LookupList.clear);
					</script>
					<input type="button" class="Button" frameId="searchFrame" id="close" value="<?=Msg::get("command.close")?>"/>
					<script type="text/javascript">					
					Event.observe($('close'), "click", LookupList.close);
					</script>
				</td>
			</tr>
		</table>
	</div>
</div>
</form>