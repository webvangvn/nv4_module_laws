<!-- BEGIN: main -->
<!-- BEGIN: list_docs -->
<div class="col-lg-24 col-md-24 col-sm-24">
	<!-- BEGIN: listcat -->
	<div class="row page-header">
		<ul class="list-inline sub-list-icon" style="margin: 0">
			<li><h3><a title="{CAT.title}" href="{CAT.link}"><span>{CAT.title}</span></a></h3></li>
			<!-- BEGIN: subcatloop -->
			<li class="hidden-xs"><h4><a class="dimgray" title="{SUBCAT.title}" href="{SUBCAT.link}">{SUBCAT.title}</a></h4></li>
			<!-- END: subcatloop -->
			<!-- BEGIN: subcatmore -->
			<a class="dimgray pull-right hidden-xs" title="{MORE.title}" href="{MORE.link}"><em class="fa fa-sign-out">&nbsp;</em></a>
			<!-- END: subcatmore -->
		</ul>
	</div>
	<!-- END: listcat -->
	<div class="row">
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
			<!-- BEGIN: loop -->
			<tbody>
				<tr>
					<td>{ROW.no}</td>
					<td><a href="{ROW.view}" title="{ROW.title}"><h4>{ROW.title}</h4></a><em>{ROW.pubtime}</em></td>
					<td><p>{ROW.hometext}</p></td>
					<td>{ROW.signtime}</td>
					<td>{ROW.doc_status}</td>
				</tr>
			</tbody>
			<!-- END: loop -->
		</table>
	</div>
	<!-- BEGIN: htmlpage -->
	<div class="clearfix"></div>
	<div class="text-center">
	{htmlpage}
	</div>
	<!-- END: htmlpage -->
</div>
<!-- END: list_docs -->

<!-- BEGIN: no_data -->
<p class="alert alert-info">{NO_DOCS}</p>
<!-- END: no_data -->
<!-- END: main -->
