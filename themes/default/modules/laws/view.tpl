<!-- BEGIN: main -->
<div class="col-md-24 col-lg-24 col-sm-24">
	<table class="archives_list">
		<thead>
			<tr>
				<td colspan="2">{LANG.doc_name} : <strong style="color:#036">{DATA.title}</strong></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="25%" valign="top"><strong>{LANG.hometext}</strong></td>
				<td valign="top"><p align="justify">{DATA.hometext}</p></td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td><strong>{LANG.pubtime_title}</strong></td>
				<td>{DATA.pubtime}</td>
			</tr>
			<tr>
				<td><strong>{LANG.signtime_title}</strong></td>
				<td>{DATA.signtime}</td>
			</tr>
			<!-- BEGIN: exptime -->
			<tr>
				<td><strong>{LANG.exptime_title}</strong></td>
				<td>{DATA.exptime}</td>
			</tr>
			<!-- END: exptime -->
		</tbody>
		<tbody>
			<tr>
				<td><strong>{LANG.catcontent}</strong></td>
				<td>
					<!-- BEGIN: cat_link --><a href="{DATA.cat_link}"><strong>{DATA.cat_title}</strong></a><!-- END: cat_link -->
					<!-- BEGIN: cat_updating --><strong>{DATA.cat_title}</strong><!-- END: cat_updating -->
				</td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td><strong>{LANG.type_title}</strong></td>
				<td>{DATA.type_title}</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td><strong>{LANG.doc_of_room}</strong></td>
				<td>
					<!-- BEGIN: room_link --><a href="{DATA.room_link}">{DATA.room_title}</a><!-- END: room_link -->
					<!-- BEGIN: room_updating -->{DATA.room_title}<!-- END: room_updating -->
				</td>
			</tr>
		</tbody>
		<tbody class="second">
			<tr>
				<td><strong>{LANG.of_field}</strong></td>
				<td>
					<!-- BEGIN: field_link --><a href="{DATA.field_link}">{DATA.field_title}</a><!-- END: field_link -->
					<!-- BEGIN: field_updating -->{DATA.field_title}<!-- END: field_updating -->
				</td>
			</tr>
		</tbody>
		<!-- BEGIN: sign -->
		<tbody>
			<tr>
				<td><strong>{LANG.sign}</strong></td>
				<td>{DATA.sign}</td>
			</tr>
		</tbody>
		<!-- END: sign -->	
		<tbody class="second">
			<tr>
				<td><strong>{LANG.issuing}</strong></td>
				<td>
					<!-- BEGIN: organ_link --><a href="{DATA.organ_link}">{DATA.organ_title}</strong></a><!-- END: organ_link -->
					<!-- BEGIN: organ_updating -->{DATA.organ_title}<!-- END: organ_updating -->
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td align="right" colspan="2">
					<span style="color:#666; font-size:11px">{LANG.view} : {DATA.view} | {LANG.down} : {DATA.down}</span>
					<a href="{DATA.linkdown}">
						<span class="archives_down" style="background:url({NV_BASE_SITEURL}themes/{TEMPLATE}/images/archives/{DATA.xfile}.png) no-repeat center left;">
						{LANG.down}</span>
					</a>
				</td>
			</tr>
		</tbody>
	</table>
	<table class="archives_list">
		<thead>
			<tr>
				<td><strong>{LANG.bodytext}</strong></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><div class="clearfix">{DATA.bodytext}</div></td>
			</tr>
		</tbody>
		<thead>
			<tr>
				<td></td>
			</tr>
		</thead>
	</table>
</div>
<!-- END: main -->