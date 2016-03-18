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
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id = '. $id;
$result = $db->query( $sql );
$data_content = $result->fetch();
if ( empty( $data_content ) ) die( 'Stop!!' );


if ( ! empty( $data_content['filepath'] ) and file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $data_content['filepath'] ) )
{
	$_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET down=down+1 WHERE id = '. $id;
	$result = $db->query( $_sql );

    $file_basename = $data_content['filepath'];
	$data_content['filepath'] = NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $data_content['filepath'];
    $directory = NV_UPLOADS_REAL_DIR;
	$download = new NukeViet\Files\Download( $data_content['filepath'], $directory, $file_basename );
	$download->download_file();
	exit();
}
elseif (!empty($data_content['otherpath'])) 
{
	$_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET down=down+1 WHERE id = '. $id;
	$result = $db->query( $_sql );
	
	Header( "Location: ".$data_content['otherpath'] );
	die();
}
else {
	$base_url_rewrite = nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_archives_cat[$data_content['catid']]['alias'] . '/' . $data_content['alias'] . '-' . $data_content['id'] . $global_config['rewrite_exturl'], true );
    $redirect = '<meta http-equiv="Refresh" content="5;URL=' . $base_url_rewrite . '" />';
    nv_info_die($lang_module['doc_no_file_title'], $lang_module['doc_no_file_title'], $lang_module['doc_no_file'] . $redirect, 404);
	die();
}
