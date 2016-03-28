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
$ac = $nv_Request->get_string( 'ac', 'get', '' );
$catid = $nv_Request->get_int( 'catid', 'get,post', 0 );
//action delete
if ( $ac == 'del' )
{
	if ( $catid == 0 ) die( 'stop!!' );
	$page_title = $lang_module['del_cat'];
    $data = array();
    if ( $catid > 0 )
    {
        if ( empty( $global_array_cat[$catid] ) ) die( 'stop!!' );
        else 
        {
        	$data = $global_array_cat[$catid];
        }
    }
    //action data
    if ( $nv_Request->get_int( 'del', 'post', 0 ) == 1 )
    {
        $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE catid = '" . intval( $catid ) . "'";
        $result = $db->query( $sql );
        nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['del_cat'], $data['title'], $admin_info['userid'] );
        nv_fix_cat_order();
        $nv_Cache->delMod( $module_name );
        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat&parentid=" . $data['parentid'] . "" );
        die();
    }
	if ( $nv_Request->get_int( 'delcatall', 'post', 0 ) == 1 )
    {
        $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE catid = '" . intval( $catid ) . "'";
        $result = $db->query( $sql );
        $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE catid = '" . intval( $catid ) . "'";
        $result = $db->query( $sql );
        nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['del_cat'], $data['title'], $admin_info['userid'] );
        nv_fix_cat_order();
        $nv_Cache->delMod( $module_name );
        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat&parentid=" . $data['parentid'] . "" );
        die();
    }
	if ( $nv_Request->get_int( 'delcatmove', 'post', 0 ) == 1 )
    {
    	$catidn = $nv_Request->get_int( 'catid', 'post', 0 );
    	if ( $catidn > 0 )
    	{
	        $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE catid = '" . intval( $catid ) . "'";
	        $result = $db->query( $sql );
	        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET catid =".$catidn." WHERE catid = '" . intval( $catid ) . "'";
	        $result = $db->query( $sql );
	        nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['del_cat'], $data['title'], $admin_info['userid'] );
	        nv_fix_cat_order();
	        nv_fix_cat_row ( $catidn );
	        $nv_Cache->delMod( $module_name );
	        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat&parentid=" . $data['parentid'] . "" );
	        die();
    	}
    }
    //view data
    $xtpl = new XTemplate( "cat.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    if ( $data['numsubcat'] > 0 )
    {
        $title_value = sprintf( $lang_module['cat_del_title'], $data['title'], $data['numsubcat'] );
        $xtpl->assign( 'PURL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;parentid=" . $data['catid'] );
        $xtpl->assign( 'TITLE', $title_value );
        $xtpl->parse( 'catdel.subcat' );
    }
    elseif ( $data['numsubcat'] == 0 )
    {
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE catid = '" . $catid . "'";
        $result = $db->query( $sql );
        $numrow = $result->rowCount();
        if ( $numrow == 0 )
        {
            $title_value = sprintf( $lang_module['cat_del_title1'], $data['title'] );
            $xtpl->assign( 'TITLE', $title_value );
            $xtpl->assign( 'PURL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;parentid=" . $data['parentid'] );
            $xtpl->parse( 'catdel.nonecat' );
        }
        else
        {
            $title_value = sprintf( $lang_module['cat_del_title2'], $data['title'], $numrow );
            $xtpl->assign( 'TITLE', $title_value );
            $title_value = sprintf( $lang_module['type_del_title1'], $data['title'], $numrow );
            $xtpl->assign( 'TITLE1', $title_value );
            $title_value = sprintf( $lang_module['type_del_title2'], $data['title'], $numrow );
            $xtpl->assign( 'TITLE2', $title_value );
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
				    $select = '';
				    $array_cat = array( "xtitle"=> $xtitle_i.$array_value['title'], "catid"=>$catid_i,"select"=>$select);
				    $xtpl->assign( 'ROW', $array_cat );
				    $xtpl->parse( 'catdel.havecat.catlist' );
				}
			}
            $xtpl->assign( 'PURL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;parentid=" . $data['parentid'] );
            $xtpl->parse( 'catdel.havecat' );
        }
    }
    $xtpl->parse( 'catdel' );
    $contents .= $xtpl->text( 'catdel' );
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_admin_theme( $contents );
    include ( NV_ROOTDIR . "/includes/footer.php" );
    exit();
}
elseif ( $ac == 'active' )
{
	$value = $nv_Request->get_int( 'value', 'post', 0 );
	$catid = $nv_Request->get_int( 'catid', 'post', 0 );
	$sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET inhome =".$value." WHERE catid = '" . intval( $catid ) . "'";
    $result = $db->query( $sql );
    nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['active_cat'], $value, $admin_info['userid'] );
}
elseif ( $ac == 'weight' )
{
	$value = $nv_Request->get_int( 'value', 'post', 0 );
	$catid = $nv_Request->get_int( 'catid', 'post', 0 );
	$data = array();
    if ( $catid > 0 )
    {
        if ( empty( $global_array_cat[$catid] ) ) die( 'stop!!' );
        else 
        {
        	$data = $global_array_cat[$catid];
        }
    }
	$query = "SELECT catid FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE catid!=" . $catid . " AND parentid=" . $data['parentid'] . " ORDER BY weight ASC";
    $result = $db->query( $query );
    $weight = 0;
    while ( $row = $result->fetch() )
    {
        $weight ++;
        if ( $weight == $value ) $weight ++;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET weight=" . $weight . " WHERE catid=" . intval( $row['catid'] );
        $db->query( $sql );
    }
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET weight=" . $value . " WHERE catid=" . intval( $catid );
    $db->query( $sql );
    nv_fix_cat_order();
    nv_insert_logs( NV_LANG_DATA, $module_name, 'change weight', $value, $admin_info['userid'] );
    die($data['parentid']);
}
elseif ( $ac == 'numlinks' )
{
	$value = $nv_Request->get_int( 'value', 'post', 0 );
	$catid = $nv_Request->get_int( 'catid', 'post', 0 );
	$sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET numlinks =".$value." WHERE catid = '" . intval( $catid ) . "'";
    $result = $db->query( $sql );
    nv_insert_logs( NV_LANG_DATA, $module_name, 'change numlinks', $value, $admin_info['userid'] );
}
elseif ( $ac == 'viewcat' )
{
	$value = $nv_Request->get_string( 'value', 'post', 0 );
	$catid = $nv_Request->get_int( 'catid', 'post', 0 );
	$sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET viewcat ='".$value."' WHERE catid = '" . intval( $catid ) . "'";
    $result = $db->query( $sql );
    nv_insert_logs( NV_LANG_DATA, $module_name, 'change viewcat', $value, $admin_info['userid'] );
}
