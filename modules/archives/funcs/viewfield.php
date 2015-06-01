<?php

/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 29 May 2015 07:49:53 GMT
 */

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];
$fieldid = 0;
if ( ! empty( $array_op[1] ) )
{
    $temp = explode( '-', $array_op[1] );
    if ( ! empty( $temp ) )
    {
        $fieldid = intval( end( $temp ) );
    }
}
if ( empty( $global_archives_field[$fieldid] ) ) die( 'Stop!!!' );
$page = 1;
if ( ! empty( $array_op[2] ) )
{
    $temp = explode( '-', $array_op[2] );
    if ( ! empty( $temp ) )
    {
        $page = intval( end( $temp ) );
    }
}
$base_url = "" . NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "/".$global_archives_field[$fieldid]['alias']."-".$fieldid;
$order_by = 'id DESC';
$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
	->where( 'fieldid='.$fieldid.' AND status= 1' );

$num_items = $db->query( $db->sql() )->fetchColumn();

$db->select( '*' )
		->order( $order_by )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );

$result = $db->query( $db->sql() );

$all_page = ( $num_items ) ? $num_items : 1;

$data_content = array();
$i = $page + 1;
while ( $row = $result->fetch() )
{
    $row['no'] = $i;
    $data_content[] = $row;
    $i ++;
}
$top_contents = "";
if ( $global_archives_field[$fieldid]['parentid'] > 0 )
{
    $parentid_i = $global_archives_field[$fieldid]['parentid'];
    $array_field_title = array();
    while ( $parentid_i > 0 )
    {
        $array_field_title[] = $cur_link = "<a href=\"".$global_archives_field[$parentid_i]['link']."\">" . $global_archives_field[$parentid_i]['title'] . "</a>";
        $parentid_i = $global_archives_field[$parentid_i]['parentid'];
    }
    sort( $array_field_title, SORT_NUMERIC );
    $top_contents = implode( " -> ", $array_field_title );
}
$lik = ( empty($top_contents) )? "": " - ";
$cur_link = "<a href=\"".$global_archives_field[$fieldid]['link']."\">" . $global_archives_field[$fieldid]['title'] . "</a>";
$top_contents = "<div class=\"archives_links\">".$top_contents.$lik.$cur_link."</div>";

$html_pages = nv_archives_page( $base_url, $all_page, $per_page, $page );
$contents = viewcat_list( $data_content, $top_contents ,$html_pages );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
