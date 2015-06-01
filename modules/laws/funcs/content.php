<?php

/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 29 May 2015 07:49:53 GMT
 */


check_upload();

$page_title = $lang_module['content'];
$month_dir_module = nv_mkdir( NV_UPLOADS_REAL_DIR . '/' . $module_name, date( "Y_m" ), true );

if ( defined( 'NV_EDITOR' ) )
{
    require_once ( NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php' );
}
else if ( ! function_exists( 'nv_aleditor' ) and file_exists( NV_ROOTDIR . '/' . NV_EDITORSDIR . '/ckeditor/ckeditor_php5.php' ) )
{
    define( 'NV_EDITOR', TRUE );
    define( 'NV_IS_CKEDITOR', TRUE );
    require_once ( NV_ROOTDIR . '/' . NV_EDITORSDIR . '/ckeditor/ckeditor_php5.php' );

    function nv_aleditor ( $textareaname, $width = "100%", $height = '450px', $val = '' )
    {
        // Create class instance.
        $editortoolbar = array( 
            array( 
            'Link', 'Unlink', 'Image', 'Table', 'Font', 'FontSize', 'RemoveFormat' 
        ), array( 
            'Bold', 'Italic', 'Underline', 'StrikeThrough', '-', 'Subscript', 'Superscript', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'OrderedList', 'UnorderedList', '-', 'Outdent', 'Indent', 'TextColor', 'BGColor', 'Source' 
        ) 
        );
        $CKEditor = new CKEditor();
        // Do not print the code directly to the browser, return it instead
        $CKEditor->returnOutput = true;
        $CKEditor->config['skin'] = 'v2';
        $CKEditor->config['entities'] = false;
        //$CKEditor->config['enterMode'] = 2;
        $CKEditor->config['language'] = NV_LANG_INTERFACE;
        $CKEditor->config['toolbar'] = $editortoolbar;
        // Path to CKEditor directory, ideally instead of relative dir, use an absolute path:
        //   $CKEditor->basePath = '/ckeditor/'
        // If not set, CKEditor will try to detect the correct path.
        $CKEditor->basePath = NV_BASE_SITEURL . '' . NV_EDITORSDIR . '/ckeditor/';
        // Set global configuration (will be used by all instances of CKEditor).
        if ( ! empty( $width ) )
        {
            $CKEditor->config['width'] = strpos( $width, '%' ) ? $width : intval( $width );
        }
        if ( ! empty( $height ) )
        {
            $CKEditor->config['height'] = strpos( $height, '%' ) ? $height : intval( $height );
        }
        // Change default textarea attributes
        $CKEditor->textareaAttributes = array( 
            "cols" => 80, "rows" => 10 
        );
        $val = nv_unhtmlspecialchars( $val );
        return $CKEditor->editor( $textareaname, $val );
    }
}

$error = "";
$roomid = $nv_Request->get_int( 'roomid', 'get', 0 );
$catid = $nv_Request->get_int( 'catid', 'get,post', 0 );
$fieldid = $nv_Request->get_int( 'fieldid', 'get', 0 );
$organid = $nv_Request->get_int( 'organid', 'get', 0 );
$id = $nv_Request->get_int( 'id', 'get,post', 0 );

if (empty($user_info['userid'])) $user_info['userid'] = 0;

$data = array( 
    "id" => 0, "catid" => $catid, "title" => "", "hometext" => "", "bodytext" => "",
	"keywords" => "", "filepath" => "", "otherpath" => "", "roomid" => $roomid,"fieldid" => $fieldid, "addtime" => NV_CURRENTTIME, 
	"edittime" => NV_CURRENTTIME, "down" => 0, "view" => 0, "userid" => $user_info['userid'], 
	"status" => $data_config['status'], "type" => 0 ,"sign"=>"","signtime"=>NV_CURRENTTIME,"organid"=>$organid
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
    $data['otherpath'] = $nv_Request->get_string( 'otherpath', 'post', '');
    $bodytext = $nv_Request->get_string( 'bodytext', 'post', '' );
    $data['bodytext'] = defined( 'NV_EDITOR' ) ? nv_nl2br( $bodytext, '' ) : nv_nl2br( nv_htmlspecialchars( strip_tags( $bodytext ) ), '<br />' );
    $data['sign'] = $nv_Request->get_string( 'sign', 'post', '' );
    $signtime = $nv_Request->get_string( 'signtime', 'post', 0 );
    $data['organid'] = $nv_Request->get_int( 'organid', 'post', 0);
    
    if ( ! empty( $signtime ) and ! preg_match( "/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $signtime ) ) $signtime = "";
    if ( empty( $signtime ) )
    {
        $data['signtime'] = 0;
    }
    else
    {
        $phour = date( 'H' );
        $pmin = date( 'i' );
        unset( $m );
        preg_match( "/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $signtime, $m );
        $data['signtime'] = mktime( $phour, $pmin, 0, $m[2], $m[1], $m[3] );
    }
    if ( empty( $data['title'] ) ) $error = $lang_module['content_title_erorr'];
    else
    {
    	if ( is_uploaded_file( $_FILES['fileup']["tmp_name"] ) )
        {
            require_once ( NV_ROOTDIR . "/includes/class/upload.class.php" );
            $allow_files_type = array("adobe","application","archives","documents","flash","images");
            $upload = new upload( $allow_files_type, $global_config['forbid_extensions'], $global_config['forbid_mimes'], NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT );
            $upload_info = $upload->save_file( $_FILES['fileup'], NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/' . date( "Y_m" ), false );
            if ( ! empty( $upload_info['error'] ) )
            {
                $error = $upload_info['error'];
            }
            else
            {
                $data['filepath'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . date( "Y_m" ) . '/' . $upload_info['basename'];
                $lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_name . "/" );
    			$data['filepath'] = substr( $data['filepath'], $lu );
            }
        }
        if ( $id == 0 && empty($error))
        {
            //insert data
            $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows
				(catid, title, alias, hometext, bodytext, keywords, filepath,otherpath, roomid,fieldid, addtime, edittime, down, view, userid, status, type,sign,signtime,organid) VALUES
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
				 :signtime,
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
			$data_insert['signtime'] = $data['signtime'];
			$data_insert['organid'] = $data['organid'];

			$newid = $db->insert_id( $sql, 'id', $data_insert );
            if ( $newid > 0 )
            {
                nv_del_moduleCache( $module_name );
                nv_fix_cat_row ( $data['catid'] );
                nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['addcontent'], $data['title'], $admin_info['userid'] );
                $nv_redirect = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name;
                redict_link ( $lang_module['upload_ok'], $lang_module['upload_view'], $nv_redirect );
            }
            else
            {
                $error = $lang_module['errorsave'];
            }
            $db->sqlreset();
        }
    }
}
if ( $data['signtime']==0 ) $data['signtime'] ="";
elseif ( $data['signtime']>0 ) $data['signtime'] =date("d/m/Y",$data['signtime']);
    
$contents = upload_content( $data, $error );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
