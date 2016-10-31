<?php
/**
 * 秒杀列表
 */
define('HN1', true);
require_once('./global.php');

$type = intval($_GET['t']);
!in_array($type, array(1,2,3)) && $type = 1;

$info = apiData('secKillListApi.do', array('type'=>$type));
$info = $info['result'];

$_wxShareDef['link'] = true;

include "tpl/seckill_web.php";
?>