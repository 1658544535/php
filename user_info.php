<?php

define('HN1', true);
require_once('./global.php');

/*----------------------------------------------------------------------------------------------------
	-- 判断登录
-----------------------------------------------------------------------------------------------------*/
IS_USER_LOGIN();


/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$HistoryModel 				= D('History');
$ProductModel 				= D('Product');
$UserSpecialCollectModel 	= D('UserSpecialCollect');
$UserCollectModel 			= D('UserCollect');
$UserCouponModel 			= D('UserCoupon');
$act 		  				= CheckDatas( 'act', '' );
$return_url  				= CheckDatas( 'return_url', '/user' );

switch($act)
{

	/*----------------------------------------------------------------------------------------------------
		-- 足迹列表记录
	-----------------------------------------------------------------------------------------------------*/
	case 'history':
		if ( $user == null )
		{
			redirect("user_binding?dir=favorites");
			return;
		}

		$user_history = $HistoryModel->getHistoryList( $userid );
		$arrHistory   = array();

		if ( is_array($user_history) )
		{
			foreach( $user_history as $k=>$history )
			{
				$key = date( 'm-d', strtotime( $history->update_date ) );
				$arrHistory[$key][$k] = $history;
				$productInfo 	= $ProductModel->getProductInfo( $history->business_id, '', $history->activity_id );

				if ( $productInfo != null )
				{
					$arrHistory[$key][$k]->info 			= $productInfo;
				}
			}
		}

		include "tpl/user_history_web.php";
		return;
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 清空浏览记录
	-----------------------------------------------------------------------------------------------------*/
	case 'history_flush':
		$HistoryModel->setHistoryFlush( $userid );
		echo '1';
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 专场收藏列表
	-----------------------------------------------------------------------------------------------------*/
	case 'special_collect':
		if ( $user == null )
		{
			redirect("user_binding?dir=favorites");
			return;
		}

		$favoriteList = $UserSpecialCollectModel->getCollectList( $userid );
		
		$arrFavoriteList = array();

		if ( is_array( $favoriteList ) )
		{
			foreach( $favoriteList as $key=>$favs )
			{
				$arrFavoriteList[$key] = $favs;
				$SpecialShowModel = M('special_show');
				$specialInfo 	= $SpecialShowModel->get( array('id'=>$favs->special_id) );

				if ( $specialInfo != null )
				{
					$arrFavoriteList[$key]->info			= $specialInfo;
				}
			}
		}

		include "tpl/user_special_collect_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 删除指定专场收藏记录
	-----------------------------------------------------------------------------------------------------*/
	case 'special_collect_del':

		$id = CheckDatas( 'id', '' );

		if ( (int)$id == 0 )
		{
			echo get_json_data_public( -1, 'id参数有误！' );
			return;
		}

		$arrWhere = array(
			'user_id'   => $userid,
			'id' 		=> $id
		);

		$rs = $UserSpecialCollectModel->delete( $arrWhere );

		if ( $rs < 1 )
		{
			echo get_json_data_public( -1, '删除有误！' );
			return;
		}

		echo get_json_data_public( 1, '删除成功！' );

	break;


	/*----------------------------------------------------------------------------------------------------
		-- 产品收藏列表
	-----------------------------------------------------------------------------------------------------*/
	case 'product_collect':
		
		include "tpl/favorites_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 删除指定产品收藏记录
	-----------------------------------------------------------------------------------------------------*/
	case 'product_collect_del':

		$id = CheckDatas( 'id', '' );

		if ( (int)$id == 0 )
		{
			echo get_json_data_public( -1, 'id参数有误！' );
			return;
		}

		$arrWhere = array(
			'user_id'   => $userid,
			'id' 		=> $id
		);

		$rs = $UserCollectModel->delete( $arrWhere );

		if ( $rs < 1 )
		{
			echo get_json_data_public( -1, '删除有误！' );
			return;
		}

		echo get_json_data_public( 1, '删除成功！' );
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 更新用户信息操作
	-----------------------------------------------------------------------------------------------------*/
	case "user_edit":
		$info = apiData('myInfoApi.do', array('userId'=>$userid));
		$info = $info['result'];
		include "tpl/user_edit_web.php";
	break;
	case "user_edit_save":
		$username = CheckDatas( 'username', '' );
		$upfile   = $_FILES['userimage'];
		$arr=array();
		$upfile = '@'.$upfile['tmp_name'];
		if($upfile !='@'){
			$arr['file'] = $upfile;
		}
		$arr['name']   = $username;
		$arr['uid']    = $userid;
		
		$user = apiData('editUserInfo.do', $arr,'post');
		redirect('user.php', $user['error_msg']);
	
	break;
	
	/*----------------------------------------------------------------------------------------------------
		-- 用户钱包
	-----------------------------------------------------------------------------------------------------*/
	// 获取钱包余额
	case 'wallet':
		$UserWalletModel 		= M('user_wallet');
		$UserWalletLogModel 	= M('user_wallet_log');
		
		$objUserWalletInfo 		= $UserWalletModel->get( array( 'user_id'=>$userid ) );
		$objUserWalletLogList	= $UserWalletLogModel->getAll( array( 'user_id'=>$userid ) );
		include "tpl/user_wallet_web.php";
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 代金券列表
	-----------------------------------------------------------------------------------------------------*/
	// 获取钱包余额
	case 'coupon':
// 		$from = CheckDatas( 'from', '' );
// 		if ( $from == 'order_comfire' )
// 		{
// 			$link = '/orders.php?act=coupon_add&cid=';
// 			$objUserCouponList = $UserCouponModel->getCanUseCouponList( $userid, $_SESSION['cart_info']['all_price'] );
// 		}
// 		else
// 		{
// 			$link = 'javascript:void(0);';
// 			$objUserCouponList = $UserCouponModel->getUserCouponList( $userid );
// 		}

// 		$arrUserCouponList 		= array();
// 		$time 					= time();

// 		if ( $objUserCouponList != NULL )
// 		{
// 			foreach( $objUserCouponList as $key=>$UserCouponInfo )
// 			{
// 				$arrUserCouponList[$key] = $UserCouponInfo;

// 				if( ! $UserCouponInfo->status || ! $UserCouponInfo->cpn_status )
// 			    {
// 			        $arrUserCouponList[$key]->useStatus = 0;
// 			        $arrUserCouponList[$key]->statusMsg = '不可用';
// 			    }
// 			    elseif( $UserCouponInfo->userconpon_valid_etime && ($UserCouponInfo->userconpon_valid_etime < $time ) )
// 			    {
// 			        $arrUserCouponList[$key]->useStatus = 0;
// 			        $arrUserCouponList[$key]->statusMsg = '已过期';
// 			    }
// 			    elseif($UserCouponInfo->used)
// 			    {
// 			        $arrUserCouponList[$key]->useStatus = 0;
// 			        $arrUserCouponList[$key]->statusMsg = '已使用';
// 			    }
// 			    else
// 			    {
// 			        $arrUserCouponList[$key]->useStatus = 1;
// 			        $arrUserCouponList[$key]->statusMsg = '可使用';
// 			    }

// 				$arrUserCouponList[$key]->validEndTime = $UserCouponInfo->userconpon_valid_etime ? date('Y-m-d', $UserCouponInfo->userconpon_valid_etime) : '永久有效';

// 				//规则
// 				$_content = json_decode( $UserCouponInfo->content, true );
// 				switch($UserCouponInfo->type)
// 				{
// 					case 1://满m减n
// 						$arrUserCouponList[$key]->money = $_content['m'];
// 						$arrUserCouponList[$key]->rule = '订单满'.$_content['om'].'元可用';
// 						break;
// 					case 2://直减
// 						$arrUserCouponList[$key]->money = $_content['m'];
// 						break;
// 				}
// 			}
// 		}

			$page = max(1, intval($_POST['page']));
			$Type = CheckDatas( 'type', '' );
			
			$coupon = apiData('getUserCouponList.do', array('type'=>1,'uid'=>$userid,'pageNo'=>$page));
            


		include "tpl/user_coupon_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 激活代金券操作
	-----------------------------------------------------------------------------------------------------*/
	// 获取钱包余额
	case 'coupon_active':

		$CouponID	= CheckDatas( 'cpnno', '' );

		do
		{
			if ( empty($CouponID) )
			{
				echo get_json_data_public( -1, '请输入代金券券号' );
				break;
			}

			$cpnInfo = $UserCouponModel->getCouponInfo( $CouponID );

			if ( $cpnInfo == NULL )
			{
				echo get_json_data_public( -1, '输入的代金券不存在' );
				break;
			}

			if ( $cpnInfo->user_id > 0 )
			{
				echo get_json_data_public( -1, '此代金券已经激活过' );
				break;
			}

			//$rs = $UserCouponModel->useCoupon( $cpnInfo->coupon_no, $userid, $cpnInfo->source );
			$rs = $UserCouponModel->useCoupon( $cpnInfo->coupon_no, $userid, 5 );

			if ( $rs == 1 )
			{
				echo get_json_data_public( 1, '代金券激活成功' );
			}
			else
			{
				echo get_json_data_public( -1, '代金券激活失败' );
			}
			break;

		}while(0);

	break;

	/*----------------------------------------------------------------------------------------------------
		-- 用户设置页
	-----------------------------------------------------------------------------------------------------*/
	case 'user_set':
		include "tpl/user_set.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 修改密码
	-----------------------------------------------------------------------------------------------------*/
	case "user_set_pwd":
		if ( IS_POST() )
		{
			$SysLoginModel 	= M('sys_login');
			$OldPassword 	= CheckDatas('opwd','');
			$NewPassword 	= CheckDatas('npwd','');
			$RePassword  	= CheckDatas('repwd','');

			do
			{
				if ( $OldPassword == '' || $NewPassword == '' || $RePassword == '' )
				{
					redirect( 'user_info?act=user_set_pwd','缺少参数！' );
				}

				// 获取用户信息
				$user  = $SysLoginModel->get( array('id'=>$userid) );	
				$data  = md5($OldPassword);
				$opwd  = strtoupper($data);
				$data1  = $user->password;
				$opwd2  = strtoupper($data1);
			
				
				if( $opwd != $opwd2 )
				{

					redirect( 'user_info?act=user_set_pwd','您输入的旧密码不正确！' );
					
				}

				if( $NewPassword != $RePassword )
				{
					redirect( 'user_info?act=user_set_pwd','您输入的新密码与确认密码不一致！' );
				}

				// 更新用户信息
				
				$data  = md5($NewPassword);
				$Npwd  = strtoupper($data);
				$SysLoginModel->modify( array( 'password'=> $Npwd) , array('id'=>$userid) );

				// 更新session
				$_SESSION['userinfo'] = $SysLoginModel->get( array('id'=>$userid) );

				redirect( 'user_info?act=user_set_pwd','修改成功，请记住您的新密码！' );

			}while(0);

		}
		else
		{
			include "tpl/user_set_pwd.php";
		}

	break;

	/*----------------------------------------------------------------------------------------------------
		-- 我的拼团
	-----------------------------------------------------------------------------------------------------*/
	case 'groupon':
		include_once('tpl/user_groupon_web.php');
		break;

	/*----------------------------------------------------------------------------------------------------
		-- 我的猜价
	-----------------------------------------------------------------------------------------------------*/
	case 'guess':		
		
		include_once('tpl/user_guess_web.php');
		break;

	/*----------------------------------------------------------------------------------------------------
		-- 用户信息
	-----------------------------------------------------------------------------------------------------*/
	default:

		$UserInfoModel = M('user_info');
		$userInfo = $UserInfoModel->get(array('user_id'=>$userid));

		$selSex = array($userInfo->sex => 'selected');

		
		$objLogin = M('sys_login');
		$user = $objLogin->get(array('id'=>$userid));
		

		$UserBabyModel = M('user_baby');
		$userbaby = $UserBabyModel->get(array('user_id'=>$userid,'is_default'=>1));
		
		
		$selBabySex = array($userbaby->baby_sex => 'selected');
		
		
		include "tpl/user_edit_web.php";
	break;
}

?>
