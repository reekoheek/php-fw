<style>
@IMPORT url("<?=Apu::theme()?>/main.css");
@IMPORT url("<?=Apu::theme()?>/application.css");
</style>

<table class="List">
	<tr>
		<th class="Sortable">&nbsp;</th>
		<th class="Sortable">&nbsp;</th>
		<th class="Sortable"><?=Msg::get("task.project")?></th>
		<th class="Sortable"><?=Msg::get("task.title")?></th>
		<th class="Sortable"><?=Msg::get("task.user")?></th>
		<th class="Sortable"><?=Msg::get("task.status")?></th>
		<th>
			<a href="task/add">
				<img src="themes/apu/img/new.png" />
			</a>
		</th>
	</tr>
	<? if (!empty($_REQUEST["list"])) { ?>
	<? reset($_REQUEST["list"]); ?>
	<? while(list(,$row) = each($_REQUEST["list"])) { ?>
	<tr class="Row<?=$i%2?>">
		<td><?=$row["priority"]?></td>
		<td><?=$row["context"]?></td>
		<td><?=$row["project"]?></td>
		<td><?=$row["title"]?></td>
		<td><?=$row["created_by"]?></td>
		<td><?=$row["status"]?></td>
		<td>
			<a href="">
				<img src="themes/apu/img/edit.png" />
			</a>
			<a href="">
				<img src="themes/apu/img/del.png" />
			</a>
		</td>
	</tr>
	<?} ?>
	<? } else { ?>
	<tr class="Row0">
		<td colspan="100" align="center"><?=Msg::get("message.emptyRow") ?></td>
	</tr>
	<? } ?>
</table>