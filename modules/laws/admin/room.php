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

$page_title = $lang_module['listroom'] ;
$contents = "";
$error = "";
$parentid = $nv_Request->get_int( 'parentid', 'get', 0 );
$roomid = $nv_Request->get_int( 'roomid', 'get', 0 );
$data = array(
	"roomid"=>0, "parentid"=>0, "title"=>"", "alias"=>"", "description"=>"", "weight"=>0, "orders"=>0, 
	"lev"=>0, "numsubroom"=>0, "subroomid"=>"", "keywords"=>"", "admins"=>0, 
	"add_time"=>NV_CURRENTTIME,"edit_time"=>NV_CURRENTTIME
);

//post data
if ( $nv_Request->get_int( 'save', 'post', 0 ) == '1' )
{
    $parentid_old = $nv_Request->get_int( 'parentid_old', 'post', 0 );
    $data['parentid'] = $nv_Request->get_int( 'parentid', 'post', 0 );
    $data['title'] = $nv_Request->get_string( 'title', 'post', '', 1 );
    $data['keywords'] = $nv_Request->get_string( 'keywords', 'post', '', 1 );
    $alias = $nv_Request->get_string( 'alias', 'post', '' );
    $data['alias'] = ( $alias == "" ) ? change_alias( $data['title'] ) : change_alias( $alias );
    $description = $nv_Request->get_string( 'description', 'post', '' );
    $data['description'] = nv_nl2br( nv_htmlspecialchars( strip_tags( $description ) ), '<br />' );
    if ( empty($data['title']) ) $error = $lang_module['room_title_erorr'];
    else 
    {
    	if ($roomid==0)
    	{
    		//insert data
	    	$result=$db->query( "SELECT max(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_room WHERE parentid='" . $data['parentid'] . "'" );
	    	$weight = $result->fetch();
	        $weight = intval( $weight ) + 1;
	        $query = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_room (roomid, parentid, title, alias, description, weight, orders, lev, numsubroom, subroomid,keywords, admins, add_time, edit_time)
	         		  VALUES (NULL, :parentid , :title , :alias, :description, :weight, '0', '0', '0', :subroomid, :keywords, ''," . NV_CURRENTTIME . "," . NV_CURRENTTIME . ")";
	        $data_insert = array();

			$data_insert['parentid'] = $data['parentid'];
			$data_insert['title'] = $data['title'];
			$data_insert['alias'] = $data['alias'];
			$data_insert['description'] = $data['description'];
			$data_insert['weight'] = $weight;
			$data_insert['subroomid'] = $data['subroomid'];
			$data_insert['keywords'] = $data['keywords'];
			$newroomid=$db->insert_id( $query, 'roomid', $data_insert );
	        if ( $newroomid > 0 )
	        {
	        	nv_fix_room_order();
	        	$nv_Cache->delMod( $module_name );
	            //nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['add_room'], $data['title'], $admin_info['userid'] );
	            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&parentid=" . $data['parentid'] . "" );
	            die();
	        }
	    	else
	        {
	            $error = $lang_module['errorsave'];
	        }
	        $db->sqlreset();
    	}
    	elseif($roomid>0) 
    	{
    		//update data
			$stmt = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_room SET parentid= :parentid, title= :title, alias = :alias, description = :description, keywords= :keywords, edit_time=' . NV_CURRENTTIME . ' WHERE roomid =' . $roomid );
			$stmt->bindParam( ':parentid', $data['parentid'], PDO::PARAM_INT );
			$stmt->bindParam( ':title', $data['title'], PDO::PARAM_STR );
			$stmt->bindParam( ':alias', $data['alias'], PDO::PARAM_STR );
			$stmt->bindParam( ':keywords', $data['keywords'], PDO::PARAM_STR );
			$stmt->bindParam( ':description', $data['description'], PDO::PARAM_STR, strlen( $data['description'] ) );
			$stmt->execute();
        	if ( $stmt->rowCount() )
	        {
	        	if ( $data['parentid'] != $parentid_old )
	        	{
	        		$result= $db->query( "SELECT max(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_room WHERE parentid='" . $data['parentid'] . "'" );
	        		$weight  = $result->fetch();
	                $weight = intval( $weight ) + 1;
	                $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_room SET weight='" . $weight . "' WHERE roomid='" . intval( $roomid )."'";
	                $db->query( $sql );
	                nv_fix_room_order();
	        	}
	        	nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['edit_room'], $data['title'], $admin_info['userid'] );
	        	Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&parentid=" . $data['parentid'] . "" );
	            die();
	        }
	        else
	        {
	            $error = $lang_module['errorsave'];
	        }
	        $db->sqlreset();
    	}
    }
}
//select data
if ( $roomid > 0)
{
	$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_room WHERE roomid = '" . $roomid . "' ORDER BY weight ASC";
	$result = $db->query( $sql );
	$data = $result->fetch();
}
/**
 * begin: listview data 
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

if ( $parentid > 0 )
{
    $parentid_i = $parentid;
    $array_room_title = array();
    while ( $parentid_i > 0 )
    {
        $array_room_title[] = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room&amp;parentid=" . $parentid_i . "\"><strong>" . $global_array_room[$parentid_i]['title'] . "</strong></a>";
        $parentid_i = $global_array_room[$parentid_i]['parentid'];
    }
    sort( $array_room_title, SORT_NUMERIC );
    $ptemp = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room&amp;parentid=0\"><strong>" . $lang_module['root_room'] . "</strong></a>";
    $contents .= $ptemp." -> ".implode( " -> ", $array_room_title );
}

$num = 1;
foreach ( $global_array_room as $row )
{
    if ( $row['parentid'] == $parentid ) $num++;
}
if ( $num > 0 )
{
    $array_inhome = array( 
        0 => $lang_global['no'], 1 => $lang_global['yes'] 
    );
    $a = 1;
    foreach ( $global_array_room as $row )
    {
    	if ( $row['parentid'] == $parentid )
    	{
	        $row['sweight'] = drawselect_number( "weight", 1, $num-1, $row['weight'],"ChangeActiveroom(this,".$row['roomid'].",'weight')" );
    		$row['class'] = ( $a % 2 ) ? " class=\"second\"" : "";
	        $row['edit'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room&amp;parentid=" . $row['parentid']."&amp;roomid=" . $row['roomid'];
	        $row['del'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room_action&amp;ac=del&amp;roomid=" . $row['roomid'];
	        $row['add'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;roomid=" . $row['roomid'];
	        $row['linkparent'] = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=room&amp;parentid=" . $row['roomid'];
	        $xtpl->assign( 'ROW', $row );
	        $xtpl->parse( 'main.list.loop' );
    	}
    }
    $xtpl->parse( 'main.list' );
}
/**
 * end: listview data 
 */

/** 
 * view form data
 */
if ( ! empty( $error ) )
{
    $xtpl->assign( 'ERROR', $error );
    $xtpl->parse( 'main.form.error' );
}
foreach ( $global_array_room as $roomid_i => $array_value )
{
	if ( $roomid_i != $roomid )
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
	    $select = ( $roomid_i == $parentid ) ? 'selected="selected"' : '';
	    $array_room = array( "xtitle"=> $xtitle_i.$array_value['title'], "roomid"=>$roomid_i,"select"=>$select);
	    $xtpl->assign( 'ROW', $array_room );
	    $xtpl->parse( 'main.form.roomlist' );
	}
}
if ( empty( $data['alias'] ) )
{
    $xtpl->parse( 'main.form.getalias' );
}
$xtpl->assign( 'DATA', $data );
$xtpl->parse( 'main.form' );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['room'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';