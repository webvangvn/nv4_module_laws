<!-- BEGIN: main -->
<div class="search_archives">
	<form action="" method="post" onSubmit="return search_submit_form();">
		<table><tr>
        <td><input type="text" value="{text_search}" style="width:200px;" id="otextseach"/></td>
        <td>
        	<select name="catid" style="width:230px;padding:1px" id="catid">
        		<option value="0">{LANG.all_title}</option>
                <!-- BEGIN: parent_loop -->
                <option value="{PAR.catid}" {PAR.select}>{PAR.xtitle}</option>
                <!-- END: parent_loop -->
        	</select>
        </td>
        <td><input type="button" value="{LANG.search_submit}" onClick="search_submit_form()"/></td>
        </tr></table>
    </form>
</div>
<!-- END: main -->