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

/**
 * nv_theme_archives_main()
 * 
 * @param mixed $array_data
 * @return
 */

function view_listcate ( $data_content = null, $html_pages = "" )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $global_archives_cat;
    $xtpl = new XTemplate( "main_catall.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    if ( ! empty( $data_content ) )
    {
        foreach ( $data_content as $data_content_i )
        {
            if ( ! empty( $data_content_i['data'] ) )
            {
                $xtpl->assign( 'CAT', $data_content_i['catinfo'] );
                foreach ( $data_content_i['data'] as $data_i )
                {
                    $data_i['xfile'] = "download";
                    if ( ! empty( $data_i['filepath'] ) )
                    {
                        $temp = explode( '.', $data_i['filepath'] );
                        $xtemp = end( $temp );
                        if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/images/" . $module_file . "/" . $xtemp . ".png" ) )
                        {
                            $data_i['xfile'] = $xtemp;
                        }
                        else
                        {
                            $data_i['xfile'] = "file";
                        }
                    }
                    $data_i['view'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_archives_cat[$data_i['catid']]['alias'] . '/' . $data_i['alias'] . '-' . $data_i['id'] . $global_config['rewrite_exturl'];
                    $data_i['down'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=down/" . $data_i['alias'] . "-" . $data_i['id'];
                    
					// Tinh trang hieu luc
					if( !( $data_i['exptime'] > 0 ) ) {
						if( date( "d/m/Y", $data_i['signtime'] ) >= date( "d/m/Y", NV_CURRENTTIME ) ){
							$data_i['doc_status'] = date( "d/m/Y", $data_i['signtime'] ) . '<br/>' . $lang_module['doc_sign'];
						}
						elseif( date( "d/m/Y", $data_i['signtime']) < date( "d/m/Y", NV_CURRENTTIME ) ){
							$data_i['doc_status'] = date( "d/m/Y", $data_i['signtime'] ) . '<br/>' . $lang_module['doc_pending'];
						}
					}
					elseif( $data_i['exptime'] > 0 ){
						if( date( "d/m/Y", $data_i['exptime'] ) < date( "d/m/Y", NV_CURRENTTIME ) ){
							$data_i['doc_status'] = date( "d/m/Y", $data_i['signtime'] ) . '<br/>' . $lang_module['doc_exp'];
						}
						elseif( date( "d/m/Y", $data_i['exptime']) > date( "d/m/Y", NV_CURRENTTIME ) ){
							$data_i['doc_status'] = date( "d/m/Y", $data_i['signtime'] ) . '<br/>' . $lang_module['doc_sign'];
						}
					}
					
					if ( $data_i['pubtime'] > 0 ) $data_i['pubtime'] = date( "d/m/Y", $data_i['pubtime'] );
					else $data_i['pubtime'] = "";
					if ( $data_i['signtime'] > 0 ) $data_i['signtime'] = date( "d/m/Y", $data_i['signtime'] );
					else $data_i['signtime'] = "";
				
                    $xtpl->assign( 'ROW', $data_i );
                    $xtpl->parse( 'main.cat.loop' );
                }
                $xtpl->parse( 'main.cat' );
            }
        }
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function view_listall ( $data_content = null, $html_pages = "" )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $global_archives_cat;
    $xtpl = new XTemplate( "main_listall.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    if ( ! empty( $data_content ) )
    {
        foreach ( $data_content as $row )
        {
            $row['xfile'] = "download";
            if ( ! empty( $row['filepath'] ) )
            {
                $temp = explode( '.', $row['filepath'] );
                $xtemp = end( $temp );
                if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/images/" . $module_file . "/" . $xtemp . ".png" ) )
                {
                    $row['xfile'] = $xtemp;
                }
                else
                {
                    $row['xfile'] = "file";
                }
            }
            $row['view'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_archives_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
            $row['down'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=down/" . $row['alias'] . "-" . $row['id'];
			// Tinh trang hieu luc
			if( !( $row['exptime'] > 0 ) ) {
				if( date( "d/m/Y", $row['signtime'] ) >= date( "d/m/Y", NV_CURRENTTIME ) ){
					$row['doc_status'] = date( "d/m/Y", $row['signtime'] ) . '<br/>' . $lang_module['doc_sign'];
				}
				elseif( date( "d/m/Y", $row['signtime']) < date( "d/m/Y", NV_CURRENTTIME ) ){
					$row['doc_status'] = date( "d/m/Y", $row['signtime'] ) . '<br/>' . $lang_module['doc_pending'];
				}
			}
			elseif( $row['exptime'] > 0 ){
				if( date( "d/m/Y", $row['exptime'] ) < date( "d/m/Y", NV_CURRENTTIME ) ){
					$row['doc_status'] = date( "d/m/Y", $row['signtime'] ) . '<br/>' . $lang_module['doc_exp'];
				}
				elseif( date( "d/m/Y", $row['exptime']) > date( "d/m/Y", NV_CURRENTTIME ) ){
					$row['doc_status'] = date( "d/m/Y", $row['signtime'] ) . '<br/>' . $lang_module['doc_sign'];
				}
			}
			
            if ( $row['pubtime'] > 0 ) $row['pubtime'] = date( "d/m/Y", $row['pubtime'] );
            else $row['pubtime'] = "";
			if ( $row['signtime'] > 0 ) $row['signtime'] = date( "d/m/Y", $row['signtime'] );
			else $row['signtime'] = "";

            $xtpl->assign( 'ROW', $row );
            $xtpl->parse( 'main.loop' );
        }
    }
    if ( ! empty( $html_pages ) )
    {
        $xtpl->assign( 'htmlpage', $html_pages );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function view_archives ( $data_content )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info;
    $xtpl = new XTemplate( "view.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    $data_content['xfile'] = "download";
    if ( ! empty( $data_content['filepath'] ) )
    {
        $temp = explode( '.', $data_content['filepath'] );
        $xtemp = end( $temp );
        if ( file_exists( NV_ROOTDIR . "/themes/" . $module_info['template'] . "/images/" . $module_file . "/" . $xtemp . ".png" ) )
        {
            $data_content['xfile'] = $xtemp;
        }
        else
        {
            $data_content['xfile'] = "file";
        }
    }
	if(empty($data_content['hometext'])){
		$data_content['hometext'] = $lang_module['doc_on_updating'];
	}
	if(empty($data_content['bodytext'])){
		$data_content['bodytext'] = $lang_module['doc_on_updating'];
	}
	
    $xtpl->assign( 'DATA', $data_content );
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function viewcat_list ( $data_content = null, $top_contents = "", $html_pages = "" )
{
    return $top_contents . view_listall( $data_content, $html_pages );
}

function viewcat_gird ( $data_content = null, $top_contents = "", $html_pages = "" )
{
    return $top_contents . view_listall( $data_content, $html_pages );
}

function view_search ( $data_content = null, $html_pages = "", $data_form )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $global_archives_cat, $global_archives_room, $global_archives_field, $global_archives_organ;
    $xtpl = new XTemplate( "view_search.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    $xtpl->assign( 'RESULT', view_listall( $data_content, $html_pages ) );
    $xtpl->assign( 'DATA', $data_form );
    foreach ( $global_archives_cat as $catid => $catinfo )
    {
        $xtitle = "";
        if ( $catinfo['lev'] > 0 )
        {
            $xtitle .= "|";
            for ( $i = 1; $i <= $catinfo['lev']; $i ++ )
            {
                $xtitle .= "----- ";
            }
        }
        $catinfo['xtitle'] = $xtitle . $catinfo['title'];
        $catinfo['select'] = ( $catinfo['catid'] == $data_form['catid'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign( 'ROW', $catinfo );
        $xtpl->parse( 'main.cat_loop' );
    }
    foreach ( $global_archives_room as $roomid => $roominfo )
    {
        $xtitle = "";
        if ( $roominfo['lev'] > 0 )
        {
            $xtitle .= "|";
            for ( $i = 1; $i <= $roominfo['lev']; $i ++ )
            {
                $xtitle .= "----- ";
            }
        }
        $roominfo['xtitle'] = $xtitle . $roominfo['title'];
        $roominfo['select'] = ( $roominfo['roomid'] == $data_form['roomid'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign( 'ROW', $roominfo );
        $xtpl->parse( 'main.room_loop' );
    }
    foreach ( $global_archives_field as $fieldid => $fieldinfo )
    {
        $xtitle = "";
        if ( $fieldinfo['lev'] > 0 )
        {
            $xtitle .= "|";
            for ( $i = 1; $i <= $fieldinfo['lev']; $i ++ )
            {
                $xtitle .= "----- ";
            }
        }
        $fieldinfo['xtitle'] = $xtitle . $fieldinfo['title'];
        $fieldinfo['select'] = ( $fieldinfo['fieldid'] == $data_form['fieldid'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign( 'ROW', $fieldinfo );
        $xtpl->parse( 'main.field_loop' );
    }
    foreach ( $global_archives_organ as $organid => $organinfo )
    {
        $xtitle = "";
        if ( $organinfo['lev'] > 0 )
        {
            $xtitle .= "|";
            for ( $i = 1; $i <= $organinfo['lev']; $i ++ )
            {
                $xtitle .= "----- ";
            }
        }
        $organinfo['xtitle'] = $xtitle . $organinfo['title'];
        $organinfo['select'] = ( $organinfo['organid'] == $data_form['organid'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign( 'ROW', $organinfo );
        $xtpl->parse( 'main.organ_loop' );
    }
    $array_type = array();
    $array_type[] = array( 
        "val" => 1, "title" => $lang_module['doc_name'] 
    );
    $array_type[] = array( 
        "val" => 2, "title" => $lang_module['hometext'] 
    );
    foreach ( $array_type as $type )
    {
        $type['select'] = ( $type['val'] == $data_form['type'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign( 'ROW', $type );
        $xtpl->parse( 'main.type_loop' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

function upload_content ( $data, $error )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $global_archives_cat, $global_archives_room, $global_archives_field, $global_archives_organ;
    $xtpl = new XTemplate( "content.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    $xtpl->assign( 'TEMPLATE', $module_info['template'] );
    $xtpl->assign( 'DATA', $data );
    foreach ( $global_archives_cat as $catid => $catinfo )
    {
        $xtitle = "";
        if ( $catinfo['lev'] > 0 )
        {
            $xtitle .= "|";
            for ( $i = 1; $i <= $catinfo['lev']; $i ++ )
            {
                $xtitle .= "----- ";
            }
        }
        $catinfo['xtitle'] = $xtitle . $catinfo['title'];
        $catinfo['select'] = ( $catinfo['catid'] == $data['catid'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign( 'ROW', $catinfo );
        $xtpl->parse( 'main.catlist' );
    }
    foreach ( $global_archives_room as $roomid => $roominfo )
    {
        $xtitle = "";
        if ( $roominfo['lev'] > 0 )
        {
            $xtitle .= "|";
            for ( $i = 1; $i <= $roominfo['lev']; $i ++ )
            {
                $xtitle .= "----- ";
            }
        }
        $roominfo['xtitle'] = $xtitle . $roominfo['title'];
        $roominfo['select'] = ( $roominfo['roomid'] == $data['roomid'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign( 'ROW', $roominfo );
        $xtpl->parse( 'main.roomlist' );
    }
    foreach ( $global_archives_field as $fieldid => $fieldinfo )
    {
        $xtitle = "";
        if ( $fieldinfo['lev'] > 0 )
        {
            $xtitle .= "|";
            for ( $i = 1; $i <= $fieldinfo['lev']; $i ++ )
            {
                $xtitle .= "----- ";
            }
        }
        $fieldinfo['xtitle'] = $xtitle . $fieldinfo['title'];
        $fieldinfo['select'] = ( $fieldinfo['fieldid'] == $data['fieldid'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign( 'ROW', $fieldinfo );
        $xtpl->parse( 'main.fieldlist' );
    }
    foreach ( $global_archives_organ as $organid => $organinfo )
    {
        $xtitle = "";
        if ( $organinfo['lev'] > 0 )
        {
            $xtitle .= "|";
            for ( $i = 1; $i <= $organinfo['lev']; $i ++ )
            {
                $xtitle .= "----- ";
            }
        }
        $organinfo['xtitle'] = $xtitle . $organinfo['title'];
        $organinfo['select'] = ( $organinfo['organid'] == $data['organid'] ) ? "selected=\"selected\"" : "";
        $xtpl->assign( 'ROW', $organinfo );
        $xtpl->parse( 'main.organlist' );
    }
    //type_content
    $array_type = array( 
        0 => $lang_module['nonecontent'], 1 => $lang_module['incontent'], 2 => $lang_module['outcontent'] 
    );
    $type_content = drawselect_status( "type", $array_type, $data['type'] );
    $xtpl->assign( 'type_content', $type_content );
    if ( defined( 'NV_EDITOR' ) and function_exists( 'nv_aleditor' ) )
    {
        $editor = nv_aleditor( 'bodytext', '100%', '250px', $data['bodytext'] );
    }
    else
    {
        $editor = "<textarea style='width:100%' rows='8' name=\"bodytext\" id=\"bodytext\">" . $data['bodytext'] . "</textarea>";
    }
    $xtpl->assign( 'edit_bodytext', $editor );
    if ( ! empty( $error ) )
    {
        $xtpl->assign( 'ERROR', $error );
        $xtpl->parse( 'main.error' );
    }
    if ( ! empty( $data['filepath'] ) )
    {
        $xtpl->parse( 'main.file' );
    }
    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}