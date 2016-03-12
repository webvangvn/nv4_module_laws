<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_MOD_ARCHIES' ) ) die( 'Stop!!!' );

if ( ! function_exists( 'nv_block_archives_all' ) )
{
    function nv_block_archives_all ( )
    {
        global $lang_module, $module_config, $module_info, $module_file, $nv_Request, $array_op;
        $q = $nv_Request->get_string( 'q', 'get', '' );
        $oid = $nv_Request->get_int( 'catid', 'get', 0 );
        $array_content = array();
        $array_content[] = array( 
            "title" => $lang_module['of_organs'], "link" => "#", "content" => nv_block_organ_tree_archives() 
        );
        $array_content[] = array( 
            "title" => $lang_module['catcontent'], "link" => "#", "content" => nv_block_cattree_archives() 
        );
        $array_content[] = array( 
            "title" => $lang_module['doc_of_room'], "link" => "#", "content" => nv_block_room_tree_archives() 
        );
        $array_content[] = array( 
            "title" => $lang_module['of_field'], "link" => "#", "content" => nv_block_field_tree_archives() 
        );
        if ( ! empty( $array_content ) )
        {
            $xtpl = new XTemplate( "block_catall.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
            $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
            foreach ( $array_content as $content )
            {
                $xtpl->assign( 'CONTENT', $content );
                $xtpl->parse( 'main.ploop' );
            }
            $xtpl->parse( 'main' );
            return $xtpl->text( 'main' );
        }
        return "";
    }
}
//cat-tree
if ( ! function_exists( 'nv_block_cattree_archives' ) )
{

    function nv_block_cattree_archives ( )
    {
        global $global_archives_cat, $module_info, $global_config, $module_name, $module_data, $module_file;
        if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $module_file . "/block_listtree.tpl" ) )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        $xtpl = new XTemplate( "block_listtree.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $module_file );
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        $xtpl->assign( 'MENU', nv_draw_cat_archives() );
        $xtpl->assign( 'id', "cat" );
        if ( ! defined( 'TREEJS' ) )
        {
            $xtpl->parse( 'main.tree' );
            define( 'TREEJS', true );
        }
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}
if ( ! function_exists( 'nv_draw_cat_archives' ) )
{

    function nv_draw_cat_archives ( )
    {
        global $global_archives_cat;
        $html = "";
        if ( ! empty( $global_archives_cat ) )
        {
            foreach ( $global_archives_cat as $catid => $catinfo )
            {
                if ( $catinfo['parentid'] == '0' )
                {
                    $catinfo['title'] = nv_clean60( $catinfo['title'], 100 );
                    $html .= "	<li><span class=\"folder\"><a href=\"" . $catinfo['link'] . "\" id=\"" . $catid . "\">" . $catinfo['title'] . " (" . $catinfo['numrow'] . ")" . "</a></span>\n";
                    if ( $catinfo['numsubcat'] > 0 )
                    {
                        $html .= nv_draw_cat_archives_sub( $catid );
                    }
                    $html .= "</li>";
                }
            }
        }
        return $html;
    }
}
if ( ! function_exists( 'nv_draw_cat_archives_sub' ) )
{

    function nv_draw_cat_archives_sub ( $pid )
    {
        global $global_archives_cat;
        $html = "<ul>";
        foreach ( $global_archives_cat as $catid => $catinfo )
        {
            if ( $catinfo['parentid'] == $pid )
            {
                $catinfo['title0'] = nv_clean60( $catinfo['title'], 100 );
                $html .= "<li>\n";
                $html .= "	<span class=\"folder\"><a href=\"" . $catinfo['link'] . "\" id=\"" . $catid . "\" title=\"" . $catinfo['title'] . "\" onclick=\"openlink(this)\" >" . $catinfo['title0'] . " (" . $catinfo['numrow'] . ")" . "</a></span>\n";
                if ( $catinfo['numsubcat'] > 0 )
                {
                    $html .= nv_draw_cat_archives_sub( $catid );
                }
                $html .= "</li>\n";
            }
        }
        $html .= "</ul>";
        return $html;
    }
}
//end cat
if ( ! function_exists( 'nv_block_field_tree_archives' ) )
{

    function nv_block_field_tree_archives ( )
    {
        global $module_info, $global_config, $module_name, $module_data, $module_file;
        if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $module_file . "/block_listtree.tpl" ) )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        $xtpl = new XTemplate( "block_listtree.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $module_file );
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        $xtpl->assign( 'MENU', nv_draw_field_archives() );
        $xtpl->assign( 'id', "field" );
        if ( ! defined( 'TREEJS' ) )
        {
            $xtpl->parse( 'main.tree' );
            define( 'TREEJS', true );
        }
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}
if ( ! function_exists( 'nv_draw_field_archives' ) )
{

    function nv_draw_field_archives ( )
    {
        global $global_archives_field;
        $html = "";
        if ( ! empty( $global_archives_field ) )
        {
            foreach ( $global_archives_field as $fieldid => $fieldinfo )
            {
                if ( $fieldinfo['parentid'] == '0' )
                {
                    $fieldinfo['title'] = nv_clean60( $fieldinfo['title'], 100 );
                    $html .= "	<li><span class=\"folder\"><a href=\"" . $fieldinfo['link'] . "\" id=\"" . $fieldid . "\">" . $fieldinfo['title'] . "" . "</a></span>\n";
                    if ( $fieldinfo['numsubfield'] > 0 )
                    {
                        $html .= nv_draw_field_archives_sub( $fieldid );
                    }
                    $html .= "</li>";
                }
            }
        }
        return $html;
    }
}
if ( ! function_exists( 'nv_draw_field_archives_sub' ) )
{

    function nv_draw_field_archives_sub ( $pid )
    {
        global $global_archives_field;
        $html = "<ul>";
        foreach ( $global_archives_field as $fieldid => $fieldinfo )
        {
            if ( $fieldinfo['parentid'] == $pid )
            {
                $fieldinfo['title0'] = nv_clean60( $fieldinfo['title'], 100 );
                $html .= "<li>\n";
                $html .= "	<span class=\"folder\"><a href=\"" . $fieldinfo['link'] . "\" id=\"" . $fieldid . "\" title=\"" . $fieldinfo['title'] . "\" onclick=\"openlink(this)\" >" . $fieldinfo['title0'] . "" . "</a></span>\n";
                if ( $fieldinfo['numsubfield'] > 0 )
                {
                    $html .= nv_draw_field_archives_sub( $fieldid );
                }
                $html .= "</li>\n";
            }
        }
        $html .= "</ul>";
        return $html;
    }
}
//end feild
//room
if ( ! function_exists( 'nv_block_room_tree_archives' ) )
{

    function nv_block_room_tree_archives ( )
    {
        global $module_info, $global_config, $module_name, $module_data, $module_file;
        if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $module_file . "/block_listtree.tpl" ) )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        $xtpl = new XTemplate( "block_listtree.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $module_file );
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        $xtpl->assign( 'MENU', nv_draw_room_archives() );
        $xtpl->assign( 'id', "room" );
        if ( ! defined( 'TREEJS' ) )
        {
            $xtpl->parse( 'main.tree' );
            define( 'TREEJS', true );
        }
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}
if ( ! function_exists( 'nv_draw_room_archives' ) )
{

    function nv_draw_room_archives ( )
    {
        global $global_archives_room;
        $html = "";
        if ( ! empty( $global_archives_room ) )
        {
            foreach ( $global_archives_room as $roomid => $roominfo )
            {
                if ( $roominfo['parentid'] == '0' )
                {
                    $roominfo['title'] = nv_clean60( $roominfo['title'], 100 );
                    $html .= "	<li><span class=\"folder\"><a href=\"" . $roominfo['link'] . "\" id=\"" . $roomid . "\">" . $roominfo['title'] . "" . "</a></span>\n";
                    if ( $roominfo['numsubroom'] > 0 )
                    {
                        $html .= nv_draw_room_archives_sub( $roomid );
                    }
                    $html .= "</li>";
                }
            }
        }
        return $html;
    }
}
if ( ! function_exists( 'nv_draw_room_archives_sub' ) )
{

    function nv_draw_room_archives_sub ( $pid )
    {
        global $global_archives_room;
        $html = "<ul>";
        foreach ( $global_archives_room as $roomid => $roominfo )
        {
            if ( $roominfo['parentid'] == $pid )
            {
                $roominfo['title0'] = nv_clean60( $roominfo['title'], 100 );
                $html .= "<li>\n";
                $html .= "	<span class=\"folder\"><a href=\"" . $roominfo['link'] . "\" id=\"" . $roomid . "\" title=\"" . $roominfo['title'] . "\" onclick=\"openlink(this)\" >" . $roominfo['title0'] . "" . "</a></span>\n";
                if ( $roominfo['numsubroom'] > 0 )
                {
                    $html .= nv_draw_room_archives_sub( $roomid );
                }
                $html .= "</li>\n";
            }
        }
        $html .= "</ul>";
        return $html;
    }
}

//organ
if ( ! function_exists( 'nv_block_organ_tree_archives' ) )
{

    function nv_block_organ_tree_archives ( )
    {
        global $module_info, $global_config, $module_name, $module_data, $module_file;
        if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $module_file . "/block_listtree.tpl" ) )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        $xtpl = new XTemplate( "block_listtree.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $module_file );
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        $xtpl->assign( 'MENU', nv_draw_organ_archives() );
        $xtpl->assign( 'id', "organ" );
        if ( ! defined( 'TREEJS' ) )
        {
            $xtpl->parse( 'main.tree' );
            define( 'TREEJS', true );
        }
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}
if ( ! function_exists( 'nv_draw_organ_archives' ) )
{

    function nv_draw_organ_archives ( )
    {
        global $global_archives_organ;
        $html = "";
        if ( ! empty( $global_archives_organ ) )
        {
            foreach ( $global_archives_organ as $organid => $organinfo )
            {
                if ( $organinfo['parentid'] == '0' )
                {
                    $organinfo['title'] = nv_clean60( $organinfo['title'], 100 );
                    $html .= "	<li><span class=\"folder\"><a href=\"" . $organinfo['link'] . "\" id=\"" . $organid . "\">" . $organinfo['title'] . "" . "</a></span>\n";
                    if ( $organinfo['numsuborgan'] > 0 )
                    {
                        $html .= nv_draw_organ_archives_sub( $organid );
                    }
                    $html .= "</li>";
                }
            }
        }
        return $html;
    }
}
if ( ! function_exists( 'nv_draw_organ_archives_sub' ) )
{

    function nv_draw_organ_archives_sub ( $pid )
    {
        global $global_archives_organ;
        $html = "<ul>";
        foreach ( $global_archives_organ as $organid => $organinfo )
        {
            if ( $organinfo['parentid'] == $pid )
            {
                $organinfo['title0'] = nv_clean60( $organinfo['title'], 100 );
                $html .= "<li>\n";
                $html .= "	<span class=\"folder\"><a href=\"" . $organinfo['link'] . "\" id=\"" . $organid . "\" title=\"" . $organinfo['title'] . "\" onclick=\"openlink(this)\" >" . $organinfo['title0'] . "" . "</a></span>\n";
                if ( $organinfo['numsuborgan'] > 0 )
                {
                    $html .= nv_draw_organ_archives_sub( $organid );
                }
                $html .= "</li>\n";
            }
        }
        $html .= "</ul>";
        return $html;
    }
}
//end organ

$content = nv_block_archives_all();

