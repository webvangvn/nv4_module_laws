<!-- BEGIN: main -->
<div class="clearfix">
	<table class="table archives_list">
		<thead>
			<tr>
				<td class="w100">{LANG.no}</td>
				<td class="w150">{LANG.doc_name}</td>
				<td class="w200">{LANG.hometext}</td>
				<td class="w100">{LANG.signtime}</td>
				<td class="w100">{LANG.doc_status}</td>
			</tr>
		</thead>
		<!-- BEGIN: cat -->
		<tbody class="maincat">
			<tr class="info">
				<td colspan="5">
					<ul class="list-inline sub-list-icon" style="margin: 0">
						<li><h3><a title="{CAT.title}" href="{CAT.link}"><span>{CAT.title}</span></a></h3></li>
						<!-- BEGIN: subcatloop -->
						<li class="hidden-xs"><h4><a class="dimgray" title="{SUBCAT.title}" href="{SUBCAT.link}">{SUBCAT.title}</a></h4></li>
						<!-- END: subcatloop -->
						<!-- BEGIN: subcatmore -->
						<a class="dimgray pull-right hidden-xs" title="{MORE.title}" href="{MORE.link}"><em class="fa fa-sign-out">&nbsp;</em></a>
						<!-- END: subcatmore -->
					</ul>
				</td>
			</tr>
		</tbody>
		<!-- BEGIN: loop -->
		<tbody>
			<tr>
				<td align="center">{ROW.no}</td>
				<td><a href="{ROW.view}"><h4>{ROW.title}</h4></a><em>({LANG.pubtime_title}: {ROW.pubtime})</em></td>
				<td><p align="justify">{ROW.hometext}</p></td>
				<td>{ROW.signtime}</td>
				<td align="center">{ROW.doc_status}</td>
			</tr>
		</tbody>
		<!-- END: loop -->
		<!-- END: cat -->
	</table>
</div>
<!-- END: main -->

