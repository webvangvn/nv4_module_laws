<?php

/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 29 May 2015 07:49:53 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['cat'];

$groups_list = nv_groups_list();
$contents = "";
$error = "";
$parentid = $nv_Request->get_int( 'parentid', 'get', 0 );
$catid = $nv_Request->get_int( 'catid', 'get,post', 0 );
$data = array(
	"catid"=>0, "parentid"=>0, "title"=>"", "alias"=>"", "description"=>"", "image"=>"", 
	"thumbnail"=>"", "weight"=>0, "order"=>0, "lev"=>0, "viewcat"=>"viewcat_list", "numsubcat"=>0,
    "subcatid"=>"", "inhome"=>1, "numlinks"=>3, "keywords"=>"", "admins"=>0, "add_time"=>NV_CURRENTTIME, 
    "edit_time"=>NV_CURRENTTIME, "del_cache_time"=>0, "who_view"=>0, "groups_view"=>"","numrow"=>0
);

//post data
$savecat=$nv_Request->get_int( 'save', 'post', 0 );
if ( $savecat == '1' )
{
	$data['catid'] = $nv_Request->get_int( 'catid', 'post', 0 );
    $parentid_old = $nv_Request->get_int( 'parentid_old', 'post', 0 );
    $data['parentid'] = $nv_Request->get_int( 'parentid', 'post', 0 );
    $data['title'] = $nv_Request->get_string( 'title', 'post', '', 1 );
    $data['keywords'] = $nv_Request->get_string( 'keywords', 'post', '', 1 );
    $alias = $nv_Request->get_string( 'alias', 'post', '' );
    $data['alias'] = ( $alias == "" ) ? change_alias( $data['title'] ) : change_alias( $alias );
    $description = $nv_Request->get_string( 'description', 'post', '' );
    $data['description'] = nv_nl2br( nv_htmlspecialchars( strip_tags( $description ) ), '<br />' );
    $data['who_view'] = $nv_Request->get_int( 'who_view', 'post', 0 );  
    $groups = $nv_Request->get_typed_array( 'groups_view', 'post', 'int', array() );
    $groups = array_intersect( $groups, array_keys( $groups_list ) );
    $data['groups_view'] = implode( ",", $groups );
	
    if ( empty($data['title']) ) $error = $lang_module['cat_title_erorr'];
    else 
    {
    	if ($catid==0)
    	{
    		//insert data
			$result=$db->query( "SELECT max(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE parentid='" . $data['parentid'] . "'" );
	    	$weight = $result->fetch();
	        $weight = intval( $weight ) + 1;
	        $query = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_cat (catid, parentid, title, alias, description, image, thumbnail, weight, orders, lev, viewcat, numsubcat, subcatid, inhome, numlinks, keywords, admins, add_time, edit_time, del_cache_time, who_view, groups_view,numrow)
	         		  VALUES (NULL, :parentid , :title , :alias, :description, '', '', :weight, '0', '0', :viewcat, '0', :subcatid, '1', '3', :keywords, ''," . NV_CURRENTTIME . "," . NV_CURRENTTIME . ", " . NV_CURRENTTIME . " + 26000000, :who_view, :groups_view,:numrow)";
	        $data_insert = array();

			$data_insert['parentid'] = $data['parentid'];
			$data_insert['title'] = $data['title'];
			$data_insert['alias'] = $data['alias'];
			$data_insert['description'] = $data['description'];
			$data_insert['weight'] = $weight;
			$data_insert['viewcat'] = $data['viewcat'];
			$data_insert['subcatid'] = $data['subcatid'];
			$data_insert['keywords'] = $data['keywords'];
			 
			$data_insert['who_view'] = $data['who_view'];
			$data_insert['groups_view'] = $data['groups_view'];
			$data_insert['numrow'] = $data['numrow'];
			$newcatid=$db->insert_id( $query, 'catid', $data_insert );
			//$newcatid=0;
			
	        if ( $newcatid > 0 )
	        {
	        	nv_fix_cat_order();
				nv_del_moduleCache( $module_name );
				nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['add_cat'], $data['title'], $admin_info['userid'] );
	            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&parentid=" . $data['parentid'] . "" );
	            die();
	        }
	    	else
	        {
	            $error = $lang_module['errorsave'];
	        }
	        $db->sqlreset();
    	}
    	elseif($catid>0) 
    	{
    		//update data
    		$query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET parentid='" . $data['parentid'] . "', title='" . $data['title'] . "', alias =  '" . $data['alias'] . "', description='" . $data['description'] . "', keywords= '" . $data['keywords'] . "', who_view='" . $data['who_view'] . "', groups_view='" . $data['groups_view'] . "', edit_time=UNIX_TIMESTAMP( ) WHERE catid =" . $catid . "";
        	$result=$db->query( $query );
        	if ( $result->rowCount() > 0 )
	        {
	        	if ( $data['parentid'] != $parentid_old )
	        	{
					$result= $db->query( "SELECT max(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE parentid='" . $data['parentid'] . "'" );
	        		 $weight  = $result->fetch();
	                $weight = intval( $weight ) + 1;
	                $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET weight='" . $weight . "' WHERE catid=" . intval( $catid );
	                $db->query( $sql );
					nv_del_moduleCache( $module_name );
	                nv_fix_cat_order();
	                nv_fix_cat_row ( $catid );
	        	}
				nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['edit_cat'], $data['title'], $admin_info['userid'] );
	        	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&parentid=" . $data['parentid'] . "" );
	            die($catid);
	        }
	        else
	        {
	            $error = $lang_module['errorsave'];
	        }
	        $db->sqlreset();
    	}
    }
}

