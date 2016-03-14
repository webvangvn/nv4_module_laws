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

$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET down=down+1 WHERE id = '. $id;

$result = $db->query( $sql );

if ( ! empty( $data_content['filepath'] ) and file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $data_content['filepath'] ) )
{
    $file_basename = $data_content['filepath'];
	$data_content['filepath'] = NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $data_content['filepath'];
    $directory = NV_UPLOADS_REAL_DIR;
	$download = new NukeViet\Files\Download( $data_content['filepath'], $directory, $file_basename );
	$download->download_file();
	exit();
}
elseif (!empty($data_content['otherpath'])) 
{
	 Header( "Location: ".$data_content['otherpath'] );
     die();
}
else { die('no file!!'); }
