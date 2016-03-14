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
$top_contents = '';
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

$html_pages = nv_archives_page( $base_url, $all_page, $per_page, $page );
$contents = call_user_func( $global_archives_cat[$catid]['viewcat'], $data_content, $top_contents ,$html_pages );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
