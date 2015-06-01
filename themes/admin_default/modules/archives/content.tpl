<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="quote" style="width:98%">
    <blockquote class="error"><span>{ERROR}</span></blockquote>
</div>
<div class="clear"></div>
<!-- END: error -->
<form action="" method="post" id="idcontent">
<input name="save" type="hidden" value="1" />
<input name="status" type="hidden" value="0" id="idstatus"/>
<input name="parentid_old" type="hidden" value="{DATA.parentid}" />
<div class="table-responsive">
    <table summary="" class="table table-striped table-bordered table-hover">
		<tbody>
			<tr>
				<td width="180"><strong>{LANG.doc_name} </strong></td>
				<td><input style="width: 600px" name="title" type="text" value="{DATA.title}" maxlength="255" id="idtitle"/></td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td><strong>{LANG.alias} </strong></td>
				<td>
					<input style="width: 550px" name="alias" type="text" value="{DATA.alias}" maxlength="255" id="idalias"/>
					<input type="button" value="GET" onclick="get_alias();" style="font-size:11px"/>
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td><strong>{LANG.cat_parent} </strong></td>
				<td>
				<select name="catid">
					<!-- BEGIN: catlist -->
					<option value="{ROW.catid}" {ROW.select}>{ROW.xtitle}</option>
					<!-- END: catlist -->
				</select>
				</td>
			</tr>
		</tbody>
        <tbody class="second">
			<tr>
				<td><strong>{LANG.typecontent} </strong></td>
				<td>
					{type_content}
				</td>
			</tr>
		</tbody>
        <tbody>
			<tr>
				<td><strong>{LANG.inroom} </strong></td>
				<td>
				<select name="roomid">
                	<option value="0">{LANG.room_main}</option>
					<!-- BEGIN: roomlist -->
					<option value="{ROW.roomid}" {ROW.select}>{ROW.xtitle}</option>
					<!-- END: roomlist -->
				</select>
				</td>
			</tr>
		</tbody>
        <tbody class="second">
			<tr>
				<td><strong>{LANG.of_field} </strong></td>
				<td>
				<select name="fieldid">
                	<option value="0">{LANG.field_main}</option>
					<!-- BEGIN: fieldlist -->
					<option value="{ROW.fieldid}" {ROW.select}>{ROW.xtitle}</option>
					<!-- END: fieldlist -->
				</select>
				</td>
			</tr>
		</tbody>
        <tbody>
			<tr>
				<td><strong>{LANG.sign} </strong></td>
				<td><input style="width: 200px" name="sign" type="text" value="{DATA.sign}" maxlength="255" /></td>
			</tr>
		</tbody>
        <tbody class="second">
			<tr>
				<td><strong>{LANG.signtime} </strong></td>
				<td><input style="width: 200px" name="signtime" type="text" value="{DATA.signtime}" maxlength="255" /> Eg: 31/12/2011</td>
			</tr>
		</tbody>
        <tbody>
			<tr>
				<td><strong>{LANG.issuing} </strong></td>
				<td>
                	<select name="organid">
                        <option value="0">{LANG.organ_main}</option>
                        <!-- BEGIN: organlist -->
                        <option value="{ROW.organid}" {ROW.select}>{ROW.xtitle}</option>
                        <!-- END: organlist -->
                    </select>
                </td>
			</tr>
		</tbody>
    </table>
    <table summary="" class="table table-striped table-bordered table-hover">
    	<tbody class="second">
			<tr>
				<td colspan="2"><strong>{LANG.pathfile} </strong> <em>({LANG.notepathfile})</em></td>
			</tr>
		</tbody>
        <tbody>
			<tr>
				<td align="right"><strong>{LANG.serverpathfile} </strong></td>
				<td>
				<input style="width:400px" type="text" name="filepath" id="filepath" value="{DATA.filepath}"/>
                <input type="button" value="Browse server" name="selectfile"/>
				</td>
			</tr>
		</tbody>
        <tbody class="second">
			<tr>
				<td align="right"><strong>{LANG.otherpathfile} </strong></td>
				<td>
				<input style="width:500px" type="text" name="otherpath" value="{DATA.otherpath}"/>
				</td>
			</tr>
		</tbody>
    </table>    
    <table summary="" class="table table-striped table-bordered table-hover">    
        <tbody class="second">
        	<tr><td>
            	<strong>{LANG.homtext} </strong>
            </td></tr>
        </tbody>
        <tbody>
        	<tr><td>
            	<textarea style="width: 99%" name="hometext" rows="5">{DATA.hometext}</textarea>
            </td></tr>
        </tbody>
    </table>
    <table summary="" class="table table-striped table-bordered table-hover">    
    	<tbody class="second">
        	<tr><td colspan="2">
            	<strong>{LANG.bodytext} </strong>
            </td></tr>
        </tbody>
        <tbody>
        	<tr><td colspan="2">
            	{edit_bodytext}
            </td></tr>
        </tbody>
        <tbody class="second">
			<tr>
				<td width="80"><strong>{LANG.keywords} </strong></td>
				<td><input style="width: 99%" name="keywords" type="text" value="{DATA.keywords}" maxlength="255" /></td>
			</tr>
		</tbody>
    </table>
    <table summary="" class="table table-striped table-bordered table-hover">    
        <tbody>
        	<tr><td align="center">
            	<input name="submit1" type="button" value="{LANG.save_no}" onclick="content_submit(0)" />
            	<input name="submit1" type="button" value="{LANG.save_yes}" onclick="content_submit(1)"/>
            </td></tr>
        </tbody>
    </table>
</div>
</form>
<script type="text/javascript">
<!-- BEGIN: getalias -->
$("#idtitle").change(function () {
    get_alias();
});
<!-- END: getalias -->
$("input[name=selectfile]").click(function(){
	var area = "filepath";
	var path= "{NV_UPLOADS_DIR}/{module_name}";	
	var currentpath= "{CURRENT}";						
	var type= "file";
	nv_open_browse("{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=" + area+"&path="+path+"&type="+type+"&currentpath="+currentpath, "NVImg", "850", "400","resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});
</script>
<!-- END: main -->
