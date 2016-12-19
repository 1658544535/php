<?php
/**
 * 公共函数
 */
/**
 * 生成URL
 *
 * @param string $ctl 控制器名
 * @param string $act 方法名
 * @param array $param 参数，array(参数名=>参数值)
 * @return string
 */
function url($ctl='', $act='', $param=array()){
    $url = array();
    (strlen($ctl) != 0) && $url[] = 'c='.$ctl;
    (strlen($act) != 0) && $url[] = 'a='.$act;
    foreach($param as $k => $v){
        $url[] = $k.'='.urlencode($v);
    }
    return 'index.php?'.implode('&', $url);
}

/**
 * 渲染模板
 *
 * @param string $tpl 模板文件名
 */
function renderTpl($tpl, $data=null){
    is_array($data) && extract($data);
    require_once(TPL_DIR.$tpl.'_tpl.php');
}

/**
 * 生成分页字符串
 *
 * @param integer $count 记录总数
 * @param integer $persize 每页显示的记录数
 * @param integer $page 当前页数
 * @param string $urlLink 链接
 * @param array $cfg 额外设置
 * @return string
 */
function genPageStr($count, $persize, $page, $urlLink, $cfg=array()){
    include_once(MODULE_LIB.'Pages.class.php');
    $pageCfg = array(
        'show_page_num'		=> 5,
        'cur_index_page'	=> 3,
        'first_page_text'	=> '第一页',
        'last_page_text'	=> '最后一页',
        'pre_page_text'		=> '上一页',
        'next_page_text'	=> '下一页',
        'page_css'			=> 'page_class_name',
        'cur_page_css'		=> 'cur_page_class_name',
        'page_style'		=> 'page_style_item',
        'cur_page_style'	=> 'cur_page_style_item',
        'link_symbol'		=> '=',
        'show_first_last'	=> true,
        'show_simple_page'	=> true,
        'show_items'        => true,
    );
    $cfg = array_merge($pageCfg, $cfg);
    $objPage = new Pages($count, $persize, $page, $urlLink, $cfg);
    return $objPage->generatePages();
}
?>