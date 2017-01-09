<?php
define('HN1', true);
require_once('./global.php');

IS_USER_LOGIN();

//积分商城
$jfscUrl = 'http://wx.zhijianec.cn/app/./index.php?i=261&c=entry&pid=364&op=good&do=rank&m=junsion_poster';

header('location:'.$jfscUrl);
?>