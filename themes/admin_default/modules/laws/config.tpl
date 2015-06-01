<!-- BEGIN: main -->
<form action="" method="post">
<input type="hidden" name="savesetting" value="1" />
<div class="table-responsive">
	<table summary="" class="table table-striped table-bordered table-hover"">
	  <tbody>
		<tr>
			<td align="right" width="280px" ><strong>{LANG.config_view_title}</strong></td>
			<td>
				<select name="view_type">
					<!-- BEGIN: home_view_loop -->
					<option value="{ROW.value}" {ROW.select}>{ROW.title}</option>
					<!-- END: home_view_loop -->
				</select>
			</td>
		</tr>
	  </tbody>
	  <tbody calss="second">
		<tr>
			<td align="right"><strong>{LANG.config_view_num}</strong></td>
			<td><input style="width: 50px" name="view_num" type="text" value="{DATA.view_num}"/></td>
		</tr>
	  </tbody>
	  <tbody calss="second">
		<tr>
			<td align="right"><strong>{LANG.config_who_upload}</strong></td>
			<td>{who_upload}</td>
		</tr>
	  </tbody>
	  <tbody id="id_groups_view">
		<tr>
			<td align="right"><strong>{LANG.groups_view}</strong></td>
			<td>    
				<!-- BEGIN: groups_views -->
				<span><input name="groups_view[]" type="checkbox" value="{groups_views.value}" {groups_views.check} />{groups_views.title}</span>
				<!-- END: groups_views -->
			</td>
		</tr>
	  </tbody>
	  <tbody calss="second">
		<tr>
			<td align="right"><strong>{LANG.status}</strong></td>
			<td>    
			   <input type="checkbox" value="1" name="status" {ck_status} />
			</td>
		</tr>
	  </tbody>
	  <tbody>
		<tr>
			<td align="center" colspan="2">
				<input type="submit" value="{LANG.save}" /> 
			</td>
		</tr>
	  </tbody>
	</table>
</div>
</form>
<script type="text/javascript">show_group();</script>
<!-- END: main -->