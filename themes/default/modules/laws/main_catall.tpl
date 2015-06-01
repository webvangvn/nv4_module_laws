<!-- BEGIN: main -->
<table class="archives_list">
	<thead>
    	<tr>
        	<td align="center" width="30">{LANG.no}</td>
            <td width="100">{LANG.doc_name}</td>
            <td>{LANG.hometext}</td>
            <td>{LANG.signtime}</td>
            <td width="80">{LANG.file}</td>
        </tr>
    </thead>
    <!-- BEGIN: cat -->
    <tbody class="maincat">
    	<tr>
        	<td colspan="5"><a href="{CAT.link}"><strong>{CAT.title}</strong></a></td>
        </tr>
    </tbody>
    <!-- BEGIN: loop -->
    <tbody>
    	<tr>
        	<td align="center">{ROW.no}</td>
            <td><a href="{ROW.view}">{ROW.title}</a></td>
            <td><a href="{ROW.view}"><p align="justify">{ROW.hometext}</p></a></td>
            <td>{ROW.signtime}</td>
            <td align="center"><a href="{ROW.down}">
      			<span class="archives_down" style="background:url({NV_BASE_SITEURL}themes/{TEMPLATE}/images/archives/{ROW.xfile}.png) no-repeat center left;">{LANG.down}</span>
            </a></td>
        </tr>
    </tbody>
    <!-- END: loop -->
    <!-- END: cat -->
    <thead>
    	<tr>
        	<td align="right" colspan="5">{htmlpage}</td>
        </tr>
    </thead>
</table>
<!-- END: main -->

