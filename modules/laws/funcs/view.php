<?php

/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 29 May 2015 07:49:53 GMT
 */

if ( ! defined( 'NV_IS_MOD_ARCHIVES' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$id = 0;
if ( ! empty( $array_op[1] ) )
{
    $temp = explode( '-', $array_op[1] );
    if ( ! empty( $temp ) )
    {
        $id = intval( end( $temp ) );
    }
}
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id = '" . $id . "' AND status=1 ";
$result = $db->query( $sql );
$data_content = $result->fetch();
if ( empty($data_content) ) die('stop!!');

$sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET view=view+1 WHERE id = '" . $id . "'";
$result = $db->query( $sql );

if ( $data_content['signtime'] > 0 ) $data_content['signtime'] = date("d/m/Y",$data_content['signtime']);
else  $data_content['signtime'] = "";
$data_content['cat_title'] = isset($global_archives_cat[$data_content['catid']])? $global_archives_cat[$data_content['catid']]['title'] : "";
$data_content['room_title'] = isset($global_archives_room[$data_content['roomid']])? $global_archives_room[$data_content['roomid']]['title'] : "";
$data_content['field_title'] = isset($global_archives_field[$data_content['fieldid']])? $global_archives_field[$data_content['fieldid']]['title'] : "";
$data_content['organ_title'] = isset($global_archives_organ[$data_content['organid']])? $global_archives_organ[$data_content['organid']]['title'] : "";

$data_content['cat_link'] = isset($global_archives_cat[$data_content['catid']])? $global_archives_cat[$data_content['catid']]['link'] : "";
$data_content['room_link'] = isset($global_archives_room[$data_content['roomid']])? $global_archives_room[$data_content['roomid']]['link'] : "";
$data_content['field_link'] = isset($global_archives_field[$data_content['fieldid']])? $global_archives_field[$data_content['fieldid']]['link'] : "";
$data_content['organ_link'] = isset($global_archives_organ[$data_content['organid']])? $global_archives_organ[$data_content['organid']]['link'] : "";
$array_type = array( 
  0 => $lang_module['nonecontent'], 1 => $lang_module['incontent'], 2 => $lang_module['outcontent'] 
);
$data_content['linkdown'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=down/" . $data_content['alias']."-".$data_content['id'];
$data_content['type_title'] = $array_type[$data_content['type']];

$catid = $data_content['catid'];
$top_contents = "";
if ( $global_archives_cat[$catid]['parentid'] > 0 )
{
    $parentid_i = $global_archives_cat[$catid]['parentid'];
    $array_cat_title = array();
    while ( $parentid_i > 0 )
    {
        $array_cat_title[] = $cur_link = "<a href=\"".$global_archives_cat[$parentid_i]['link']."\">" . $global_archives_cat[$parentid_i]['title'] . "</a>";
        $parentid_i = $global_archives_cat[$parentid_i]['parentid'];
    }
    sort( $array_cat_title, SORT_NUMERIC );
    $top_contents = implode( " -> ", $array_cat_title );
}
$lik = ( empty($top_contents) )? "": " - ";
$cur_link = "<a href=\"".$global_archives_cat[$catid]['link']."\">" . $global_archives_cat[$catid]['title'] . "</a>";
$top_contents = "<div class=\"archives_links\">".$top_contents.$lik.$cur_link."</div>";

$contents = $top_contents.view_archives($data_content);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
