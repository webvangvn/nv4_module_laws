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
$fieldid = $nv_Request->get_int( 'fieldid', 'get,post', 0 );
//action delete
if ( $ac == 'del' )
{
	if ( $fieldid == 0 ) die( 'stop!!' );
	$page_title = $lang_module['del_field'];
    $data = array();
    if ( $fieldid > 0 )
    {
        if ( empty( $global_array_field[$fieldid] ) ) die( 'stop!!' );
        else 
        {
        	$data = $global_array_field[$fieldid];
        }
    }
    //action data
    if ( $nv_Request->get_int( 'del', 'post', 0 ) == 1 )
    {
        $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_field WHERE fieldid = '" . intval( $fieldid ) . "'";
        $result = $db->query( $sql );
        nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['del_field'], $data['title'], $admin_info['userid'] );
        nv_fix_field_order();
        nv_del_moduleCache( $module_name );
        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=field&parentid=" . $data['parentid'] . "" );
        die();
    }
    //view data
    $xtpl = new XTemplate( "field.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    if ( $data['numsubfield'] > 0 )
    {
        $title_value = sprintf( $lang_module['field_del_title'], $data['title'], $data['numsubfield'] );
        $xtpl->assign( 'PURL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=field&amp;parentid=" . $data['fieldid'] );
        $xtpl->assign( 'TITLE', $title_value );
        $xtpl->parse( 'fielddel.subfield' );
    }
    elseif ( $data['numsubfield'] == 0 )
    {
        $title_value = sprintf( $lang_module['field_del_title1'], $data['title'] );
        $xtpl->assign( 'TITLE', $title_value );
        $xtpl->assign( 'PURL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=field&amp;parentid=" . $data['parentid'] );
        $xtpl->parse( 'fielddel.nonefield' );
    }
    $xtpl->parse( 'fielddel' );
    $contents .= $xtpl->text( 'fielddel' );
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_admin_theme( $contents );
    include ( NV_ROOTDIR . "/includes/footer.php" );
    exit();
}
elseif ( $ac == 'weight' )
{
	$value = $nv_Request->get_int( 'value', 'post', 0 );
	$fieldid = $nv_Request->get_int( 'fieldid', 'post', 0 );
	$data = array();
    if ( $fieldid > 0 )
    {
        if ( empty( $global_array_field[$fieldid] ) ) die( 'stop!!' );
        else 
        {
        	$data = $global_array_field[$fieldid];
        }
    }
	$query = "SELECT fieldid FROM " . NV_PREFIXLANG . "_" . $module_data . "_field WHERE fieldid!=" . $fieldid . " AND parentid=" . $data['parentid'] . " ORDER BY weight ASC";
    $result = $db->query( $query );
    $weight = 0;
    while ( $row = $result->fetch() )
    {
        $weight ++;
        if ( $weight == $value ) $weight ++;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_field SET weight='" . $weight . "' WHERE fieldid='" . intval( $row['fieldid'] )."'";
        $db->query( $sql );
    }
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_field SET weight='" . $value . "' WHERE fieldid='" . intval( $fieldid )."'";
    $db->query( $sql );
    nv_fix_field_order();
    nv_insert_logs( NV_LANG_DATA, $module_name, 'change weight', $value, $admin_info['userid'] );
    die($data['parentid']);
}