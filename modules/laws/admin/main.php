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

/*action del row*/
$ac = $nv_Request->get_string( 'ac', 'get', 0 );
if ($ac=='del')
{
	$id = $nv_Request->get_int( 'id', 'get', 0 );
	$sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id = '" . intval( $id ) . "'";
    $result = $db->query( $sql );
    $nv_Cache->delMod( $module_name );
    nv_fix_catall_row ();
    die($lang_module['del_complate']);
}
elseif ($ac=='delall')
{
	$listall = $nv_Request->get_string( 'listall', 'post,get' );
    if (!empty($listall))
    {
    	$sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id IN (" . $listall . ")";
	    $result = $db->query( $sql );
    	$nv_Cache->delMod( $module_name );
    	nv_fix_catall_row ();
    	die($lang_module['del_complate']);
    }
    die('no!!');
}
/*********/
$page_title = $lang_module['main'];
$catid = $nv_Request->get_int( 'catid', 'get', 0 );
$roomid = $nv_Request->get_int( 'roomid', 'get', 0 );
$per_page = $nv_Request->get_int( 'per_page', 'get',50);
$page = $nv_Request->get_int( 'page', 'get', 0 );
$q = $nv_Request->get_string( 'q', 'get', '', 1 );
$ordername = $nv_Request->get_string( 'ordername', 'get', 'id' );
$order = ( $nv_Request->get_string( 'order', 'get' ) == "desc" ) ? 'asc' : 'desc';
$base_url_id = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid ."&q=" . $q . "&ordername=id&order=" . $order . "&page=" . $page;
$base_url_name = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid ."&q=" . $q . "&ordername=title&order=" . $order . "&page=" . $page;
$base_url_room = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid ."&q=" . $q . "&ordername=roomid&order=" . $order . "&page=" . $page;
$back_url = "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid ."&q=" . $q . "&ordername=id&order=" . $order . "&page=" . $page;
$table = "".NV_PREFIXLANG . "_" . $module_data . "_rows";
$arr_status = array(0=>$lang_module['status0'],1=>$lang_module['status1']);
/**
 * begin: formview data 
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
$xtpl->assign( 'base_url_name', $base_url_name );
$xtpl->assign( 'base_url_id', $base_url_id );
$xtpl->assign( 'base_url_room', $base_url_room );
$xtpl->assign( 'q', $q );
$xtpl->assign( 'per_page', $per_page );
$xtpl->assign( 'URLBACK', $back_url );
$xtpl->assign( 'DELALL', "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op."&ac=delall" );
$xtpl->assign( 'ADDCONTENT', "" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=content" );
foreach ( $global_array_cat as $catid_i => $array_value )
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
    $select = ( $catid_i == $catid ) ? 'selected="selected"' : '';
    $array_cat = array( 
        "xtitle" => $xtitle_i . $array_value['title'], "catid" => $catid_i, "select" => $select 
    );
    $xtpl->assign( 'CAT', $array_cat );
    $xtpl->parse( 'main.cloop' );
}
//end: view cat

//begin: listdata
$where = array();
$where_sql="";
if ( $catid > 0 ) $where[] = " catid=".$catid. " "; 
if ( $roomid > 0 ) $where[] = " roomid=".$roomid. " "; 
if ( !empty($q) ) $where[] = " ( title LIKE '%" .  $q  . "%' OR hometext LIKE '%" .  $q  . "%' ) "; 
if ( !empty($where) ) 
{
	$where_sql = " WHERE " . implode(" AND ", $where);
}
$ord_sql = "ORDER BY " . $ordername . " " . $order . "";
$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . $table . " ".$where_sql." " . $ord_sql . " LIMIT " . $page . "," . $per_page;
//die($sql);
$result = $db->query( $sql );

$result_all = $db->query( "SELECT FOUND_ROWS()" );
$numf  = $result->rowCount();
//die($sql);
$all_page = ( $numf ) ? $numf : 1;
$i=1;
while ( $row = $result->fetch() )
{
	$row['bg'] = ($i%2==0)? "class=\"second\"":"";
	$row['cat_title'] = isset( $global_array_cat[$row['catid']]['title'] ) ? $global_array_cat[$row['catid']]['title'] : "";
	$row['cat_link'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $row['catid'] ."&q=" . $q . "&ordername=id&order=" . $order . "&page=" . $page;
	$row['room_title'] = isset( $global_array_room[$row['roomid']]['title'] )? $global_array_room[$row['roomid']]['title'] : "" ;
	$row['room_link'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&roomid=" . $row['roomid'] ."&q=" . $q . "&ordername=id&order=" . $order . "&page=" . $page;
	$row['del'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&ac=del&id=".$row['id'];
	$row['edit'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=content&id=".$row['id'];
	$row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=view/'.$row['alias'].'-'.$row['id'] . $global_config['rewrite_exturl'];
	$row['status'] = $arr_status[$row['status']];
	$xtpl->assign( 'ROW', $row );
    $xtpl->parse( 'main.loop' );
    $i++;
}
//end: listdata
$base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&per_page=" . $per_page . "&catid=" . $catid ."&q=" . $q . "&ordername=".$ordername."&order=" . $order;
$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );
if ( $generate_page != "" ) 
{
	$xtpl->assign( 'generate_page', $generate_page );
	$xtpl->parse( 'main.page' );
}


$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['main'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';