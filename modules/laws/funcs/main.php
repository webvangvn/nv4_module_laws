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

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$base_url_rewrite = nv_url_rewrite($base_url, true);
$page_url_rewrite = ($page > 1) ? nv_url_rewrite($base_url . '/page-' . $page, true) : $base_url_rewrite;
$request_uri = $_SERVER['REQUEST_URI'];
if (! ($home or $request_uri == $base_url_rewrite or $request_uri == $page_url_rewrite or NV_MAIN_DOMAIN . $request_uri == $base_url_rewrite or NV_MAIN_DOMAIN . $request_uri == $page_url_rewrite)) {
    $redirect = '<meta http-equiv="Refresh" content="3;URL=' . $base_url_rewrite . '" />';
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect, 404);
}
if ( $data_config['view_type'] == "view_listall")
{
	$order_by = 'addtime DESC';
	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
		->where( 'status= 1' );
	$num_items = $db->query( $db->sql() )->fetchColumn();
	$db->select( '*' )
			->order( $order_by )
			->limit( $per_page )
			->offset( ( $page - 1 ) * $per_page );
	$result = $db->query( $db->sql() );
	$data_content = array();
	$i = 1;
	while( $row = $result->fetch() )
	{
		$row['no'] = $i;
		$data_content[] = $row;
		$i ++;
	}

	$html_pages = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
	$contents = call_user_func( $data_config['view_type'],$data_content,$html_pages);
}
elseif ( $data_config['view_type'] == "view_listcate") 
{

	$data_content = array();
	foreach ( $global_archives_cat as $catid_i => $catinfo_i)	
	{
		if ( $catinfo_i['parentid'] == 0 and $catinfo_i['inhome'] == '1' )
        {
			$order_by = 'id DESC';
			$db->sqlreset()
				->select( 'COUNT(*)' )
				->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
				->where( 'catid='.$catid_i.' AND status= 1' );
			$num_items = $db->query( $db->sql() )->fetchColumn();
			$db->select( '*' )
					->order( $order_by )
					->limit( $catinfo_i['numlinks'] )
					->offset( ( $page - 1 ) * $per_page );
			$result = $db->query( $db->sql() );
            $all_page = ( $num_items ) ? $num_items : 1;
            $data_content_temp = array();
            $i = 1;
            while ( $row = $result->fetch() )
            {
                $row['no'] = $i;
                $data_content_temp[] = $row;
                $i ++;
            }
            $data_content[] = array( 
                "catinfo" => $catinfo_i, "data" => $data_content_temp 
            );
        }
    }
	
    $contents = call_user_func( $data_config['view_type'], $data_content, "" );
}
else $contents = "";
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
