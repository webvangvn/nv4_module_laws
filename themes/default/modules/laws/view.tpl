<!-- BEGIN: main -->
<table class="archives_list">
	<thead>
    	<tr>
        	<td colspan="2">{LANG.doc_name} : <strong style="color:#036">{DATA.title}</strong></td>
        </tr>
    </thead>
    <tbody>
    	<tr>
        	<td width="25%" valign="top">{LANG.hometext}</td>
            <td valign="top"><p align="justify">{DATA.hometext}</p></td>
        </tr>
    </tbody>
    <tbody class="second">
    	<tr>
        	<td>{LANG.signtime_title}</td>
            <td><strong>{DATA.signtime}</strong></td>
        </tr>
    </tbody>
    <tbody>
    	<tr>
        	<td>{LANG.catcontent}</td>
            <td><a href="{DATA.cat_link}"><strong>{DATA.cat_title}</strong></a></td>
        </tr>
    </tbody>
    <tbody class="second">
    	<tr>
        	<td>{LANG.type_title}</td>
            <td><strong>{DATA.type_title}</strong></td>
        </tr>
    </tbody>
    <tbody>
    	<tr>
        	<td>{LANG.doc_of_room}</td>
            <td><a href="{DATA.room_link}"><strong>{DATA.room_title}</strong></a></td>
        </tr>
    </tbody>
    <tbody class="second">
    	<tr>
        	<td>{LANG.of_field}</td>
            <td><a href="{DATA.field_link}"><strong>{DATA.field_title}</strong></a></td>
        </tr>
    </tbody>
    <tbody>
    	<tr>
        	<td>{LANG.sign}</td>
            <td><strong>{DATA.sign}</strong></td>
        </tr>
    </tbody>
    <tbody class="second">
    	<tr>
        	<td>{LANG.issuing}</td>
            <td><a href="{DATA.organ_link}"><strong>{DATA.organ_title}</strong></a></td>
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
            <td><div style="padding:8px" class="clearfix">{DATA.bodytext}</div></td>
        </tr>
    </tbody>
    <thead>
    	<tr>
        	<td></td>
        </tr>
    </thead>
</table>
<!-- END: main -->