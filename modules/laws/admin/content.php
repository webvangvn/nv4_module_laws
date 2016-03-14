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

$page_title = $lang_module['content'];
$error = array();

$username_alias = change_alias($admin_info['username']);
$array_structure_image = array();
$array_structure_image[''] = $module_upload;
$array_structure_image['Y'] = $module_upload . '/' . date('Y');
$array_structure_image['Ym'] = $module_upload . '/' . date('Y_m');
$array_structure_image['Y_m'] = $module_upload . '/' . date('Y/m');
$array_structure_image['Ym_d'] = $module_upload . '/' . date('Y_m/d');
$array_structure_image['Y_m_d'] = $module_upload . '/' . date('Y/m/d');
$array_structure_image['username'] = $module_upload . '/' . $username_alias;

$array_structure_image['username_Y'] = $module_upload . '/' . $username_alias . '/' . date('Y');
$array_structure_image['username_Ym'] = $module_upload . '/' . $username_alias . '/' . date('Y_m');
$array_structure_image['username_Y_m'] = $module_upload . '/' . $username_alias . '/' . date('Y/m');
$array_structure_image['username_Ym_d'] = $module_upload . '/' . $username_alias . '/' . date('Y_m/d');
$array_structure_image['username_Y_m_d'] = $module_upload . '/' . $username_alias . '/' . date('Y/m/d');

$structure_upload = isset($module_config[$module_name]['structure_upload']) ? $module_config[$module_name]['structure_upload'] : 'Ym';
$currentpath = isset($array_structure_image[$structure_upload]) ? $array_structure_image[$structure_upload] : '';

if (file_exists(NV_UPLOADS_REAL_DIR . '/' . $currentpath)) {
    $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $currentpath;
} else {
    $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $module_upload;
    $e = explode('/', $currentpath);
    if (! empty($e)) {
        $cp = '';
        foreach ($e as $p) {
            if (! empty($p) and ! is_dir(NV_UPLOADS_REAL_DIR . '/' . $cp . $p)) {
                $mk = nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $cp, $p);
                if ($mk[0] > 0) {
                    $upload_real_dir_page = $mk[2];
                    try {
                        $db->query("INSERT INTO " . NV_UPLOAD_GLOBALTABLE . "_dir (dirname, time) VALUES ('" . NV_UPLOADS_DIR . "/" . $cp . $p . "', 0)");
                    }
                    catch (PDOException $e) {
                        trigger_error($e->getMessage());
                    }
                }
            } elseif (! empty($p)) {
                $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $cp . $p;
            }
            $cp .= $p . '/';
        }
    }
    $upload_real_dir_page = str_replace('\\', '/', $upload_real_dir_page);
}

$currentpath = str_replace(NV_ROOTDIR . '/', '', $upload_real_dir_page);
$uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload;
if (! defined('NV_IS_SPADMIN') and strpos($structure_upload, 'username') !== false) {
    $array_currentpath = explode('/', $currentpath);
    if ($array_currentpath[2] == $username_alias) {
        $uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload . '/' . $username_alias;
    }
}

