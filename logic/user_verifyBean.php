<?php
if ( !defined('HN1') ) die("no permission");


class user_verifyBean
{
	/*
	 * 	功能： 判断手机号和验证码是否一致
	 * 	参数：
	 * 	$db:数据库对象
	 *  $phone:手机号
	 * */
	function verify($db, $phone)
	{
		$sql = "SELECT `captcha` FROM `user_verify` WHERE `loginname`='".$phone."' ORDER BY `id` DESC LIMIT 1";
		return $db->get_row($sql)->captcha;
	}

}
?>
