<?php

/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if ( ! nv_function_exists( 'nv_block_newarchives' ) )
{

    function nv_block_config_newarchives_blocks ( $module, $data_block, $lang_block )
    {
        global $db, $language_array;
        $html = "";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['numrow'] . "</td>";
        $html .= "	<td><input type=\"text\" name=\"config_numrow\" size=\"5\" value=\"" . $data_block['numrow'] . "\"/></td>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "	<td>" . $lang_block['height'] . "</td>";
        $html .= "	<td><input type=\"text\" name=\"config_height\" size=\"5\" value=\"" . $data_block['height'] . "\"/> px</td>";
        $html .= "</tr>";
        return $html;
    }

    function nv_block_config_newarchives_blocks_submit ( $module, $lang_block )
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['numrow'] = $nv_Request->get_int( 'config_numrow', 'post', 0 );
        $return['config']['height'] = $nv_Request->get_int( 'config_height', 'post', 0 );
        return $return;
    }

    function nv_block_newarchives ( $block_config )
    {
        global $module_info, $global_config, $site_mods,$db;
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        if ( file_exists( NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $mod_file . "/block_newarchives.tpl" ) )
        {
            $block_theme = $global_config['site_theme'];
        }
        else
        {
            $block_theme = "default";
        }
        $table = "".NV_PREFIXLANG . "_" . $mod_data . "_rows";
        $xtpl = new XTemplate( "block_newarchives.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file );
    	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
    	$xtpl->assign( 'TEMPLATE', $block_theme );
    	$xtpl->assign( 'id', $block_config['bid'] );
    	$xtpl->assign( 'height', $block_config['height'] );
        if ( ! defined( 'JSMARQUEE' ) )
        {
        	$xtpl->parse( 'main.jsmarquee' );
        	define( 'JSMARQUEE', true );
        }
        //select data
        $sql = "SELECT id,title,alias,hometext,view,down FROM " . $table . " ORDER BY id DESC LIMIT 0," . $block_config['numrow'];
        $result = $db->query( $sql );
		$i=1;
        while ( $row = $result->fetch() )
        {
        	$row['linkview'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module . "&" . NV_OP_VARIABLE . "=view/" . $row['alias'] . "-" . $row['id'];
        	$row['hometext'] = nv_clean60($row['hometext'],$block_config['height']);
        	$xtpl->assign( 'ROW', $row );
			if ($i<3) $xtpl->parse( 'main.loop.img' );
        	$xtpl->parse( 'main.loop' );
			$i++;
        }
        $xtpl->parse( 'main' );
        return $xtpl->text( 'main' );
    }
}

if ( defined( 'NV_SYSTEM' ) )
{
    global $site_mods;
    $module = $block_config['module'];
    if ( isset( $site_mods[$module] ) )
    {
        $content = nv_block_newarchives( $block_config );
    }
}

