<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! function_exists( 'nv_block_roomtree_archives' ) )
{
    function nv_block_roomtree_archives ($block_config)
    {
        global $module_archives_room, $module_info, $global_config,$site_mods;
    	$module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
    	if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $mod_file . "/block_listtree.tpl") )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        $xtpl = new XTemplate( "block_listtree.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file );
        $xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        $xtpl->assign( 'MENU', draw_room_archives() );
        $xtpl->assign( 'id', $block_config['bid'] );
        if ( ! defined( 'TREEJS' ) )
        {
        	$xtpl->parse( 'main.tree' );
        	define( 'TREEJS', true );
        }
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}
if ( ! function_exists( 'draw_room_archives' ) )
{
    function draw_room_archives ( )
    {
        global $module_archives_room;
        $html = "";
        if ( ! empty( $module_archives_room ) )
        {
            foreach ( $module_archives_room as $roomid => $roominfo )
            {
                if ( $roominfo['parentid'] == '0' )
                {
                    $roominfo['title'] = nv_clean60( $roominfo['title'], 100 );
                    $html .= "	<li><span class=\"folder\"><a href=\"" . $roominfo['link'] . "\" id=\"" . $roomid . "\">" . $roominfo['title'] . "" . "</a></span>\n";
                    if ( $roominfo['numsubroom'] > 0 )
                    {
                       $html .= draw_room_archives_sub( $roomid );
                    }
                    $html .= "</li>";
                }
            }
        }
        return $html;
    }
}
if ( ! function_exists( 'draw_room_archives_sub' ) )
{
    function draw_room_archives_sub ( $pid )
    {
        global $module_archives_room;
        $html = "<ul>";
        foreach ( $module_archives_room as $roomid => $roominfo )
        {
            if ( $roominfo['parentid'] == $pid )
            {
                $roominfo['title0'] = nv_clean60( $roominfo['title'], 100 );
                $html .= "<li>\n";
                $html .= "	<span class=\"folder\"><a href=\"" . $roominfo['link'] . "\" id=\"" . $roomid . "\" title=\"" . $roominfo['title'] . "\" onclick=\"openlink(this)\" >" . $roominfo['title0'] . "" . "</a></span>\n";
                if ( $roominfo['numsubroom'] > 0 )
                {
                    $html .= draw_room_archives_sub( $roomid );
                }
                $html .= "</li>\n";
            }
        }
        $html .= "</ul>";
        return $html;
    }
}
if ( defined( 'NV_SYSTEM' ) )
{
    global $site_mods, $module_name, $global_archives_room, $module_archives_room, $nv_Cache;
    $module = $block_config['module'];
    if ( isset( $site_mods[$module] ) )
    {
        if ( $module == $module_name )
        {
            $module_archives_room = $global_archives_room;
            unset( $module_archives_room[0] );
        }
        else
        {
            $module_archives_room = array();
            $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_room ORDER BY orders ASC";
            $list = $nv_Cache->db( $sql, 'roomid', $module );
            foreach ( $list as $l )
            {
                $module_archives_room[$l['roomid']] = $l;
                $module_archives_room[$l['roomid']]['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=viewroom/" . $l['alias']."-".$l['roomid'];
            }
        }
        $content = nv_block_roomtree_archives($block_config);
    }
}

