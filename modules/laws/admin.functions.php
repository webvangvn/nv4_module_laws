<?php

/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 29 May 2015 07:49:53 GMT
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );
define( 'NV_IS_FILE_ADMIN', true );
$nv_Cache->delMod( 'settings' );
$nv_Cache->delMod( $module_name );

global $global_array_cat;
$global_array_cat = array();
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat ORDER BY orders ASC";
$result = $db->query( $sql );
while ( $row = $result->fetch() )
{
    $global_array_cat[$row['catid']] = $row;
}
$array_who_view = array( 
    0 => $lang_module['who_view0'], 1 => $lang_module['who_view1'], 2 => $lang_module['who_view2'], 3 => $lang_module['who_view3'] 
);
/****/
$admin_id = $admin_info['admin_id'];
/****/
global $global_array_room;
$global_array_room = array();
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_room ORDER BY orders ASC";
$result = $db->query( $sql );
while ( $row = $result->fetch() )
{
    $global_array_room[$row['roomid']] = $row;
}
//**//
global $global_array_field;
$global_array_field = array();
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_field ORDER BY orders ASC";
$result = $db->query( $sql );
while ( $row = $result->fetch() )
{
    $global_array_field[$row['fieldid']] = $row;
}

//**//
global $global_array_organ;
$global_array_organ = array();
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_organ ORDER BY orders ASC";
$result = $db->query( $sql );
while ( $row = $result->fetch() )
{
    $global_array_organ[$row['organid']] = $row;
}

//**//
function nv_fix_cat_order ( $parentid = 0, $order = 0, $lev = 0 )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT catid, parentid FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE parentid=" . $parentid . " ORDER BY weight ASC";
    $result = $db->query( $query );
    $array_cat_order = array();
    while ( $row = $result->fetch() )
    {
        $array_cat_order[] = $row['catid'];
    }
    $db->sqlreset();
    $weight = 0;
    if ( $parentid > 0 )
    {
        $lev ++;
    }
    else
    {
        $lev = 0;
    }
    foreach ( $array_cat_order as $catid_i )
    {
        $order ++;
        $weight ++;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET weight=" . $weight . ", orders=" . $order . ", lev='" . $lev . "' WHERE catid=" . intval( $catid_i );
        $db->query( $sql );
        $order = nv_fix_cat_order( $catid_i, $order, $lev );
    }
    $numsubcat = $weight;
    if ( $parentid > 0 )
    {
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET numsubcat=" . $numsubcat;
        if ( $numsubcat == 0 )
        {
            $sql .= ",subcatid=''";
        }
        else
        {
            $sql .= ",subcatid='" . implode( ",", $array_cat_order ) . "'";
        }
        $sql .= " WHERE catid=" . intval( $parentid );
        $db->query( $sql );
    }
    return $order;
}

function nv_fix_cat_row ( $catid = 0 )
{
    global $db, $db_config, $module_name, $module_data;
    $query = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE catid='" . $catid . "' AND status=1";
    $result = $db->query( $query );
    $num  = $result->rowCount();
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET numrow='" . $num . "' WHERE catid='" . intval( $catid )."'";
    $db->query( $sql );

}
function nv_fix_catall_row ( )
{
    global $global_array_cat;
    foreach ( $global_array_cat as $catid_i=>$catinfo_i)
    {
    	nv_fix_cat_row ( $catid_i );
    }
}
function nv_fix_room_order ( $parentid = 0, $order = 0, $lev = 0 )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT roomid, parentid FROM " . NV_PREFIXLANG . "_" . $module_data . "_room WHERE parentid='" . $parentid . "' ORDER BY weight ASC";
    $result = $db->query( $query );
    $array_room_order = array();
    while ( $row = $result->fetch() )
    {
        $array_room_order[] = $row['roomid'];
    }
    $db->sqlreset();
    $weight = 0;
    if ( $parentid > 0 )
    {
        $lev ++;
    }
    else
    {
        $lev = 0;
    }
    foreach ( $array_room_order as $roomid_i )
    {
        $order ++;
        $weight ++;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_room SET weight='" . $weight . "', orders='" . $order . "', lev='" . $lev . "' WHERE roomid='" . intval( $roomid_i )."'";
        $db->query( $sql );
        $order = nv_fix_room_order( $roomid_i, $order, $lev );
    }
    $numsubroom = $weight;
    if ( $parentid > 0 )
    {
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_room SET numsubroom='" . $numsubroom."'";
        if ( $numsubroom == 0 )
        {
            $sql .= ",subroomid=''";
        }
        else
        {
            $sql .= ",subroomid='" . implode( ",", $array_room_order ) . "'";
        }
        $sql .= " WHERE roomid='" . intval( $parentid )."'";
        $db->query( $sql );
    }
    return $order;
}

