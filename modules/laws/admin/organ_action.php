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
$organid = $nv_Request->get_int( 'organid', 'get,post', 0 );
//action delete
if ( $ac == 'del' )
{
	if ( $organid == 0 ) die( 'stop!!' );
	$page_title = $lang_module['del_organ'];
    $data = array();
    if ( $organid > 0 )
    {
        if ( empty( $global_array_organ[$organid] ) ) die( 'stop!!' );
        else 
        {
        	$data = $global_array_organ[$organid];
        }
    }
    //action data
    if ( $nv_Request->get_int( 'del', 'post', 0 ) == 1 )
    {
        $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_organ WHERE organid = '" . intval( $organid ) . "'";
        $result = $db->query( $sql );
        nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['del_organ'], $data['title'], $admin_info['userid'] );
        nv_fix_organ_order();
        $nv_Cache->delMod( $module_name );
        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=organ&parentid=" . $data['parentid'] . "" );
        die();
    }
    //view data
    $xtpl = new XTemplate( "organ.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    if ( $data['numsuborgan'] > 0 )
    {
        $title_value = sprintf( $lang_module['organ_del_title'], $data['title'], $data['numsuborgan'] );
        $xtpl->assign( 'PURL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=organ&amp;parentid=" . $data['organid'] );
        $xtpl->assign( 'TITLE', $title_value );
        $xtpl->parse( 'organdel.suborgan' );
    }
    elseif ( $data['numsuborgan'] == 0 )
    {
        $title_value = sprintf( $lang_module['organ_del_title1'], $data['title'] );
        $xtpl->assign( 'TITLE', $title_value );
        $xtpl->assign( 'PURL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=organ&amp;parentid=" . $data['parentid'] );
        $xtpl->parse( 'organdel.noneorgan' );
    }
    $xtpl->parse( 'organdel' );
    $contents .= $xtpl->text( 'organdel' );
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_admin_theme( $contents );
    include ( NV_ROOTDIR . "/includes/footer.php" );
    exit();
}
elseif ( $ac == 'weight' )
{
	$value = $nv_Request->get_int( 'value', 'post', 0 );
	$organid = $nv_Request->get_int( 'organid', 'post', 0 );
	$data = array();
    if ( $organid > 0 )
    {
        if ( empty( $global_array_organ[$organid] ) ) die( 'stop!!' );
        else 
        {
        	$data = $global_array_organ[$organid];
        }
    }
	$query = "SELECT organid FROM " . NV_PREFIXLANG . "_" . $module_data . "_organ WHERE organid!=" . $organid . " AND parentid=" . $data['parentid'] . " ORDER BY weight ASC";
    $result = $db->query( $query );
    $weight = 0;
    while ( $row = $result->fetch() )
    {
        $weight ++;
        if ( $weight == $value ) $weight ++;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_organ SET weight='" . $weight . "' WHERE organid='" . intval( $row['organid'] )."'";
        $db->query( $sql );
    }
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_organ SET weight='" . $value . "' WHERE organid='" . intval( $organid )."'";
    $db->query( $sql );
    nv_fix_organ_order();
    nv_insert_logs( NV_LANG_DATA, $module_name, 'change weight', $value, $admin_info['userid'] );
    die($data['parentid']);
}