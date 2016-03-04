<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! function_exists( 'nv_block_listtree_archives' ) )
{
    function nv_block_listtree_archives ($block_config)
    {
        global $module_archives_cat, $module_info, $global_config,$site_mods;
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
        $xtpl->assign( 'MENU', draw_cat_archives() );
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
if ( ! function_exists( 'draw_cat_archives' ) )
{
    function draw_cat_archives ( )
    {
        global $module_archives_cat;
        $html = "";
        if ( ! empty( $module_archives_cat ) )
        {
            foreach ( $module_archives_cat as $catid => $catinfo )
            {
                if ( $catinfo['parentid'] == '0' )
                {
                    $catinfo['title'] = nv_clean60( $catinfo['title'], 100 );
                    $html .= "	<li><span class=\"folder\"><a href=\"" . $catinfo['link'] . "\" id=\"" . $catid . "\">" . $catinfo['title'] . " (" . $catinfo['numrow'] . ")" . "</a></span>\n";
                    if ( $catinfo['numsubcat'] > 0 )
                    {
                        $html .= draw_cat_archives_sub( $catid );
                    }
                    $html .= "</li>";
                }
            }
        }
        return $html;
    }
}
if ( ! function_exists( 'draw_cat_archives_sub' ) )
{
    function draw_cat_archives_sub ( $pid )
    {
        global $module_archives_cat;
        $html = "<ul>";
        foreach ( $module_archives_cat as $catid => $catinfo )
        {
            if ( $catinfo['parentid'] == $pid )
            {
                $catinfo['title0'] = nv_clean60( $catinfo['title'], 100 );
                $html .= "<li>\n";
                $html .= "	<span class=\"folder\"><a href=\"" . $catinfo['link'] . "\" id=\"" . $catid . "\" title=\"" . $catinfo['title'] . "\" onclick=\"openlink(this)\" >" . $catinfo['title0'] . " (" . $catinfo['numrow'] . ")" . "</a></span>\n";
                if ( $catinfo['numsubcat'] > 0 )
                {
                    $html .= draw_cat_archives_sub( $catid );
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
    global $site_mods, $module_name, $global_archives_cat, $module_archives_cat, $nv_Cache;
    $module = $block_config['module'];
    if ( isset( $site_mods[$module] ) )
    {
        if ( $module == $module_name )
        {
            $module_archives_cat = $global_archives_cat;
            unset( $module_archives_cat[0] );
        }
        else
        {
            $module_archives_cat = array();
            $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_cat ORDER BY orders ASC";
            $list = $nv_Cache->db( $sql, 'catid', $module );
            foreach ( $list as $l )
            {
                $module_archives_cat[$l['catid']] = $l;
                $module_archives_cat[$l['catid']]['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=viewcat/" . $l['alias']."-".$l['catid'];
            }
        }
        $content = nv_block_listtree_archives($block_config);
    }
}

?>