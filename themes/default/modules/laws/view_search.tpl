<!-- BEGIN: main -->
<div class="clearfix">
	<form action="" method="post" onSubmit="return search_submit_form();">
	<div class="search_archives">
		<input type="text" value="{DATA.q}" style="width:300px;" id="otextseach"/>
		<select name="type" style="width:230px;padding:1px" id="type">
			<option value="0">{LANG.search_type}</option>
			<!-- BEGIN: type_loop -->
			<option value="{ROW.val}" {ROW.select}>{ROW.title}</option>
			<!-- END: type_loop -->
		</select>
	</div>
	<div class="search_archives">  
		<select name="catid" style="width:230px;padding:1px" id="catid">
			<option value="0">{LANG.catcontent}</option>
			<!-- BEGIN: cat_loop -->
			<option value="{ROW.catid}" {ROW.select}>{ROW.xtitle}</option>
			<!-- END: cat_loop -->
		</select>
		<select name="organid" style="width:230px;padding:1px" id="organid">
			<option value="0">{LANG.issuing}</option>
			<!-- BEGIN: organ_loop -->
			<option value="{ROW.organid}" {ROW.select}>{ROW.xtitle}</option>
			<!-- END: organ_loop -->
		</select>
	</div>
	<div class="search_archives">
		<select name="roomid" style="width:230px;padding:1px" id="roomid">
			<option value="0">{LANG.doc_of_room}</option>
			<!-- BEGIN: room_loop -->
			<option value="{ROW.roomid}" {ROW.select}>{ROW.xtitle}</option>
			<!-- END: room_loop -->
		</select>
		<select name="fieldid" style="width:230px;padding:1px" id="fieldid">
			<option value="0">{LANG.of_field}</option>
			<!-- BEGIN: field_loop -->
			<option value="{ROW.fieldid}" {ROW.select}>{ROW.xtitle}</option>
			<!-- END: field_loop -->
		</select>
	</div>
	<div class="search_archives">
		<table><tr>
		<td><strong>{LANG.btime}</strong></td>
		<td><input type="text" value="{DATA.btime}" style="width:120px;" id="btime"/></td>
		<td>&nbsp;</td>
		<td><strong>{LANG.etime}</strong></td>
		<td><input type="text" value="{DATA.etime}" style="width:120px;" id="etime"/></td>
		<td><input type="button" value="{LANG.search_submit}" onClick="search_submit_form_adv()"/></td>
		</tr></table>
	</div>
	</form>
	{RESULT}
</div>
<!-- END: main -->
