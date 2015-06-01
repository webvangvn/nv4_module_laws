<?php

/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 29 May 2015 07:49:53 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$title = $nv_Request->get_string( 'title', 'post,get', '' );
$alias = change_alias( $title );
include ( NV_ROOTDIR . "/includes/header.php" );
echo $alias;
include ( NV_ROOTDIR . "/includes/footer.php" );