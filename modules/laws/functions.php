<?php

/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 29 May 2015 07:49:53 GMT
 */

if ( ! defined( 'NV_SYSTEM' ) ) die( 'Stop!!!' );

define( 'NV_IS_MOD_ARCHIVES', true );

global $global_archives_cat, $global_archives_room, $global_archives_field, $global_archives_organ;
$global_archives_field = $global_archives_organ = $global_archives_room = array();
$page = 1;

$global_archives_cat = array();
$catid = 0;
$parentid = 0;
$alias_cat_url = isset($array_op[0]) ? $array_op[0] : '';
$array_mod_title = array();

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY orders ASC';
$list = $nv_Cache->db($sql, 'catid', $module_name);
foreach ($list as $l) {
    $global_archives_cat[$l['catid']] = $l;
    $global_archives_cat[$l['catid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
    if ($alias_cat_url == $l['alias']) {
        $catid = $l['catid'];
        $parentid = $l['parentid'];
    }
}

/***/
$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=viewroom";
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_room" . " ORDER BY orders ASC";
$result = $db->query( $sql );
while ( $row = $result->fetch() )
{
    $link_i = $link . "/" . $row['alias'] . "-" . $row['roomid'];
    $row['link'] = $link_i;
    $global_archives_room[$row['roomid']] = $row;
}
/***/
$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=viewfield";
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_field" . " ORDER BY orders ASC";
$result = $db->query( $sql );
while ( $row = $result->fetch() )
{
    $link_i = $link . "/" . $row['alias'] . "-" . $row['fieldid'];
    $row['link'] = $link_i;
    $global_archives_field[$row['fieldid']] = $row;
}
/***/
$link = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=vieworgan";
$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_organ" . " ORDER BY orders ASC";
$result = $db->query( $sql );
while ( $row = $result->fetch() )
{
    $link_i = $link . "/" . $row['alias'] . "-" . $row['organid'];
    $row['link'] = $link_i;
    $global_archives_organ[$row['organid']] = $row;
}


$data_config = $module_config[$module_name];
$per_page = $data_config['view_num'];

function nv_archives_page ( $base_url, $num_items, $per_page, $start_item, $add_prevnext_text = true )
{
    global $lang_global;
    $total_pages = ceil( $num_items / $per_page );
    if ( $total_pages == 1 ) return '';
    @$on_page = floor( $start_item / $per_page ) + 1;
    $page_string = "";
    if ( $total_pages > 10 )
    {
        $init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
        for ( $i = 1; $i <= $init_page_max; $i ++ )
        {
            $href = "href=\"" . $base_url . "/page-" . ( ( $i - 1 ) * $per_page ) . "\"";
            $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
            if ( $i < $init_page_max ) $page_string .= " ";
        }
        if ( $total_pages > 3 )
        {
            if ( $on_page > 1 && $on_page < $total_pages )
            {
                $page_string .= ( $on_page > 5 ) ? " ... " : ", ";
                $init_page_min = ( $on_page > 4 ) ? $on_page : 5;
                $init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;
                for ( $i = $init_page_min - 1; $i < $init_page_max + 2; $i ++ )
                {
                    $href = "href=\"" . $base_url . "/page-" . ( ( $i - 1 ) * $per_page ) . "\"";
                    $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
                    if ( $i < $init_page_max + 1 )
                    {
                        $page_string .= " ";
                    }
                }
                $page_string .= ( $on_page < $total_pages - 4 ) ? " ... " : ", ";
            }
            else
            {
                $page_string .= " ... ";
            }
            
            for ( $i = $total_pages - 2; $i < $total_pages + 1; $i ++ )
            {
                $href = "href=\"" . $base_url . "/page-" . ( ( $i - 1 ) * $per_page ) . "\"";
                $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
                if ( $i < $total_pages )
                {
                    $page_string .= " ";
                }
            }
        }
    }
    else
    {
        for ( $i = 1; $i < $total_pages + 1; $i ++ )
        {
            $href = "href=\"" . $base_url . "/page-" . ( ( $i - 1 ) * $per_page ) . "\"";
            $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
            if ( $i < $total_pages )
            {
                $page_string .= " ";
            }
        }
    }
    if ( $add_prevnext_text )
    {
        if ( $on_page > 1 )
        {
            $href = "href=\"" . $base_url . "/page-" . ( ( $on_page - 2 ) * $per_page ) . "\"";
            $page_string = "&nbsp;&nbsp;<span><a " . $href . ">" . $lang_global['pageprev'] . "</a></span>&nbsp;&nbsp;" . $page_string;
        }
        if ( $on_page < $total_pages )
        {
            $href = "href=\"" . $base_url . "/page-" . ( $on_page * $per_page ) . "\"";
            $page_string .= "&nbsp;&nbsp;<span><a " . $href . ">" . $lang_global['pagenext'] . "</a></span>";
        }
    }
    return $page_string;
}

function nv_archives_page2 ( $base_url, $num_items, $per_page, $start_item, $add_prevnext_text = true )
{
    global $lang_global;
    $total_pages = ceil( $num_items / $per_page );
    if ( $total_pages == 1 ) return '';
    @$on_page = floor( $start_item / $per_page ) + 1;
    $page_string = "";
    if ( $total_pages > 10 )
    {
        $init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
        for ( $i = 1; $i <= $init_page_max; $i ++ )
        {
            $href = "href=\"" . $base_url . "&page=" . ( ( $i - 1 ) * $per_page ) . "\"";
            $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
            if ( $i < $init_page_max ) $page_string .= " ";
        }
        if ( $total_pages > 3 )
        {
            if ( $on_page > 1 && $on_page < $total_pages )
            {
                $page_string .= ( $on_page > 5 ) ? " ... " : ", ";
                $init_page_min = ( $on_page > 4 ) ? $on_page : 5;
                $init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;
                for ( $i = $init_page_min - 1; $i < $init_page_max + 2; $i ++ )
                {
                    $href = "href=\"" . $base_url . "&page=" . ( ( $i - 1 ) * $per_page ) . "\"";
                    $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
                    if ( $i < $init_page_max + 1 )
                    {
                        $page_string .= " ";
                    }
                }
                $page_string .= ( $on_page < $total_pages - 4 ) ? " ... " : ", ";
            }
            else
            {
                $page_string .= " ... ";
            }
            
            for ( $i = $total_pages - 2; $i < $total_pages + 1; $i ++ )
            {
                $href = "href=\"" . $base_url . "&page=" . ( ( $i - 1 ) * $per_page ) . "\"";
                $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
                if ( $i < $total_pages )
                {
                    $page_string .= " ";
                }
            }
        }
    }
    else
    {
        for ( $i = 1; $i < $total_pages + 1; $i ++ )
        {
            $href = "href=\"" . $base_url . "&page=" . ( ( $i - 1 ) * $per_page ) . "\"";
            $page_string .= ( $i == $on_page ) ? "<strong>" . $i . "</strong>" : "<a " . $href . ">" . $i . "</a>";
            if ( $i < $total_pages )
            {
                $page_string .= " ";
            }
        }
    }
    if ( $add_prevnext_text )
    {
        if ( $on_page > 1 )
        {
            $href = "href=\"" . $base_url . "&page=" . ( ( $on_page - 2 ) * $per_page ) . "\"";
            $page_string = "&nbsp;&nbsp;<span><a " . $href . ">" . $lang_global['pageprev'] . "</a></span>&nbsp;&nbsp;" . $page_string;
        }
        if ( $on_page < $total_pages )
        {
            $href = "href=\"" . $base_url . "&page=" . ( $on_page * $per_page ) . "\"";
            $page_string .= "&nbsp;&nbsp;<span><a " . $href . ">" . $lang_global['pagenext'] . "</a></span>";
        }
    }
    return $page_string;
}

function nv_fix_cat_row ( $catid = 0 )
{
    global $db, $db_config, $module_name, $module_data;
    $query = "SELECT count(*) FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE catid='" . $catid . "'";
    $result = $db->query( $query );
    $num = $result->fetch();
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET numrow='" . $num . "' WHERE catid='" . intval( $catid )."'";
    $db->query( $sql );

}

function nv_fix_catall_row ( )
{
    global $global_archives_cat;
    foreach ( $global_archives_cat as $catid_i => $catinfo_i )
    {
        nv_fix_cat_row( $catid_i );
    }
}

function drawselect_status ( $select_name = "", $array_control_value, $value_curent = 0, $func_onchange = "", $enable = "" )
{
    $html = '<select name="' . $select_name . '" id="id_' . $select_name . '" onchange="' . $func_onchange . '" ' . $enable . '>';
    foreach ( $array_control_value as $val => $title )
    {
        $select = ( $val == $value_curent ) ? "selected=\"selected\"" : "";
        $html .= '<option value="' . $val . '" ' . $select . '>' . $title . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function redict_link ( $lang_view, $lang_back, $nv_redirect )
{
    global $lang_module;
    $contents = "<div class=\"frame\">";
    $contents .= $lang_view . "<br />\n";
    $contents .= "<img border=\"0\" src=\"" . NV_BASE_SITEURL . "images/load_bar.gif\"><br />\n";
    $contents .= "<a href=\"" . $nv_redirect . "\">" . $lang_back . "</a>";
    $contents .= "</div>";
    $contents .= "<meta http-equiv=\"refresh\" content=\"2;url=" . $nv_redirect . "\" />";
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_site_theme( $contents );
    include ( NV_ROOTDIR . "/includes/footer.php" );
    exit();
}


function check_upload ( )
{	
    global $data_config, $user_info, $op, $module_name;

    if ( $data_config['who_upload'] == 0 ) return true;
    elseif ( $data_config['who_upload'] == 1 )
    {
        if ( ! defined( 'NV_IS_USER' ) )
        {
            $redirect = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op;
            Header( "Location: " . NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=users&" . NV_OP_VARIABLE . "=login&nv_redirect=" . nv_base64_encode( $redirect ) );
            die();
        }
    }
    elseif ( $data_config['who_upload'] == 2 )
    {
        if ( ! defined( 'NV_IS_ADMIN' ) )
        {
            $redirect = NV_BASE_SITEURL . "admin/index.php";
            Header( "Location: " . $redirect );
            die();
        }
    }
    elseif ( $data_config['who_upload'] == 3 )
    {
        if ( ! defined( 'NV_IS_USER' ) )
        {
            $redirect = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op;
            Header( "Location: " . NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=users&" . NV_OP_VARIABLE . "=login&nv_redirect=" . nv_base64_encode( $redirect ) );
            die();
        }
        elseif ( empty( $data_config['groups_view'] ) )
        {
            Header( "Location: " . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name );
            die();
        }
        else
        {
			if(!nv_user_in_groups($data_config['groups_view'] ))
			{
				Header( "Location: " . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name );
                die();
			}
        }
    }
}

function check_upload2 ( )
{
    global $data_config, $user_info, $op, $module_name;
    if ( $data_config['who_upload'] == 0 ) return true;
    elseif ( $data_config['who_upload'] == 1 )
    {
        if ( ! defined( 'NV_IS_USER' ) ) return false;
        else return true;
    }
    elseif ( $data_config['who_upload'] == 2 )
    {
        if ( ! defined( 'NV_IS_ADMIN' ) ) return false;
        else return true;
    }
    elseif ( $data_config['who_upload'] == 3 )
    {
        if ( ! defined( 'NV_IS_USER' ) )
        {
            return false;
        }
    	elseif ( empty( $data_config['groups_view'] ) )
        {
            return false;
        }
        else
        {
			
            if(nv_user_in_groups($data_config['groups_view'] ))
			{
				return true;
			}else{
				return false;
			}
        }
    }
}

$count_op = sizeof($array_op);
if (! empty($array_op) and $op == 'main') {
    $op = 'main';
    if ($count_op == 1 or substr($array_op[1], 0, 5) == 'page-') {
        if ($count_op > 1 or $catid > 0) {
            $op = 'viewcat';
            if( isset($array_op[1]) and substr($array_op[1], 0, 5) == 'page-' ){
                $page = intval(substr($array_op[1], 5));   
            }
        }
        elseif ($catid == 0) {
            $contents = $lang_module['nocatpage'] . $array_op[0];       
            if (isset($array_op[0]) and substr($array_op[0], 0, 5) == 'page-') {
                $page = intval(substr($array_op[0], 5));
            }
        }
    } elseif ($count_op == 2) {
        $array_page = explode('-', $array_op[1]);
        $id = intval(end($array_page));
        $number = strlen($id) + 1;
        $alias_url = substr($array_op[1], 0, -$number);
        if ($id > 0 and $alias_url != '') {
            if ($catid > 0) {
				$op = 'view';
			} else {
				//muc tieu neu xoa chuyen muc cu hoac doi ten alias chuyen muc thi van rewrite duoc bai viet
				$_row = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id = ' . $id )->fetch();
				if (!empty($_row) and isset($global_archives_cat[$_row['catid']])) {
    				$url_Permanently = nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_archives_cat[$_row['catid']]['alias'] . '/' . $_row['alias'] . '-' . $_row['catid'] . $global_config['rewrite_exturl'], true );
    				header( "HTTP/1.1 301 Moved Permanently" );
    				header( 'Location:' . $url_Permanently );
    				exit();
				}
			}
        }
    }
    $parentid = $catid;
    while ($parentid > 0) {
        $array_cat_i = $global_archives_cat[$parentid];
        $array_mod_title[] = array(
            'catid' => $parentid,
            'title' => $array_cat_i['title'],
            'link' => $array_cat_i['link']
        );
        $parentid = $array_cat_i['parentid'];
    }
    sort($array_mod_title, SORT_NUMERIC);
}