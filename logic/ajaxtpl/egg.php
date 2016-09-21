<?php
define('HN1', true);
require_once('../global.php');
define('SCRIPT_ROOT',  substr(dirname(__FILE__), 0, -7));

$pn =$_REQUEST['pn'] == null ? '0' : intval($_REQUEST['pn']);
$openid =$_REQUEST['openid'] == null ? '0' : $_REQUEST['openid'];

//判断用户是否登录
$user = $_SESSION['userinfo'];
$userid = $user->id;
if($userid<1||$user==null){
		echo "-1";//请关注田园优品服务号后登录参与活动;
		exit();
}

//判断用户的抽奖记录是否存在
$sql = "select * from egg_number where userid = '".$userid."'";
$obj = $db->get_row($sql);
	if($obj!=null&&$obj->number>2){//抽奖次数3则无法再抽
		echo "-2";//"您的抽奖次数已满，期待您的好友帮您抽到奖品，感谢参与！";
		exit();
	}else{//用户抽奖次数少于3次继续抽奖
		if($obj!=null&&$obj->number>0){
			$db->query("update egg_number set number='".($obj->number+1)."',updateTime='".time()."' where userid = '".$userid."'");
		}else{
			$db->query("insert into egg_number (userid,openid,number,addTime,updateTime,prizenumber) values ('".$userid."','".$openid."','1','".time()."','".time()."','')");
		}
	}
if($pn==39&&$obj->prizenumber==''){
	$prizenumber=rand(100000,900000);
	$db->query("update egg_number set prizenumber='".($obj->number.",".$prizenumber)."',updateTime='".time()."' where userid = '".$userid."'");
	//消息通知获奖用户
	create_openid_prize_message($user->openid,$prizenumber,"http://gz-ugarden.com/egg_address.php");
	if($obj->openid!='0'){
		$prizenumber2=$userid."-".rand(100000,900000);
		$sql = "select * from user where openid = '".$obj->openid."'";
		$obj_user = $db->get_row($sql);
		$db->query("update egg_number set prizenumber='".($obj->number.",uid:".$prizenumber2)."',updateTime='".time()."' where userid = '".$obj_user->id."'");

	/**	$db->query("update egg_number set prizenumber='".($obj->number.",uid:".$prizenumber2)."',updateTime='".time()."' where openid = '".$obj->openid."'");*/
		//消息通知邀请者同时获奖用户
		create_openid_prize_message($obj->openid,$prizenumber2,"http://gz-ugarden.com/egg_address.php");
	}
}



?>
