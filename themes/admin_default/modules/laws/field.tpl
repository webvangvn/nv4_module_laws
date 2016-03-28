<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>

<!-- BEGIN: list -->
<table class="table table-striped table-bordered table-hover">
	<thead>
        <tr>
            <td class="w100">{LANG.weight}</td>
            <td class="w200">{LANG.field_name}</td>
            <td class="w200">{LANG.alias}</td>
            <td class="w200"></td>
        </tr>
    </thead>
    <!-- BEGIN: loop -->
    <tbody {ROW.class}>
        <tr>
            <td align="center">{ROW.sweight}</td>
            <td><a href="{ROW.linkparent}"><strong>{ROW.title} ({ROW.numsubfield})</strong></a></td>
            <td>{ROW.alias}</td>
            <td align="center">
            	<span class="add_icon"><a href="{ROW.add}">{LANG.addcontent}</a></span>&nbsp;
            	<span class="edit_icon"><a href="{ROW.edit}">{LANG.edit}</a></span>&nbsp;
                <span class="delete_icon"><a href="{ROW.del}">{LANG.del}</a></span> 
            </td>
        </tr>
    </tbody>	
    <!-- END: loop -->
</table>
<!-- END: list --> 
<!-- BEGIN: form -->
<div id="edit">
	<!-- BEGIN: error -->
    <div class="quote" style="width:98%">
    	<blockquote class="error"><span>{ERROR}</span></blockquote>
    </div>
    <div class="clear"></div>
	<!-- END: error -->
    <form class="form-inline m-bottom" action="" method="post">
    <input name="save" type="hidden" value="1" />
    <input name="parentid_old" type="hidden" value="{DATA.parentid}" />
    <table summary="" class="table table-striped table-bordered table-hover">
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.field_name}: </strong></td>
				<td><input class="form-control" style="width: 600px" name="title" type="text" value="{DATA.title}" maxlength="255" id="idtitle"/></td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td align="right"><strong>{LANG.alias}: </strong></td>
				<td>
					<input class="form-control" style="width: 550px" name="alias" type="text" value="{DATA.alias}" maxlength="255" id="idalias"/>
					&nbsp; <em class="fa fa-refresh fa-lg fa-pointer" onclick="get_alias();">&nbsp;</em>
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td align="right"><strong>{LANG.field_parent}: </strong></td>
				<td>
				<select id="sel-field" class="form-control" name="parentid">
                	<option value="0" {ROW.select}>{LANG.field_main}</option>
					<!-- BEGIN: fieldlist -->
					<option value="{ROW.fieldid}" {ROW.select}>{ROW.xtitle}</option>
					<!-- END: fieldlist -->
				</select>
				</td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td align="right"><strong>{LANG.keywords}: </strong></td>
				<td><input class="form-control" style="width: 600px" name="keywords" type="text" value="{DATA.keywords}" maxlength="255" /></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td valign="top" align="right"><strong>{LANG.description} </strong></td>
				<td>
				<textarea class="form-control" style="width: 600px" name="description" cols="100" rows="5">{DATA.description}</textarea>
				</td>
			</tr>
		</tbody>
        <tbody>
        	<tr><td colspan="2" align="center">
            	<input class="btn btn-primary" name="submit1" type="submit" value="{LANG.save}" /></center>
            </td></tr>
        </tbody>
    </table>
</form>
</div>
<script type="text/javascript">
<!-- BEGIN: getalias -->
$("#idtitle").change(function () {
    get_alias();
});
$(document).ready(function() {
	$("#sel-field").select2();
});

<!-- END: getalias -->
show_group();
</script>
<!-- END: form -->
<!-- END: main -->

<!-- BEGIN: fielddel -->
<!-- BEGIN: subfield -->
<table summary="" class="table table-striped table-bordered table-hover">
    <tbody>
    	<tr>
        	<td align="center">{TITLE}</td>
        </tr>
    </tbody>
    <tbody class="second">
    	<tr>
        	<td align="center">
            	<input class="form-control" type="button" value="{LANG.viewsubcat}" onclick="window.location='{PURL}'" />
            </td>
        </tr>
    </tbody>
</table>    
<!-- END: subfield-->
<!-- BEGIN: nonefield -->
<table summary="" class="table table-striped table-bordered table-hover">
    <tbody>
    	<tr>
        	<td align="center">{TITLE}</td>
        </tr>
    </tbody>
    <tbody class="second">
    	<tr>
        	<td align="center">
            	<form action="" method="post">
                <input type="hidden" name="del" value="1" />
            	<input type="submit" value="{LANG.del_ok}"/>
                <input type="button" value="{LANG.no}" onclick="window.location='{PURL}'" />
                </form>
            </td>
        </tr>
    </tbody>
</table>    
<!-- END: nonefield-->
<!-- END: fielddel -->