if (empty($global_array_cat))
{
	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat" );
	die();
}
if ( defined( 'NV_EDITOR' ) )
{
    require_once ( NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php' );
}
$error = "";
$roomid = $nv_Request->get_int( 'roomid', 'get', 0 );
$catid = $nv_Request->get_int( 'catid', 'get,post', 0 );
$fieldid = $nv_Request->get_int( 'fieldid', 'get', 0 );
$organid = $nv_Request->get_int( 'organid', 'get', 0 );
$id = $nv_Request->get_int( 'id', 'get,post', 0 );
$data = array( 
    'id' => 0,
	'catid' => $catid,
	'title' => '',
	'hometext' => '',
	'bodytext' => '',
	'keywords' => '',
	'filepath' => '',
	'otherpath' => '',
	'roomid' => $roomid,
	'fieldid' => $fieldid,
	'addtime' => NV_CURRENTTIME, 
	'edittime' => NV_CURRENTTIME,
	'down' => 0,
	'view' => 0,
	'userid' => $admin_info['admin_id'], 
	'status' => 1,
	'type' => 0 ,
	'sign'=>'',
	'pubtime'=>NV_CURRENTTIME,
	'signtime'=>NV_CURRENTTIME,
	'exptime'=>'',
	'organid'=>$organid
);

/**
 * begin: post data 
 */
 
if ( $nv_Request->get_int( 'save', 'post' ) == 1 )
{
    $data['catid'] = $nv_Request->get_int( 'catid', 'post', 0 );
    $data['roomid'] = $nv_Request->get_int( 'roomid', 'post', 0 );
    $data['fieldid'] = $nv_Request->get_int( 'fieldid', 'post', 0 );
    $data['type'] = $nv_Request->get_int( 'type', 'post', 0 );
    $data['title'] = $nv_Request->get_string( 'title', 'post', '', 0 );
    $data['keywords'] = $nv_Request->get_string( 'keywords', 'post', '', 1 );
    $alias = $nv_Request->get_string( 'alias', 'post', '' );
    $data['alias'] = ( $alias == "" ) ? change_alias( $data['title'] ) : change_alias( $alias );
    $hometext = $nv_Request->get_string( 'hometext', 'post', '' );
    $data['hometext'] = nv_nl2br( nv_htmlspecialchars( strip_tags( $hometext ) ), '<br />' );
    $data['filepath'] = $nv_Request->get_string( 'filepath', 'post','' );
    $lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_upload . "/" );
    $data['filepath'] = substr( $data['filepath'], $lu );
    $data['otherpath'] = $nv_Request->get_string( 'otherpath', 'post', '');
    $bodytext = $nv_Request->get_string( 'bodytext', 'post', '' );
    $data['bodytext'] = defined( 'NV_EDITOR' ) ? nv_nl2br( $bodytext, '' ) : nv_nl2br( nv_htmlspecialchars( strip_tags( $bodytext ) ), '<br />' );
    $data['sign'] = $nv_Request->get_string( 'sign', 'post', '' );
    $pubtime = $nv_Request->get_string( 'pubtime', 'post', 0 );
    $signtime = $nv_Request->get_string( 'signtime', 'post', 0 );
    $exptime = $nv_Request->get_string( 'exptime', 'post', 0 );
    $data['status'] = $nv_Request->get_int( 'status', 'post', 0 );
    $data['organid'] = $nv_Request->get_int( 'organid', 'post', 0);
    
	//pubtime
    if ( ! empty( $pubtime ) and ! preg_match( '/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/', $pubtime ) ) $pubtime = '';
    if ( empty( $pubtime ) )
    {
        $data['pubtime'] = 0;
    }
    else
    {
        $phour = date( 'H' );
        $pmin = date( 'i' );
        unset( $m );
        preg_match( '/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/', $pubtime, $m );
        $data['pubtime'] = mktime( $phour, $pmin, 0, $m[2], $m[1], $m[3] );
    }
	//signtime
    if ( ! empty( $signtime ) and ! preg_match( '/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/', $signtime ) ) $signtime = '';
    if ( empty( $signtime ) )
    {
        $data['signtime'] = 0;
    }
    else
    {
        $phour = date( 'H' );
        $pmin = date( 'i' );
        unset( $m );
        preg_match( '/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/', $signtime, $m );
        $data['signtime'] = mktime( $phour, $pmin, 0, $m[2], $m[1], $m[3] );
    }
	
	//exptime
    if ( ! empty( $exptime ) and ! preg_match( '/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/', $exptime ) ) $exptime = '';
    if ( empty( $exptime ) )
    {
        $data['exptime'] = 0;
    }
    else
    {
        $phour = date( 'H' );
        $pmin = date( 'i' );
        unset( $m );
        preg_match( '/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/', $exptime, $m );
        $data['exptime'] = mktime( $phour, $pmin, 0, $m[2], $m[1], $m[3] );
		// Thoi gian het han phai lon hon hoac bang thoi gian hieu luc
		if( $data['exptime'] < $data['signtime'] ){
			$data['exptime'] = 0;
		}
    }
	
	if (empty($data['title'])) {
		$error[] = $lang_module['content_title_erorr'];
	} elseif (empty($data['catid'])) {
		$error[] = $lang_module['error_cat'];
	}
    if ( empty( $error ) )
    {
        if ( $id == 0 )
        {
            //insert data
			$sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows
				(catid, title, alias, hometext, bodytext, keywords, filepath,otherpath, roomid,fieldid, addtime, edittime, down, view, userid, status, type,sign,pubtime,signtime,exptime,organid) VALUES
				 (' . intval( $data['catid'] ) . ',
				 :title,
				 :alias,
				 :hometext,
				 :bodytext,
				 :keywords,
				 :filepath,
				 :otherpath,
				 :roomid,
				 :fieldid,
				 ' . intval( $data['addtime'] ) . ',
				 ' . intval( $data['edittime'] ) . ',
				 :down,
				 :view,
				 :userid,
				 ' . intval( $data['status'] ) . ',
				 :type,
				 :sign,
				 :pubtime,
				 :signtime,
				 :exptime,
				 :organid)';

			$data_insert = array();
			$data_insert['title'] = $data['title'];
			$data_insert['alias'] = $data['alias'];
			$data_insert['hometext'] = $data['hometext'];
			$data_insert['bodytext'] = $data['bodytext'];
			$data_insert['keywords'] = $data['keywords'];
			$data_insert['filepath'] = $data['filepath'];
			$data_insert['otherpath'] = $data['otherpath'];
			$data_insert['roomid'] = $data['roomid'];
			$data_insert['fieldid'] = $data['fieldid'];
			$data_insert['down'] = $data['down'];
			$data_insert['view'] = $data['view'];
			$data_insert['userid'] = $data['userid'];
			$data_insert['type'] = $data['type'];
			$data_insert['sign'] = $data['sign'];
			$data_insert['pubtime'] = $data['pubtime'];
			$data_insert['signtime'] = $data['signtime'];
			$data_insert['exptime'] = $data['exptime'];
			$data_insert['organid'] = $data['organid'];

			$newid = $db->insert_id( $sql, 'id', $data_insert );
            if ( $newid > 0 )
            {
                $nv_Cache->delMod( $module_name );
                nv_fix_cat_row ( $data['catid'] );
				nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['addcontent'], $data['title'], $admin_info['userid'] );
                Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main" );
                die();
            }
            else
            {
                $error = $lang_module['errorsave'];
            }
            $db->sqlreset();
        }
        elseif ( $id > 0 )
        {
			$sth = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET
				 catid=' . intval( $data['catid'] ) . ',
				 status=' . intval( $data['status'] ) . ',
				 roomid=:roomid,
				 fieldid=:fieldid,
				 title=:title,
				 alias=:alias,
				 hometext=:hometext,
				 bodytext=:bodytext,
				 keywords=:keywords,
				 filepath=:filepath,
				 otherpath=:otherpath,
				 edittime=' . NV_CURRENTTIME . ',
				 type=:type,
				 sign=:sign,
				 status=:status,
				 pubtime=:pubtime,
				 signtime=:signtime,
				 exptime=:exptime,
				 organid=:organid
			WHERE id =' . $id );

			$sth->bindParam( ':roomid', $data['roomid'], PDO::PARAM_STR );
			$sth->bindParam( ':fieldid', $data['fieldid'], PDO::PARAM_STR );
			$sth->bindParam( ':title', $data['title'], PDO::PARAM_STR );
			$sth->bindParam( ':alias', $data['alias'], PDO::PARAM_STR );
			$sth->bindParam( ':hometext', $data['hometext'], PDO::PARAM_STR, strlen( $data['hometext'] ) );
			$sth->bindParam( ':bodytext', $data['bodytext'], PDO::PARAM_STR, strlen( $data['bodytext'] ) );
			$sth->bindParam( ':keywords', $data['keywords'], PDO::PARAM_STR );
			$sth->bindParam( ':filepath', $data['filepath'], PDO::PARAM_STR );
			$sth->bindParam( ':otherpath', $data['otherpath'], PDO::PARAM_STR );
			$sth->bindParam( ':type', $data['type'], PDO::PARAM_STR );
			$sth->bindParam( ':sign', $data['sign'], PDO::PARAM_STR );
			$sth->bindParam( ':status', $data['status'], PDO::PARAM_STR );
			$sth->bindParam( ':pubtime', $data['pubtime'], PDO::PARAM_STR );
			$sth->bindParam( ':signtime', $data['signtime'], PDO::PARAM_STR );
			$sth->bindParam( ':exptime', $data['exptime'], PDO::PARAM_STR );
			$sth->bindParam( ':organid', $data['organid'], PDO::PARAM_STR );
            $sth->execute();
            nv_fix_catall_row ();
            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main" );
            die();
        }
    }
	else
	{
        $url = 'javascript: history.go(-1)';
        $msg1 = implode('<br />', $error);
        $msg2 = $lang_module['content_back'];
        redirect($msg1, $msg2, $url, $module_data . '_bodyhtml', 'back');
	}
}
/**
 * end: post data 
 */
