<script type="text/javascript" src="themes/prototype.js"></script>
<script type="text/javascript" src="themes/scriptaculous.js"></script>

<style>
@IMPORT url("themes/apu/main.css");
@IMPORT url("themes/apu/application.css");
</style>

Local incremental array autocompleter ac4<br/> 
with full-search. Type 'Jac', hit enter a few <br/>
times, type 'gne'.<br/> 
<textarea rows=5 cols=20 id="ac4" autocomplete="off"></textarea>
<div id="ac4update" style="display:none;border:1px solid black;background-color:white;" class="AutocompleterPopup"></div>

<script type="text/javascript">
new Autocompleter.Local('ac4','ac4update',
	["John Jackson", "", "Jack Johnson", "", "Jane Agnews"], 
	{ tokens: [',','\n'], fullSearch: true, partialSearch: true }
);
</script>

<br/><br/>

Local incremental array autocompleter ac5<br/> 
with fixed height and scrollbar. Type 'Jac', hit enter a few <br/>
times, type 'gne'.<br/> 
<input id="ac5" type="text" autocomplete="off"/>
<div id="ac5update" style="display:none;border:1px solid black;background-color:white;height:50px;overflow:auto;"></div>

<script type="text/javascript">
new Autocompleter.Local('ac5','ac5update',
	["John Jackson", "Jack Johnson", "Jane Agnews", "Jack Johnson", "Jane Agnews", "Jack Johnson", "Jane Agnews"], 
	{ tokens: [',','\n'], fullSearch: true, partialSearch: true }
);
</script>