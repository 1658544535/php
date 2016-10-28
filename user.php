<?php
define('HN1', true);
require_once('./global.php');

$info = apiData('myInfoApi.do', array('userId'=>$userid));

$info = $info['result'];
!empty($info['couponBTime']) && $info['couponBTime'] = strtotime($info['couponBTime']);
!empty($info['couponETime']) && $info['couponETime'] = strtotime($info['couponETime']);
empty($info['groupingNum']) && $info['groupingNum'] = 0;
empty($info['waitSendNum']) && $info['waitSendNum'] = 0;
empty($info['waitRecNum']) && $info['waitRecNum'] = 0;
empty($info['waitComNum']) && $info['waitComNum'] = 0;
empty($info['saleSerNum']) && $info['saleSerNum'] = 0;

$_wxUserInfo = $objWX->getUserInfo($openid);

//没有头像则获取微信头像
if($info['userImage'] == ''){
	$info['userImage'] = $_wxUserInfo['headimgurl'] ? $_wxUserInfo['headimgurl'] : '/images/def_user.png';
}
//(($info['userImage'] == '') && $_wxUserInfo['headimgurl']) && $info['userImage'] = $_wxUserInfo['headimgurl'];

$footerNavActive = 'user';
include "tpl/user_web.php";
?>
