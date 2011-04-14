<? while (list(,$module) = each($this->modules)) { ?>
var <?=$module["name"]?> = {
<? while (list(,$method) = each($module["methods"])) { ?>
	"<?=$method["name"]?>" : function(<?=$method["parameters"]?>) {
		new Ajax.Request('<?=$_SERVER['PHP_SELF']?>', {
			method: 'post',
			postBody: 'method=invoke&md=<?=$module["name"]?>&mt=<?=$method["name"]?>&'+<?=$method["args"]?>,
			onSuccess: function(transport) {
				try {
				var result = transport.responseText.evalJSON();
				__callback(result);
				} catch (e) {
					alert(Object.toJSON(e));
				}
			}
		});
	} 
<? } ?>
}
<? } ?>