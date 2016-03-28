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
$key_words = $module_info['keywords'];

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_archives_cat[$catid]['alias'];
$base_url_rewrite = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_archives_cat[$catid]['alias'];

if ($page > 1) {
    $base_url_rewrite .= '/page-' . $page;
}

$base_url_rewrite = nv_url_rewrite($base_url_rewrite, true);
if ($_SERVER['REQUEST_URI'] != $base_url_rewrite and NV_MAIN_DOMAIN . $_SERVER['REQUEST_URI'] != $base_url_rewrite) {
    Header('Location: ' . $base_url_rewrite);
    die();
}

$order_by = 'addtime DESC';
$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
	->where( 'catid = ' . $catid . ' AND status= 1' );

$num_items = $db->query( $db->sql() )->fetchColumn();
$db->select( '*' )
		->order( $order_by )
		->limit($per_page)
		->offset(($page - 1) * $per_page);

$result = $db->query( $db->sql() );

$data_content = array();
$i = 1;
if ($page > 1) $i = 1 + (( $page - 1 ) * $per_page);
while ( $row = $result->fetch() )
{
    $row['no'] = $i;
    $data_content[] = $row;
	++$i;
}

$page_title = isset($global_archives_cat[$catid]['title']) ? $global_archives_cat[$catid]['title'] : $module_info['custom_title'];

$html_pages = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
$contents = call_user_func( $global_archives_cat[$catid]['viewcat'], $data_content, $html_pages );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
