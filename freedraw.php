<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22 0022
 * Time: 14:32
 */
define('HN1', true);
require_once('./global.php');

$act  = CheckDatas('act', '');
$Type = CheckDatas('type', 1);

//获取分享内容
$fx = apiData('getShareContentApi.do',array('type'=>21,'id'=>21));
$fx = $fx['result'];


switch ($act)
{
    default:
//        获取顶端banner图
        $Banner = apiData('activityBannerApi.do',array('type'=>1));
        $Banner = $Banner['result'];
        include_once('tpl/freedraw_list_web.php');
        break;
}
