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

$page_title = $lang_module['config'];
$data = $module_config[$module_name];
$groups_list = nv_groups_list();
$savesetting = $nv_Request->get_int( 'savesetting', 'post', 0 );
$error = "";
if ( $savesetting == 1 )
{
    $data['view_type'] = $nv_Request->get_string( 'view_type', 'post', '' );
    $data['view_num'] = $nv_Request->get_int( 'view_num', 'post', 0 );
    $data['who_upload'] = $nv_Request->get_int( 'who_view', 'post', 0 );
    $data['status'] = $nv_Request->get_int( 'status', 'post', 0 );
    $groups = $nv_Request->get_typed_array( 'groups_view', 'post', 'int', array() );
    $groups = array_intersect( $groups, array_keys( $groups_list ) );
    $data['groups_view'] = implode( ",", $groups );
	
    $sth = $db->prepare("UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = '" . NV_LANG_DATA . "' AND module = :module_name AND config_name = :config_name");
    $sth->bindParam(':module_name', $module_name, PDO::PARAM_STR);
    foreach ($data as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    $nv_Cache->delMod('settings');
    $nv_Cache->delMod($module_name);
	nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['config'], "setting", $admin_info['userid'] );
    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . '=config' );
    die();
}

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );

$xtpl->assign( 'DATA', $data );

$home_view = array( 
    "view_listall" => "", "view_listcate" => "", "view_none" => "" 
);
$home_view[$data['view_type']] = "selected=\"selected\"";
foreach ( $home_view as $type_view => $select )
{
	$row = array( "title"=>$lang_module[$type_view],"select"=>$select,"value"=> $type_view);
    $xtpl->assign( 'ROW', $row );
    $xtpl->parse( 'main.home_view_loop' );
}
$xtpl->assign( 'who_upload', drawselect_status( "who_view", $array_who_view, $data['who_upload'],'show_group()' ) );
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
	    $xtpl->parse( 'main.groups_views' );
	}
}
$check = ( $data['status'] == '1' ) ? "checked=\"checked\"" : "";
$xtpl->assign( 'ck_status', $check );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['config'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';