<?php

/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 29 May 2015 07:49:53 GMT
 */

if (! defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

$sql_drop_module = array();
$array_table = array(
    'cat',
    'rows',
    'room',
    'field',
    'organ'
);

$table = $db_config['prefix'] . '_' . $lang . '_' . $module_data;
$result = $db->query('SHOW TABLE STATUS LIKE ' . $db->quote($table . '_%'));
while ($item = $result->fetch()) {
    $name = substr($item['name'], strlen($table) + 1);
    if (preg_match('/^' . $db_config['prefix'] . '\_' . $lang . '\_' . $module_data . '\_/', $item['name']) and (preg_match('/^([0-9]+)$/', $name) or in_array($name, $array_table) or preg_match('/^bodyhtml\_([0-9]+)$/', $name))) {
        $sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $item['name'];
    }
}

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (
	id int(11) unsigned NOT NULL AUTO_INCREMENT,
	catid int(11) NOT NULL DEFAULT '0',
	title text NOT NULL,
	alias varchar(250) NOT NULL,
	hometext text NOT NULL,
	bodytext mediumtext NOT NULL,
	keywords text NOT NULL,
	filepath text NOT NULL,
	otherpath text NOT NULL,
	roomid int(11) NOT NULL DEFAULT '0',
	fieldid int(11) NOT NULL DEFAULT '0',
	addtime int(11) NOT NULL DEFAULT '0',
	edittime int(11) NOT NULL DEFAULT '0',
	down int(8) NOT NULL DEFAULT '0',
	view int(8) NOT NULL DEFAULT '0',
	userid int(11) NOT NULL DEFAULT '0',
	status int(2) NOT NULL DEFAULT '0',
	type int(2) NOT NULL DEFAULT '0',
	sign text NOT NULL,
	pubtime int(11) NOT NULL DEFAULT '0',
	signtime int(11) NOT NULL DEFAULT '0',
	exptime int(11) NOT NULL DEFAULT '0',
	organid int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (id),
	UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (
	catid mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	parentid mediumint(8) unsigned NOT NULL DEFAULT '0',
	title varchar(250) NOT NULL,
	alias varchar(250) NOT NULL DEFAULT '',
	description varchar(250) NOT NULL,
	image varchar(250) NOT NULL DEFAULT '',
	thumbnail varchar(250) NOT NULL DEFAULT '',
	weight smallint(4) unsigned NOT NULL DEFAULT '0',
	orders mediumint(8) NOT NULL DEFAULT '0',
	lev smallint(4) NOT NULL DEFAULT '0',
	viewcat varchar(50) NOT NULL DEFAULT 'viewcat_page_new',
	numsubcat int(11) NOT NULL DEFAULT '0',
	subcatid varchar(250) NOT NULL DEFAULT '',
	inhome tinyint(1) unsigned NOT NULL DEFAULT '0',
	numlinks tinyint(2) unsigned NOT NULL DEFAULT '3',
	keywords mediumtext NOT NULL,
	admins mediumtext NOT NULL,
	add_time int(11) unsigned NOT NULL DEFAULT '0',
	edit_time int(11) unsigned NOT NULL DEFAULT '0',
	del_cache_time int(11) NOT NULL DEFAULT '0',
	who_view tinyint(2) unsigned NOT NULL DEFAULT '0',
	groups_view varchar(250) NOT NULL DEFAULT '',
	numrow int(8) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (catid),
	UNIQUE KEY alias (alias),
	KEY parentid (parentid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_room (
	roomid mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	parentid mediumint(8) unsigned NOT NULL DEFAULT '0',
	title varchar(250) NOT NULL,
	alias varchar(250) NOT NULL DEFAULT '',
	description varchar(250) NOT NULL,
	weight smallint(4) unsigned NOT NULL DEFAULT '0',
	orders mediumint(8) NOT NULL DEFAULT '0',
	lev smallint(4) NOT NULL DEFAULT '0',
	numsubroom int(11) NOT NULL DEFAULT '0',
	subroomid varchar(250) NOT NULL DEFAULT '',
	keywords mediumtext NOT NULL,
	admins mediumtext NOT NULL,
	add_time int(11) unsigned NOT NULL DEFAULT '0',
	edit_time int(11) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (roomid),
	UNIQUE KEY alias (alias),
	KEY parentid (parentid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_field (
	fieldid mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	parentid mediumint(8) unsigned NOT NULL DEFAULT '0',
	title varchar(250) NOT NULL,
	alias varchar(250) NOT NULL DEFAULT '',
	description varchar(250) NOT NULL,
	weight smallint(4) unsigned NOT NULL DEFAULT '0',
	orders mediumint(8) NOT NULL DEFAULT '0',
	lev smallint(4) NOT NULL DEFAULT '0',
	numsubfield int(11) NOT NULL DEFAULT '0',
	subfieldid varchar(250) NOT NULL DEFAULT '',
	keywords mediumtext NOT NULL,
	admins mediumtext NOT NULL,
	add_time int(11) unsigned NOT NULL DEFAULT '0',
	edit_time int(11) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (fieldid),
	UNIQUE KEY alias (alias),
	KEY parentid (parentid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_organ (
	organid mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	parentid mediumint(8) unsigned NOT NULL DEFAULT '0',
	title varchar(250) NOT NULL,
	alias varchar(250) NOT NULL DEFAULT '',
	description varchar(250) NOT NULL,
	weight smallint(4) unsigned NOT NULL DEFAULT '0',
	orders mediumint(8) NOT NULL DEFAULT '0',
	lev smallint(4) NOT NULL DEFAULT '0',
	numsuborgan int(11) NOT NULL DEFAULT '0',
	suborganid varchar(250) NOT NULL DEFAULT '',
	keywords mediumtext NOT NULL,
	admins mediumtext NOT NULL,
	add_time int(11) unsigned NOT NULL DEFAULT '0',
	edit_time int(11) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (organid),
	UNIQUE KEY alias (alias),
	KEY parentid (parentid)
) ENGINE=MyISAM";


$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'view_type', 'view_listall')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'view_num', '30')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'who_upload', '1')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'structure_upload', 'Ym')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'groups_view', '6')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'status', '0')";