<?php
/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM 
 */

if ( ! defined( 'NV_IS_MOD_ARCHIES' ) ) die( 'Stop!!!' );

if ( ! function_exists( 'nv_block_archives_search' ) )
{
    function nv_block_archives_search ()
    {
        global $lang_module,$module_name, $module_data, $module_file, $module_config, $module_info, $global_archives_cat,$nv_Request,$array_op;
        $q = $nv_Request->get_string( 'q', 'get', '' );
        $oid = $nv_Request->get_int( 'catid', 'get', 0 );
        if ( ! empty( $global_archives_cat ))
    	{
    		$xtpl = new XTemplate( "block_search.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
    		$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
        	$xtpl->assign( 'SEARCH', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=search" );
        	$xtpl->assign( 'LANG', $lang_module );
	        foreach ( $global_archives_cat as $catid => $catinfo )
	        {
	            if ( $catinfo['parentid'] == '0' )
	            {
	            	$xtpl->assign( 'ROW', $catinfo );
	            	$xtpl->parse( 'main.loop' );
	            }
	            $xtitle = "";
			    if ( $catinfo['lev'] > 0 )
			    {
			        for ( $i = 1; $i <= $catinfo['lev']; $i ++ )
			        {
			            $xtitle .= "&nbsp;&nbsp;&nbsp;&nbsp;";
			        }
			    }
			    $catinfo['xtitle'] = $xtitle . $catinfo['title'];
			    $catinfo['select'] = ( $catinfo['catid'] == $oid ) ? "selected=\"selected\"" : "";
			    $xtpl->assign( 'PAR', $catinfo );
			    $xtpl->parse( 'main.parent_loop' );
	        }
	        $xtpl->assign( 'text_search', $q );
	        $xtpl->parse( 'main' );
        	return $xtpl->text( 'main' );
    	}
        return "";
    }
}

$content = nv_block_archives_search();

