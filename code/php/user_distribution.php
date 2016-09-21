<?php
define('HN1', true);
require_once('./global.php');

require_once  LOGIC_ROOT.'sys_loginBean.php';
//require_once  LOGIC_ROOT.'user_consumerBean.php';
require_once  LOGIC_ROOT.'user_distribution_infoBean.php';
require_once  FUNC_ROOT.'func_user_invite.php';

$return_url = (!isset($_GET['return_url']) || ($_GET['return_url'] == '')) ? '/user' : $_GET['return_url'];
$act 	= ! isset($_REQUEST['act']) ? '' : $_REQUEST['act'];
$user 	= $_SESSION['userinfo'];


if( $openid == null )
{
	redirect("login.php?dir=user");
	return;
}
else if ( $user == null )
{
	redirect("user_binding?dir=user_distribution");
	return;
}

$userid = $user->id;

$user_distribution_info = new user_distribution_infoBean( $db, 'user_distribution_info' );
$func_user_invite 		= new func_user_invite( $app_info['appid'], $app_info['secret'] );
$func_user_invite->db   = $db;
$func_user_invite->log 	= $log;


/*===================== 申请提交操作 ======================*/
switch($act)
{
   case 'post':
		$name 		     = $_REQUEST['name']	 	    == null ? '' : $_REQUEST['name'];
	    $sex 	         = $_REQUEST['sex']             == null ? '' : $_REQUEST['sex'];
	    $person_code 	 = $_REQUEST['person_code']     == null ? '' : $_REQUEST['person_code'];
		$file_name 		 = '';
	    if (isset($_FILES['person_code_img']['name']))
		{
			$file_name 		 = $site . 'upfiles/user_distribution_info/' . uploadfile( 'person_code_img',  './upfiles/user_distribution_info/');
		}

		$param = array(
			'user_id' 		  => intval($userid),
			'name'			  => $name,
			'sex'			  => $sex,
			'person_code'	  => $person_code,
			'person_code_img' => $file_name,
	        'create_date'	  => date("Y-m-d H:i:s",time())
		);

		$rs = $user_distribution_info->create( $param );

		redirect('user','申请成功！');
	break;

	case 'lists':
		$type 		 		= !isset($_REQUEST['type'])	 ? 1 : $_REQUEST['type'];

		if ( $type == 2 )		// 推荐者列表
		{
			$record_list 	= $func_user_invite->get_inviter_list( $userid );
		}
		else					// 订单列表
		{
			$rs_type 		= !isset($_REQUEST['uid'])	 ? 0 : $_REQUEST['uid'];
			$record_list	= $func_user_invite->get_inviter_order_list( $userid, $rs_type );
		}

		include "tpl/user_distribution_list_web.php";

	break;

  	default:
  		/*===================== 页面显示操作 ======================*/
		$arrWhere = array(
			'user_id' => $userid
		);

		$rs =  $user_distribution_info->get_list( $arrWhere );

		$status_info = array(
			'-1'  =>  array('icon'=>'icon_warm','desc'=>'审核未通过'),
			'0'   =>  array('icon'=>'icon_loading','desc'=>'审核中'),
			'1'   =>  array('icon'=>'icon_pass','desc'=>'通过审核')
		);

		if ( $rs  == null )
		{
			include "tpl/user_distribution_web.php";
			return;
		}

		$rs =  $rs[0];

		if ( $rs->status != 1 )
		{
			include "tpl/user_distribution_apply_web.php";
			return ;
		}

		$inviter_list 			= $func_user_invite->get_inviter_list( $rs->user_id );
		$order_list   			= $func_user_invite->get_inviter_order_list( $rs->user_id );
		$inviter_count 			= count($inviter_list);									// 累计推荐者
		$order_count 			= count( $order_list );									// 累计订单数
		$amout_count 			= 0; 													// 累计总金额

		if ( $order_list != null )
		{
			foreach ( $order_list as $info )
			{
				$amout_count += $info->all_price;
			}
		}

		include "tpl/user_distribution_index_web.php";

}

?>