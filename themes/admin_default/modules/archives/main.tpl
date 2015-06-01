<!-- BEGIN: main -->
<form action="{NV_BASE_ADMINURL}index.php" method="GET">
<div class="table-responsive">
<table summary="" class="table table-striped table-bordered table-hover">
    <tbody>
    <tr>
        <td>
        	{LANG.search_cat} :
            <select name="catid" id="catid">
                <option value="0">{LANG.search_cat_all}</option>
                <!-- BEGIN: cloop -->
                <option value="{CAT.catid}" {CAT.select}>{CAT.xtitle}</option>
                <!-- END: cloop -->
            </select>
         	{LANG.search_per_page}
         	<input type="text" name="per_page" value="{per_page}" id="idper_page" style="width:50px" />
         </td>
    </tr>
    </tbody>
</table>
</div>
<div class="table-responsive">
<table summary="" class="table table-striped table-bordered table-hover">   
    <tbody class="second">
    <tr>
        <td>
        	<input type="text" value="{q}" maxlength="64" name="q" id="idq" style="width: 265px">
        	<input type="button" value="{LANG.search}" onClick="search_rows()">
        	{LANG.search_note}
        </td>
    </tr>
    </tbody>
</table>
</div>
<input type="hidden" name ="checkss" value="{session_id}"/>
</form>

<form name="block_list">
<div class="table-responsive">
<table summary="" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td class="text-center" >
               <input name="check_all[]"  type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" />
            </td>
            <td class="text-center" ><a href="{base_url_id}">ID</a></td>
            <td class="text-center" ><a href="{base_url_name}">{LANG.doc_name}</a></td>
            <td class="text-center" >{LANG.search_cat}</td>
            <td class="text-center" >{LANG.doc_of_room}</td>
            <td aclass="text-center" >{LANG.status}</td>
        	<td class="text-center" ></td>
        </tr>
    </thead>
    <!-- BEGIN: loop -->
    <tbody {ROW.bg}>
    	<tr>
        	<td class="text-center">
              <input type="checkbox" value="{ROW.id}" class="idlist" name="idcheck[]" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" />
            </td>
            <td class="text-center">
              {ROW.id}
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
                <span class="delete_icon"><a href="#" class="delall">{LANG.del_select}</a></span>&nbsp;
                <span class="add_icon"><a href="{ADDCONTENT}">{LANG.addcontent}</a></span>
			</td>
            <td colspan="5" align="right"><!-- BEGIN: page -->{generate_page}<!-- END: page --></td>
		</tr>
	</tfoot>
</table>
</div>
</form>
<script type="text/javascript">
clickcheckall();
delete_one('adel','{LANG.del_confim}','{URLBACK}');
delete_all('idlist','delall','{LANG.del_confim}','{LANG.no_select_items}','{DELALL}','{URLBACK}');
</script>
<!-- END: main -->