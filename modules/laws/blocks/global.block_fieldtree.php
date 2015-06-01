<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! function_exists( 'nv_block_fieldtree_archives' ) )
{
    function nv_block_fieldtree_archives ($block_config)
    {
        global $module_archives_field, $module_info, $global_config,$site_mods;
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
        $xtpl->assign( 'MENU', draw_field_archives() );
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
if ( ! function_exists( 'draw_field_archives' ) )
{
    function draw_field_archives ( )
    {
        global $module_archives_field;
        $html = "";
        if ( ! empty( $module_archives_field ) )
        {
            foreach ( $module_archives_field as $fieldid => $fieldinfo )
            {
                if ( $fieldinfo['parentid'] == '0' )
                {
                    $fieldinfo['title'] = nv_clean60( $fieldinfo['title'], 100 );
                    $html .= "	<li><span class=\"folder\"><a href=\"" . $fieldinfo['link'] . "\" id=\"" . $fieldid . "\">" . $fieldinfo['title'] . "" . "</a></span>\n";
                    if ( $fieldinfo['numsubfield'] > 0 )
                    {
                       $html .= draw_field_archives_sub( $fieldid );
                    }
                    $html .= "</li>";
                }
            }
        }
        return $html;
    }
}
if ( ! function_exists( 'draw_field_archives_sub' ) )
{
    function draw_field_archives_sub ( $pid )
    {
        global $module_archives_field;
        $html = "<ul>";
        foreach ( $module_archives_field as $fieldid => $fieldinfo )
        {
            if ( $fieldinfo['parentid'] == $pid )
            {
                $fieldinfo['title0'] = nv_clean60( $fieldinfo['title'], 100 );
                $html .= "<li>\n";
                $html .= "	<span class=\"folder\"><a href=\"" . $fieldinfo['link'] . "\" id=\"" . $fieldid . "\" title=\"" . $fieldinfo['title'] . "\" onclick=\"openlink(this)\" >" . $fieldinfo['title0'] . "" . "</a></span>\n";
                if ( $fieldinfo['numsubfield'] > 0 )
                {
                    $html .= draw_field_archives_sub( $fieldid );
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
    global $site_mods, $module_name, $global_archives_field, $module_archives_field;
    $module = $block_config['module'];
    if ( isset( $site_mods[$module] ) )
    {
        if ( $module == $module_name )
        {
            $module_archives_field = $global_archives_field;
            unset( $module_archives_field[0] );
        }
        else
        {
            $module_archives_field = array();
            $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_field ORDER BY orders ASC";
            $list = nv_db_cache( $sql, 'fieldid', $module );
            foreach ( $list as $l )
            {
                $module_archives_field[$l['fieldid']] = $l;
                $module_archives_field[$l['fieldid']]['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=viewfield/" . $l['alias']."-".$l['fieldid'];
            }
        }
        $content = nv_block_fieldtree_archives($block_config);
    }
}

?>