function nv_fix_field_order ( $parentid = 0, $order = 0, $lev = 0 )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT fieldid, parentid FROM " . NV_PREFIXLANG . "_" . $module_data . "_field WHERE parentid='" . $parentid . "' ORDER BY weight ASC";
    $result = $db->query( $query );
    $array_field_order = array();
    while ( $row = $result->fetch() )
    {
        $array_field_order[] = $row['fieldid'];
    }
    $db->sqlreset();
    $weight = 0;
    if ( $parentid > 0 )
    {
        $lev ++;
    }
    else
    {
        $lev = 0;
    }
    foreach ( $array_field_order as $fieldid_i )
    {
        $order ++;
        $weight ++;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_field SET weight='" . $weight . "', orders='" . $order . "', lev='" . $lev . "' WHERE fieldid='" . intval( $fieldid_i )."'";
        $db->query( $sql );
        $order = nv_fix_field_order( $fieldid_i, $order, $lev );
    }
    $numsubfield = $weight;
    if ( $parentid > 0 )
    {
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_field SET numsubfield='" . $numsubfield."'";
        if ( $numsubfield == 0 )
        {
            $sql .= ",subfieldid=''";
        }
        else
        {
            $sql .= ",subfieldid='" . implode( ",", $array_field_order ) . "'";
        }
        $sql .= " WHERE fieldid='" . intval( $parentid )."'";
        $db->query( $sql );
    }
    return $order;
}
function nv_fix_organ_order ( $parentid = 0, $order = 0, $lev = 0 )
{
    global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data, $op;
    $query = "SELECT organid, parentid FROM " . NV_PREFIXLANG . "_" . $module_data . "_organ WHERE parentid='" . $parentid . "' ORDER BY weight ASC";
    $result = $db->query( $query );
    $array_organ_order = array();
    while ( $row = $result->fetch() )
    {
        $array_organ_order[] = $row['organid'];
    }
    $db->sqlreset();
    $weight = 0;
    if ( $parentid > 0 )
    {
        $lev ++;
    }
    else
    {
        $lev = 0;
    }
    foreach ( $array_organ_order as $organid_i )
    {
        $order ++;
        $weight ++;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_organ SET weight='" . $weight . "', orders='" . $order . "', lev='" . $lev . "' WHERE organid='" . intval( $organid_i )."'";
        $db->query( $sql );
        $order = nv_fix_organ_order( $organid_i, $order, $lev );
    }
    $numsuborgan = $weight;
    if ( $parentid > 0 )
    {
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_organ SET numsuborgan='" . $numsuborgan."'";
        if ( $numsuborgan == 0 )
        {
            $sql .= ",suborganid=''";
        }
        else
        {
            $sql .= ",suborganid='" . implode( ",", $array_organ_order ) . "'";
        }
        $sql .= " WHERE organid='" . intval( $parentid )."'";
        $db->query( $sql );
    }
    return $order;
}
///////////////////////
function drawselect_number ( $select_name = "", $number_start = 0, $number_end = 1, $number_curent = 0, $func_onchange = "", $enable = "" )
{
    $html = '<select class="form-control" name="' . $select_name . '" id="id_' . $select_name . '" onchange="' . $func_onchange . '" ' . $enable . '>';
    for ( $i = $number_start; $i <= $number_end; $i ++ )
    {
        $select = ( $i == $number_curent ) ? 'selected="selected"' : '';
        $html .= '<option value="' . $i . '" ' . $select . '>' . $i . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function drawselect_status ( $select_name = "", $array_control_value, $value_curent = 0, $func_onchange = "", $enable = "" )
{
    $html = '<select class="form-control w200" name="' . $select_name . '" id="id_' . $select_name . '" onchange="' . $func_onchange . '" ' . $enable . '>';
    foreach ( $array_control_value as $val => $title )
    {
        $select = ( $val == $value_curent ) ? "selected=\"selected\"" : "";
        $html .= '<option value="' . $val . '" ' . $select . '>' . $title . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function GetCatidInParent ( $catid )
{
    global $global_array_cat;
    $array_cat = array();
    $array_cat[] = $catid;
    $subcatid = explode( ",", $global_array_cat[$catid]['subcatid'] );
    if ( ! empty( $subcatid ) )
    {
        foreach ( $subcatid as $id )
        {
            if ( $id > 0 )
            {
                if ( $global_array_cat[$id]['numsubcat'] == 0 )
                {
                    $array_cat[] = $id;
                }
                else
                {
                    $array_cat_temp = GetCatidInParent( $id );
                    foreach ( $array_cat_temp as $catid_i )
                    {
                        $array_cat[] = $catid_i;
                    }
                }
            }
        }
    }
    return array_unique( $array_cat );
}
/**
 * redirect()
 *
 * @param string $msg1
 * @param string $msg2
 * @param mixed $nv_redirect
 * @return
 */
function redirect($msg1 = '', $msg2 = '', $nv_redirect, $autoSaveKey = '', $go_back = '')
{
    global $global_config, $module_file, $module_name;
    $xtpl = new XTemplate('redirect.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

    if (empty($nv_redirect)) {
        $nv_redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
    }
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('NV_REDIRECT', $nv_redirect);
    $xtpl->assign('MSG1', $msg1);
    $xtpl->assign('MSG2', $msg2);

    if (! empty($autoSaveKey)) {
        $xtpl->assign('AUTOSAVEKEY', $autoSaveKey);
        $xtpl->parse('main.removelocalstorage');
    }

    if ($go_back) {
        $xtpl->parse('main.go_back');
    } else {
        $xtpl->parse('main.meta_refresh');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}
