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
$roomid = $nv_Request->get_int( 'roomid', 'get,post', 0 );
//action delete
if ( $ac == 'del' )
{
	if ( $roomid == 0 ) die( 'stop!!' );
	$page_title = $lang_module['del_room'];
    $data = array();
    if ( $roomid > 0 )
    {
        if ( empty( $global_array_room[$roomid] ) ) die( 'stop!!' );
        else 
        {
        	$data = $global_array_room[$roomid];
        }
    }
    //action data
    if ( $nv_Request->get_int( 'del', 'post', 0 ) == 1 )
    {
        $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_room WHERE roomid = '" . intval( $roomid ) . "'";
        $result = $db->query( $sql );
        nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['del_room'], $data['title'], $admin_info['userid'] );
        nv_fix_room_order();
        nv_del_moduleCache( $module_name );
        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=room&parentid=" . $data['parentid'] . "" );
        die();
    }
    //view data
    $xtpl = new XTemplate( "room.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    if ( $data['numsubroom'] > 0 )
    {
        $title_value = sprintf( $lang_module['room_del_title'], $data['title'], $data['numsubroom'] );
        $xtpl->assign( 'PURL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room&amp;parentid=" . $data['roomid'] );
        $xtpl->assign( 'TITLE', $title_value );
        $xtpl->parse( 'roomdel.subroom' );
    }
    elseif ( $data['numsubroom'] == 0 )
    {
        $title_value = sprintf( $lang_module['room_del_title1'], $data['title'] );
        $xtpl->assign( 'TITLE', $title_value );
        $xtpl->assign( 'PURL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room&amp;parentid=" . $data['parentid'] );
        $xtpl->parse( 'roomdel.noneroom' );
    }
    $xtpl->parse( 'roomdel' );
    $contents .= $xtpl->text( 'roomdel' );
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_admin_theme( $contents );
    include ( NV_ROOTDIR . "/includes/footer.php" );
    exit();
}
elseif ( $ac == 'weight' )
{
	$value = $nv_Request->get_int( 'value', 'post', 0 );
	$roomid = $nv_Request->get_int( 'roomid', 'post', 0 );
	$data = array();
    if ( $roomid > 0 )
    {
        if ( empty( $global_array_room[$roomid] ) ) die( 'stop!!' );
        else 
        {
        	$data = $global_array_room[$roomid];
        }
    }
	$query = "SELECT roomid FROM " . NV_PREFIXLANG . "_" . $module_data . "_room WHERE roomid!=" . $roomid . " AND parentid=" . $data['parentid'] . " ORDER BY weight ASC";
    $result = $db->query( $query );
    $weight = 0;
    while ( $row = $result->fetch() )
    {
        $weight ++;
        if ( $weight == $value ) $weight ++;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_room SET weight='" . $weight . "' WHERE roomid='" . intval( $row['roomid'] )."'";
        $db->query( $sql );
    }
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_room SET weight='" . $value . "' WHERE roomid='" . intval( $roomid )."'";
    $db->query( $sql );
    nv_fix_room_order();
    nv_insert_logs( NV_LANG_DATA, $module_name, 'change weight', $value, $admin_info['userid'] );
    die($data['parentid']);
}