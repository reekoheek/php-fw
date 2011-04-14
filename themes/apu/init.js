Event.observe(window, "load", function() {
	var serverDatas = $("serverDatas").innerHTML.evalJSON();
	
	var textFields = $A(document.getElementsByClassName("Text"));
	textFields.each(function(text) {
		if (text.nodeName.toUpperCase() == "INPUT" || text.nodeName.toUpperCase() == "SELECT" || text.nodeName.toUpperCase() == "TEXTAREA") {
			Event.observe(text, "focus", function(evt) {
				var el = Event.element(evt);
				if (el.nodeName != '#document') {
					el.addClassName("Focus");
					if (el.nodeName.toUpperCase() == "INPUT") {						
						el.select();	
					}
				}
			});
			Event.observe(text, "blur", function(evt) {
				var el = Event.element(evt);
				if (el.nodeName != '#document') {
					el.removeClassName("Focus");
				}
			});
			Event.observe(text, "mouseover", function(evt) {
				var el = Event.element(evt);
				if (el.nodeName != '#document') {
					el.addClassName("Hover");
				}
			});
			Event.observe(text, "mouseout", function(evt) {
				var el = Event.element(evt);
				if (el.nodeName != '#document') {
					el.removeClassName("Hover");
				}
			});
		}
	});
	
	var sortables = $A(document.getElementsByClassName("Sortable"));
	sortables.each(function(sortable) {
		try {
			if (sortable.readAttribute("sort") == serverDatas["sort"]["key"]) {
				sortable.addClassName("Sorted" + serverDatas["sort"]["order"].toUpperCase());
			}
		} catch (e) {}
		
		Event.observe(sortable, "mouseover", function(evt) {
			var el = Event.element(evt);
			if (el.nodeName != '#document') {
				el.addClassName("Hover");
			}
		});
		
		Event.observe(sortable, "mouseout", function(evt) {
			var el = Event.element(evt);
			if (el.nodeName != '#document') {
				el.removeClassName("Hover");
			}
		});
		
		Event.observe(sortable, "click", function(evt) {
			var el = Event.element(evt);
			if (el.nodeName != '#document') {
				window.location.href = window.location.href + "/sort?sort=" + el.readAttribute("sort");
			}
		});
	});
	
	var rows = new Array(); 
	rows[0] = $A(document.getElementsByClassName("Row0"));
	rows[1] = $A(document.getElementsByClassName("Row1"));
	rows = rows.flatten();
	rows.each(function(row) {
		Event.observe(row, "mouseover", function(evt) {
			var el = Event.element(evt);
			if (el.nodeName != '#document') {
				if (el.nodeName == "TD") {
					el = el.parentNode;
				}
				el.addClassName("Hover");
			}
		});
		
		Event.observe(row, "mouseout", function(evt) {
			var el = Event.element(evt);
			if (el.nodeName != '#document') {
				if (el.nodeName == "TD") {
					el = el.parentNode;
				}
				el.removeClassName("Hover");
			}
		});
		
		Event.observe(row, "click", function(evt) {
			var el = Event.element(evt);
			if (el.nodeName != '#document' && el.nodeName.toUpperCase() != 'IMG') {
				if (el.nodeName == "TD") {
					el = el.parentNode;
				}
				window.location.href = window.location.href + "/view/?" + el.readAttribute("rowId");
			}
		});
	});
	
	var messages = $A(serverDatas["messages"]);
	var f = "";
	if (messages.length > 0) {
		messages.each(function(item) {
			var field = item["field"];
			if (field != null) {
				if (f == "") {
					f = field;
				}
				$(field).addClassName("Error");
			}
		});
		if (f != "") {
			$(f).focus();
		} else {
			try {
				Form.focusFirstElement(window.document.forms[0]);
			} catch (e) {}
		}
	} else {
		try {
			Form.focusFirstElement(window.document.forms[0]);
		} catch (e) {}
	}
});