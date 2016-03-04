<?php

/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! nv_function_exists( 'nv_archives_category' ) )
{

    function nv_block_config_archives_category ( $module, $data_block, $lang_block )
    {
        global $db, $language_array;
        $html .= "<input type=\"text\" value=\"".$data_block['title_length']."\" name=\"config_title_length\" />";
        return '<tr><td>' . $lang_block['title_length'] . '</td><td>' . $html . '</td></tr>';
    }

    function nv_block_config_archives_category_submit ( $module, $lang_block )
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['title_length'] = $nv_Request->get_int( 'config_title_length', 'post', 0 );
        return $return;
    }

    function nv_archives_category ( $block_config )
    {
        global $module_archives_cat, $module_info, $lang_module,$global_config,$site_mods;
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
    	if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $mod_file . "/block_category.tpl") )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        $xtpl = new XTemplate( "block_category.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/laws" );
        $xtpl->assign( 'LANG', $lang_module );
        if ( ! empty( $module_archives_cat ) )
        {
            $title_length = $block_config['title_length'];
            $xtpl->assign( 'LANG', $lang_module );
            $xtpl->assign( 'BLOCK_ID', $block_config['bid'] );
            $xtpl->assign( 'TEMPLATE', $block_theme );
            $html = "";
            foreach ( $module_archives_cat as $cat )
            {
                if ( $cat['parentid'] == 0 )
                {
                    $html .= "<li>\n";
                    $html .= "<a title=\"" . $cat['title'] . "\" href=\"" . $cat['link'] . "\">" . nv_clean60( $cat['title'], $title_length ) . "</a>\n";
                    if ( ! empty( $cat['subcatid'] ) ) $html .= nv_archives_sub_category( $cat['subcatid'], $title_length );
                    $html .= "</li>\n";
                }
            }
            $xtpl->assign( 'HTML_CONTENT', $html );
            $xtpl->parse( 'main' );
            return $xtpl->text( 'main' );
        }
    }

    function nv_archives_sub_category ( $list_sub, $title_length )
    {
        global $module_archives_cat;
        if ( empty( $list_sub ) )
        {
            return "";
        }
        else
        {
            $list = explode( ",", $list_sub );
            $html = "<ul>\n";
            foreach ( $list as $catid )
            {
                $html .= "<li>\n";
                $html .= "<a title=\"" . $module_archives_cat[$catid]['title'] . "\" href=\"" . $module_archives_cat[$catid]['link'] . "\">" . nv_clean60( $module_archives_cat[$catid]['title'], $title_length ) . "</a>\n";
                if ( ! empty( $module_archives_cat[$catid]['subcatid'] ) ) $html .= nv_archives_sub_category( $module_archives_cat[$catid]['subcatid'], $title_length );
                $html .= "</li>\n";
            }
            $html .= "</ul>\n";
            return $html;
        }
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
        $content = nv_archives_category( $block_config );
    }
}

