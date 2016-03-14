<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{error}</div>
<!-- END: error -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.theme.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.autocomplete.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.css" rel="stylesheet" />

<form class="form-inline m-bottom confirm-reload" action="" method="post" id="idcontent">
	<div class="row">
		<div class="col-sm-24 col-md-24">
			<input name="save" type="hidden" value="1" />
			<input name="status" type="hidden" value="0" id="idstatus"/>
			<input name="parentid_old" type="hidden" value="{DATA.parentid}" />
			<table class="table table-striped table-bordered">
				<col class="w200" />
				<col />
				<tbody>
					<tr>
						<td><strong>{LANG.doc_name} </strong></td>
						<td><input class="form-control" style="width:350px" name="title" type="text" value="{DATA.title}" maxlength="250" id="idtitle" required="required"/></td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td><strong>{LANG.alias} </strong></td>
						<td>
							<input class="form-control" style="width:350px" name="alias" type="text" value="{DATA.alias}" maxlength="250" id="idalias"/>&nbsp; <em class="fa fa-refresh fa-lg fa-pointer" onclick="get_alias();">&nbsp;</em>
						</td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td><strong>{LANG.cat_parent} </strong></td>
						<td>
						<select class="form-control w200" name="catid">
							<option value="">{LANG.sel_cat}</option>
							<!-- BEGIN: catlist -->
							<option value="{ROW.catid}" {ROW.select}>{ROW.xtitle}</option>
							<!-- END: catlist -->
						</select>
						</td>
					</tr>
				</tbody>
				<tbody>
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
						<select class="form-control w200" name="roomid">
							<option value="0">{LANG.room_main}</option>
							<!-- BEGIN: roomlist -->
							<option value="{ROW.roomid}" {ROW.select}>{ROW.xtitle}</option>
							<!-- END: roomlist -->
						</select>
						</td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td><strong>{LANG.of_field} </strong></td>
						<td>
						<select class="form-control w200" name="fieldid">
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
						<td><input class="form-control" style="width:350px" name="sign" type="text" value="{DATA.sign}" maxlength="250" />&nbsp; </td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td><strong>{LANG.pubtime} </strong></td>
						<td><input class="form-control" style="width:100px" name="pubtime" id="pubtime" type="text" value="{DATA.pubtime}" maxlength="10" /></td>
					</tr>
					<tr>
						<td><strong>{LANG.signtime} </strong></td>
						<td><input class="form-control" style="width:100px" name="signtime" id="signtime" type="text" value="{DATA.signtime}" maxlength="10" /></td>
					</tr>
					<tr>
						<td><strong>{LANG.exptime} </strong></td>
						<td><input class="form-control" style="width:100px" name="exptime" id="exptime" type="text" value="{DATA.exptime}" maxlength="10" /></td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td><strong>{LANG.issuing} </strong></td>
						<td>
							<select class="form-control w350" name="organid">
								<option value="0">{LANG.organ_main}</option>
								<!-- BEGIN: organlist -->
								<option value="{ROW.organid}" {ROW.select}>{ROW.xtitle}</option>
								<!-- END: organlist -->
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="table table-striped table-bordered table-hover">
				<col class="w200" />
				<col />
				<tbody>
					<tr>
						<td colspan="2"><strong>{LANG.pathfile} </strong> <em>({LANG.notepathfile})</em></td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td><strong>{LANG.serverpathfile} </strong></td>
						<td>
						<input class="form-control w200" style="width:400px" type="text" name="filepath" id="filepath" value="{DATA.filepath}"/>
						&nbsp;<input id="select-file-post" class="btn btn-primary" type="button" value="Browse server" name="selectfile"/>
						</td>
					</tr>
				</tbody>
				<tbody>
					<tr>
						<td><strong>{LANG.otherpathfile} </strong></td>
						<td>
							<input class="form-control w200" style="width:400px" type="text" name="otherpath" value="{DATA.otherpath}"/>
						</td>
					</tr>
				</tbody>
			</table>    
			<table class="table table-striped table-bordered table-hover">  
				<col class="w200" />
				<col />
				<tbody>
					<tr><td>
						<strong>{LANG.homtext}</strong>
					</td></tr>
				</tbody>
				<tbody>
					<tr><td>
						<textarea class="form-control" style="width: 99%" name="hometext" rows="5">{DATA.hometext}</textarea>
					</td></tr>
				</tbody>
			</table>
			<table class="table table-striped table-bordered table-hover">    
				<col class="w200" />
				<col />
				<tbody>
					<tr><td colspan="2">
						<strong>{LANG.bodytext} </strong>
					</td></tr>
				</tbody>
				<tbody>
					<tr><td colspan="2">
						{edit_bodytext}
					</td></tr>
				</tbody>
				<tbody>
					<tr>
						<td width="80"><strong>{LANG.keywords} </strong></td>
						<td><input class="form-control" style="width: 99%" name="keywords" type="text" value="{DATA.keywords}" maxlength="250" /></td>
					</tr>
				</tbody>
			</table>
			<table class="table table-striped table-bordered table-hover">
				<col class="w200" />
				<col />		
				<tbody>
					<tr><td align="center">
						<input class="btn btn-success" name="submit1" type="button" value="{LANG.save_yes}" onclick="content_submit(1)"/>
						<input class="btn btn-primary" name="submit1" type="button" value="{LANG.save_no}" onclick="content_submit(0)" />
					</td></tr>
				</tbody>
			</table>
		</div>
	</div>
</form>
<script type="text/javascript">
//<![CDATA[
var LANG = [];
var CFG = [];
CFG.uploads_dir_user = "{UPLOADS_DIR_USER}";
CFG.upload_current = "{UPLOAD_CURRENT}";
<!-- BEGIN: getalias -->
$("#idtitle").change(function () {
    get_alias();
});
<!-- END: getalias -->
//]]>
</script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.autocomplete.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/admin_default/js/laws_content.js"></script>
<!-- END: main -->