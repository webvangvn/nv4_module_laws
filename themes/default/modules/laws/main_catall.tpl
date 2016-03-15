<!-- BEGIN: main -->
<table class="archives_list">
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
    	<tr>
        	<td colspan="5"><a href="{CAT.link}"><strong>{CAT.title}</strong></a></td>
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
    <thead>
    	<tr>
        	<td align="right" colspan="5">{htmlpage}</td>
        </tr>
    </thead>
</table>
<!-- END: main -->

