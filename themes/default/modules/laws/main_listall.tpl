<!-- BEGIN: main -->
<table class="archives_list">
<center><b>HỆ THỐNG QUẢN LÝ VĂN BẢN</b></center>
	<thead>
    	<tr>
        	<td align="center" width="10">{LANG.no}</td>
            <td align="center" width="20">{LANG.doc_name}</td>
            <td align="center" width="200">{LANG.hometext}</td>
            <td align="center" width="30">{LANG.signtime}</td>
            <td align="center" width="30">{LANG.file}</td>
        </tr>
    </thead>
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
    <thead>
    	<tr>
        	<td align="right" colspan="5">{htmlpage}</td>
        </tr>
    </thead>
</table>
<!-- END: main -->
