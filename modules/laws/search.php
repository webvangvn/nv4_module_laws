<?php

/**
 * @Project NUKEVIET 4.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2015 PCD-GROUP. All rights reserved
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 29 May 2015 07:49:53 GMT
 */

if (! defined('NV_IS_MOD_SEARCH')) {
    die('Stop!!!');
}

$db_slave->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $m_values['module_data'] . '_rows')
    ->where('(' . nv_like_logic('title', $dbkeyword, $logic) . ' OR ' . nv_like_logic('hometext', $dbkeyword, $logic) . ' OR ' . nv_like_logic('bodytext', $dbkeyword, $logic) . ')	AND status= 1');

$num_items = $db_slave->query($db_slave->sql())->fetchColumn();

if ($num_items) {
    $array_cat_alias = array();
    $array_cat_alias[0] = 'other';

    $sql_cat = 'SELECT catid, alias FROM ' . NV_PREFIXLANG . '_' . $m_values['module_data'] . '_cat';
    $re_cat = $db_slave->query($sql_cat);
    while (list($catid, $alias) = $re_cat->fetch(3)) {
        $array_cat_alias[$catid] = $alias;
    }

    $link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $m_values['module_name'] . '&amp;' . NV_OP_VARIABLE . '=';

    $db_slave->select('id, title, alias, catid, hometext, bodytext')
        ->order('addtime DESC')
        ->limit($limit)
        ->offset(($page - 1) * $limit);
    $result = $db_slave->query($db_slave->sql());
    while (list($id, $tilterow, $alias, $catid, $hometext, $bodytext) = $result->fetch(3)) {
        $content = $hometext . $bodytext;

        $url = $link . $array_cat_alias[$catid] . '/' . $alias . '-' . $id . $global_config['rewrite_exturl'];

        $result_array[] = array(
            'link' => $url,
            'title' => BoldKeywordInStr($tilterow, $key, $logic),
            'content' => BoldKeywordInStr($content, $key, $logic)
        );
    }
}
