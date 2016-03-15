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

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '/' . $global_archives_cat[$catid]['alias'] . '-' . $catid;
$order_by = 'addtime DESC';
$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
	->where( 'catid='.$catid.' AND status= 1' );

$num_items = $db->query( $db->sql() )->fetchColumn();

$db->select( '*' )
		->order( $order_by )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );

$result = $db->query( $db->sql() );

$all_page = ( $num_items ) ? $num_items : 1;

$data_content = array();
$i = 1;
while ( $row = $result->fetch() )
{
    $row['no'] = $i;
    $data_content[] = $row;
    $i ++;
}

$page_title = isset($global_archives_cat[$catid]['title']) ? $global_archives_cat[$catid]['title'] : $module_info['custom_title'];

$html_pages = nv_archives_page( $base_url, $all_page, $per_page, $page );
$contents = call_user_func( $global_archives_cat[$catid]['viewcat'], $data_content, $html_pages );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