if ( $id > 0 )
{
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id = '" . $id . "'";
    $result = $db->query( $sql );
    $data = $result->fetch();
    if ( ! empty( $data['bodytext'] ) ) $data['bodytext'] = nv_htmlspecialchars( $data['bodytext'] );
    if ( ! empty( $data['filepath'] ) and file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_upload . "/" . $data['filepath'] ) )
    {
        $data['filepath'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_upload . "/" . $data['filepath'];
    }
}
//pubtime
if ( $data['pubtime']==0 ) $data['pubtime'] ="";
elseif ( $data['pubtime']>0 ) $data['pubtime'] =date("d/m/Y",$data['pubtime']);
//signtime
if ( $data['signtime']==0 ) $data['signtime'] ="";
elseif ( $data['signtime']>0 ) $data['signtime'] =date("d/m/Y",$data['signtime']);
//exptime
if ( $data['exptime']==0 ) $data['exptime'] ="";
elseif ( $data['exptime']>0 ) $data['exptime'] =date("d/m/Y",$data['exptime']);
/**
 * begin: formview data 
 */
$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'DATA', $data );

if (! empty($error)) {
    $xtpl->assign('error', implode('<br />', $error));
    $xtpl->parse('main.error');
}
//view list cat
foreach ( $global_array_cat as $catid_i => $array_value )
{
    $xtitle_i = "";
    if ( $array_value['lev'] > 0 )
    {
        $xtitle_i .= "&nbsp;&nbsp;&nbsp;|";
        for ( $i = 1; $i <= $array_value['lev']; $i ++ )
        {
            $xtitle_i .= "---";
        }
        $xtitle_i .= "&nbsp;";
    }
    $select = ( $catid_i == $data['catid'] ) ? 'selected="selected"' : '';
    $array_cat = array( 
        "xtitle" => $xtitle_i . $array_value['title'], "catid" => $catid_i, "select" => $select 
    );
    $xtpl->assign( 'ROW', $array_cat );
    $xtpl->parse( 'main.catlist' );
}
//view list room
foreach ( $global_array_room as $roomid_i => $array_value )
{
    $xtitle_i = "";
    if ( $array_value['lev'] > 0 )
    {
        $xtitle_i .= "&nbsp;&nbsp;&nbsp;|";
        for ( $i = 1; $i <= $array_value['lev']; $i ++ )
        {
            $xtitle_i .= "---";
        }
        $xtitle_i .= "&nbsp;";
    }
    $select = ( $roomid_i == $data['roomid'] ) ? 'selected="selected"' : '';
    $array_room = array( 
        "xtitle" => $xtitle_i . $array_value['title'], "roomid" => $roomid_i, "select" => $select 
    );
    $xtpl->assign( 'ROW', $array_room );
    $xtpl->parse( 'main.roomlist' );
}
//view list field
foreach ( $global_array_field as $fieldid_i => $array_value )
{
    $xtitle_i = "";
    if ( $array_value['lev'] > 0 )
    {
        $xtitle_i .= "&nbsp;&nbsp;&nbsp;|";
        for ( $i = 1; $i <= $array_value['lev']; $i ++ )
        {
            $xtitle_i .= "---";
        }
        $xtitle_i .= "&nbsp;";
    }
    $select = ( $fieldid_i == $data['fieldid'] ) ? 'selected="selected"' : '';
    $array_field = array( 
        "xtitle" => $xtitle_i . $array_value['title'], "fieldid" => $fieldid_i, "select" => $select 
    );
    $xtpl->assign( 'ROW', $array_field );
    $xtpl->parse( 'main.fieldlist' );
}
//view list organ
foreach ( $global_array_organ as $organid_i => $array_value )
{
    $xtitle_i = "";
    if ( $array_value['lev'] > 0 )
    {
        $xtitle_i .= "&nbsp;&nbsp;&nbsp;|";
        for ( $i = 1; $i <= $array_value['lev']; $i ++ )
        {
            $xtitle_i .= "---";
        }
        $xtitle_i .= "&nbsp;";
    }
    $select = ( $organid_i == $data['organid'] ) ? 'selected="selected"' : '';
    $array_organ = array( 
        "xtitle" => $xtitle_i . $array_value['title'], "organid" => $organid_i, "select" => $select 
    );
    $xtpl->assign( 'ROW', $array_organ );
    $xtpl->parse( 'main.organlist' );
}
//type_content
$array_type = array( 
  0 => $lang_module['nonecontent'], 1 => $lang_module['incontent'], 2 => $lang_module['outcontent'] 
);
$type_content = drawselect_status( "type", $array_type, $data['type'] );
$xtpl->assign( 'type_content', $type_content );
if ( empty( $data['alias'] ) )
{
    $xtpl->parse( 'main.getalias' );
}
$xtpl->assign( 'CURRENT', NV_UPLOADS_DIR . '/' . $module_upload . '/' . date( "Y_m" ) );
if ( defined( 'NV_EDITOR' ) and function_exists( 'nv_aleditor' ) )
{
    $edits = nv_aleditor( 'bodytext', '100%', '300px', $data['bodytext'] );
}
else
{
    $edits = "<textarea style=\"width: 100%\" name=\"bodytext\" id=\"bodytext\" cols=\"20\" rows=\"15\">" . $data['bodytext'] . "</textarea>";
}
$xtpl->assign( 'edit_bodytext', $edits );

$xtpl->assign('UPLOADS_DIR_USER', $uploads_dir_user);
$xtpl->assign('UPLOAD_CURRENT', $currentpath);

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['content'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';