//select data
if ( $catid > 0)
{
	$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE catid = '" . $catid . "' ORDER BY weight ASC";
	$result = $db->query( $sql );
	$data = $result->fetch();
}

/**
 * begin: listview data 
 */
$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
if ( $parentid > 0 )
{
    $parentid_i = $parentid;
    $array_cat_title = array();
    while ( $parentid_i > 0 )
    {
        $array_cat_title[] = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;parentid=" . $parentid_i . "\"><strong>" . $global_array_cat[$parentid_i]['title'] . "</strong></a>";
        $parentid_i = $global_array_cat[$parentid_i]['parentid'];
    }
    sort( $array_cat_title, SORT_NUMERIC );
    $ptemp = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;parentid=0\"><strong>" . $lang_module['root_cat'] . "</strong></a>";
    $contents .= $ptemp." -> ".implode( " -> ", $array_cat_title );
}

$num = 1;
foreach ( $global_array_cat as $row )
{
    if ( $row['parentid'] == $parentid ) $num++;
}
if ( $num > 0 )
{
    $array_inhome = array( 
        0 => $lang_global['no'], 1 => $lang_global['yes'] 
    );
    $array_viewcat = array( 
        "viewcat_list" => $lang_module['list'], "viewcat_gird" => $lang_module['gird'] 
    );
    $a = 1;
    foreach ( $global_array_cat as $row )
    {
    	if ( $row['parentid'] == $parentid )
    	{
	        $row['class'] = ( $a % 2 ) ? " class=\"second\"" : "";
	        $row['sinhome'] = drawselect_status( "inhome", $array_inhome, $row['inhome'],"ChangeActiveCat(this,".$row['catid'].",'active')" );
	        $row['sweight'] = drawselect_number( "weight", 1, $num-1, $row['weight'],"ChangeActiveCat(this,".$row['catid'].",'weight')" );
	        $row['snumlinks'] = drawselect_number( "numlinks", 1, 50, $row['numlinks'],"ChangeActiveCat(this,".$row['catid'].",'numlinks')" );
	        $row['sviewcat'] = drawselect_status( "viewcat", $array_viewcat, $row['viewcat'],"ChangeActiveCat(this,".$row['catid'].",'viewcat')" );
	        $row['edit'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;parentid=" . $row['parentid']."&amp;catid=" . $row['catid'];
	        $row['del'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat_action&amp;ac=del&amp;catid=" . $row['catid'];
	        $row['add'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;catid=" . $row['catid'];
	        $row['linkparent'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;parentid=" . $row['catid'];
	        $xtpl->assign( 'ROW', $row );
	        $xtpl->parse( 'main.list.loop' );
    	}
    }
    $xtpl->parse( 'main.list' );
}
/**
 * end: listview data 
 */

/** 
 * view form data
 */
if ( ! empty( $error ) )
{
    $xtpl->assign( 'ERROR', $error );
    $xtpl->parse( 'main.form.error' );
}
foreach ( $global_array_cat as $catid_i => $array_value )
{
	if ( $catid_i != $catid )
	{
	    $xtitle_i = "";
	    if ( $array_value['lev'] > 0 )
	    {
	        $xtitle_i .= "&nbsp;&nbsp;&nbsp;|";
	        for ( $i = 1; $i <= $array_value['lev']; $i ++ )
	        {
	            $xtitle_i .= "---";
	        }
	        $xtitle_i .= "&nbsp;";
	    }
	    $select = ( $catid_i == $parentid ) ? 'selected="selected"' : '';
	    $array_cat = array( "xtitle"=> $xtitle_i.$array_value['title'], "catid"=>$catid_i,"select"=>$select);
	    $xtpl->assign( 'ROW', $array_cat );
	    $xtpl->parse( 'main.form.catlist' );
	}
}
if ( empty( $data['alias'] ) )
{
    $xtpl->parse( 'main.form.getalias' );
}
//$array_who_view
//$xtpl->assign( 'who_views', drawselect_status( "who_view", $array_who_view, $data['who_view'],'show_group()' ) );
//$groups_list

if (!empty($groups_list))
{
	$groups_view = explode( ",", $data['groups_view'] );
	foreach ( $groups_list as $groups_id=> $groups_title )
	{
		$check = "";
		if ( in_array($groups_id, $groups_view) )
		{
			$check = 'checked="checked"';
		}
		$data_temp = array( "value"=> $groups_id, "title"=> $groups_title ,"check"=>$check);
	    $xtpl->assign( 'groups_views', $data_temp );
	    $xtpl->parse( 'main.form.groups_views' );
	}
}
$xtpl->assign( 'hidediv', $data['who_view'] == 3 ? "visibility:visible" : "visibility:hidden" );
$xtpl->assign( 'DATA', $data );
$xtpl->parse( 'main.form' );


$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['cat'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';