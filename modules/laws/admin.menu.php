<?php

/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 29 May 2015 07:49:53 GMT
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );

$submenu['content'] = $lang_module['content'];
$submenu['cat'] = $lang_module['cat'];
$submenu['field'] = $lang_module['field'];
$submenu['organ'] = $lang_module['organ'];
$submenu['room'] = $lang_module['room'];
$submenu['config'] = $lang_module['config'];
$allow_func = array( 'main', 'config', 'alias', 'cat', 'cat_action', 'content', 'field', 'field_action', 'organ', 'organ_action', 'room', 'room_action');
