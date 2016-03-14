<?php

/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 04 Mar 2016 07:49:53 GMT
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$module_version = array(
	'name' => 'Laws',
	'modfuncs' => 'main,view,viewcat,viewroom,viewfield,vieworgan,search,content,down',
	'change_alias' => 'main,view,viewcat,viewroom,viewfield,vieworgan,search,content,down',
	'submenu' => 'main,view,viewcat,viewroom,viewfield,vieworgan,search,content,down',
	'is_sysmod' => 0,
	'virtual' => 1,
	'version' => '4.0.27',
	'date' => 'Fri, 04 Mar 2016 07:49:54 GMT',
	'author' => 'PCD-GROUP (contact@dinhpc.com)',
    'uploads_dir' => array( $module_upload, $module_upload . '/tmp' ),
	'note' => 'Update to 4.x webvang (hoang.nguyen@webvang.vn)'
);