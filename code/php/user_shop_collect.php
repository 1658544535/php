<?php

define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'user_shop_collectBean.php';
require_once  LOGIC_ROOT.'user_shopBean.php';

$act 		= !isset($_REQUEST['act']) ? '' : $_REQUEST['act'];
$return_url = !isset($_REQUEST['return_url']) || ($_GET['return_url'] == '') ? '/index' : $_GET['return_url'];
$ib 		= new user_shop_collectBean();
$ub 		= new user_shopBean();


if( $openid == null )
{
	redirect("login.php?dir=user_shop_collect");
	return;
}
else if ( $user == null )
{
	redirect("user_binding?dir=user_shop_collect");
	return;
}

switch($act)
{
/*============== 添加收藏 ===============*/
	case 'add' :
		$ib  = new user_shop_collectBean();
	   	$ub  = new user_shopBean();
		$sid = $_REQUEST['sid'] == null ? 0 : intval($_REQUEST['sid']);
		$obj = $ib->detail_fav($db,$userid,$sid);
		if($obj!=null)
		{
			echo "已收藏过该店铺";
			return;
		}

		$objs=$db->get_row("select * from user_shop where id='".$sid."' and status=1");
		echo $ib->create($userid,$sid,$objs->user_id,$db);
		return;
	break;

/*============== 删除处理页面 ===============*/
	case 'del':
		$ib = new user_shop_collectBean();
		$shop_id = intval($_REQUEST['id']);
		if ( $shop_id > 0 )
		{
			$ib->deletedate($db,$userid,$shop_id);
		}
		return;
	break;

/*============== 默认页面 ===============*/
	default:
		$favoriteList = $ib->get_results_userid($db,$userid);
		include "tpl/user_shop_collect_web.php";

}



?>
