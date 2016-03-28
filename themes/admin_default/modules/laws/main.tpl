<!-- BEGIN: main -->
<form class="form-inline m-bottom" action="{NV_BASE_ADMINURL}index.php" method="GET">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
    <tbody>
		<tr>
			<td>
				<input class="form-control" type="text" value="{q}" maxlength="64" name="q" id="idq" style="width: 265px">
				<input class="btn btn-primary" type="button" value="{LANG.search}" onClick="search_rows()">
				{LANG.search_cat} :
				<select class="form-control" name="catid" id="catid">
					<option value="0">{LANG.search_cat_all}</option>
					<!-- BEGIN: cloop -->
					<option value="{CAT.catid}" {CAT.select}>{CAT.xtitle}</option>
					<!-- END: cloop -->
				</select>
				{LANG.search_per_page}
				<select class="form-control" id="idper_page" name="per_page">
					<option value="--------------">{LANG.search_per_page}</option>
					<!-- BEGIN: per_page -->
					<option value="{PER_PAGE.title}" {PER_PAGE.selected}>{PER_PAGE.title}</option>
					<!-- END: per_page -->
				</select>
			 </td>
		</tr>
    </tbody>
</table>
</div>
<input type="hidden" name ="checkss" value="{session_id}"/>
</form>
<form class="form-inline m-bottom" name="block_list">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<td class="text-center" >
				   <input name="check_all[]"  type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" />
				</td>
				<td class="text-center"><strong>STT</strong></td>
				<td class="text-center"><a href="{base_url_name}"><strong>{LANG.doc_name}</strong></a></td>
				<td class="text-center"><strong>{LANG.search_cat}</strong></td>
				<td class="text-center"><strong>{LANG.doc_of_room}</strong></td>
				<td class="text-center"><strong>{LANG.status}</strong></td>
				<td class="text-center"></td>
			</tr>
		</thead>
		<!-- BEGIN: loop -->
		<tbody {ROW.bg}>
			<tr>
				<td class="text-center">
				  <input type="checkbox" value="{ROW.id}" class="idlist" name="idcheck[]" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" />
				</td>
				<td class="text-center">
				  {ROW.stt}
				</td>
				<td>
					<a href="{ROW.link}" target="_blank"><b>{ROW.title}</b></a>
				</td>
				<td><a href="{ROW.cat_link}">{ROW.cat_title}</a></td>
				<td><a href="{ROW.room_link}">{ROW.room_title}</a></td>
				<td align="center">{ROW.status}</td>
				<td align="center">
					<span class="edit_icon"><a href="{ROW.edit}">{LANG.edit}</a></span> - 
					<span class="delete_icon"><a href="{ROW.del}" class="adel">{LANG.del}</a></span> 
				</td>
			</tr>
		</tbody>
		<!-- END: loop -->
		<tfoot>
			<tr align="left">
				<td colspan="3">
					<span class="btn btn-danger"><a style="color: white; font-weight: bold" href="#" class="delall">{LANG.del_select}</a></span>&nbsp;
					<span class="btn btn-primary"><a style="color: white; font-weight: bold" href="{ADDCONTENT}">{LANG.addcontent}</a></span>
				</td>
			</tr>
		</tfoot>
	</table>
</form>
<!-- BEGIN: generate_page -->
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->

<script type="text/javascript">
	clickcheckall();
	delete_one('adel','{LANG.del_confim}','{URLBACK}');
	delete_all('idlist','delall','{LANG.del_confim}','{LANG.no_select_items}','{DELALL}','{URLBACK}');
</script>
<!-- END: main -->