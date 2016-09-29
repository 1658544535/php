<?php
define('HN1', true);
require_once ('global.php');


/*----------------------------------------------------------------------------------------------------
	-- 判断登录
-----------------------------------------------------------------------------------------------------*/
if ( ! $bLogin )
{
	IS_USER_LOGIN();
}


/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$act  	= CheckDatas( 'act', '' );
$from  	= CheckDatas( 'from', '' );		// 来源:如果从确认订单过来的则为：orders
$UserAddressModel = D('UserAddress');
$SysLoginModel    = M('sys_login');
$userid = $user->id;

switch ($act)
{

	/*----------------------------------------------------------------------------------------------------
		-- 设置默认地址操作
	-----------------------------------------------------------------------------------------------------*/
	case 'defaults':				// 设置默认地址操作
		$address_id  = CheckDatas( 'aid', 0 );

		if ( $address_id > 0 )
		{
			// 先将用户全部地址设置为非默认
			$UserAddressModel->modify( array('is_default'=>0), array( 'user_id'=>$userid ) );
			// 将用户指定地址设置为默认
			$UserAddressModel->modify( array('is_default'=>1), array( 'user_id'=>$userid, 'id'=>$address_id ) );
		}

		if ( $from == 'orders' )
		{
			redirect('/address?act=choose');
		}
		else
		{
			redirect('/address?act=manage');
		}

	break;


	/*----------------------------------------------------------------------------------------------------
		-- 添加用户收货地址页面
	-----------------------------------------------------------------------------------------------------*/
	case 'add':
		getAreasJson();

		$SysAreaModel = M( 'sys_area' );
		$provinces= $SysAreaModel->getAll( array( 'pid'=>0 ), '*', '`id` DESC' );

		include "tpl/address_add_web.php";

	break;

	/*----------------------------------------------------------------------------------------------------
		-- 添加用户收货地址操作
	-----------------------------------------------------------------------------------------------------*/
	case 'add_save':

		if( ! IS_POST() )
		{
			redirect('/address','非法操作！');
		}

		$return_url 		= CheckDatas( 'return_url', '/address?act=manage' );
		$userid 			= $user->id;
		$address 			= CheckDatas( 'address', '/address?act=manage' );
		$shipping_firstname = CheckDatas( 'shipping_firstname', 0 );
		$telephone 			= CheckDatas( 'telephone', 0 );
	    $s_province 		= CheckDatas( 's_province', 0 );
		$s_city 			= CheckDatas( 's_city', 0 );
		$s_county 			= CheckDatas( 's_county', '市、县级市' );
		$shipping_address_1 = CheckDatas( 'shipping_address_1', '' );
		$postcode 			= CheckDatas( 'postcode', 0 );

		$arrParam = array(
			'user_id'			=>	$userid,
			'status'			=>	1,
			'province'			=>	$s_province,
			'city'				=>	$s_city,
			'area'				=>	$s_county,
			'address'			=>	$address,
			'consignee'			=>  $shipping_firstname,
			'consignee_phone'	=>	$telephone,
			'create_date'		=>	date('Y-m-d H:i:s'),
			'postcode'			=>	$postcode
		);

		$address_id = $UserAddressModel->add( $arrParam );

		if ( $address_id < 1 )
		{
			redirect('/address?act=add','添加信息有误！');
		}

		if( $address_id > 0 )
		{
			// 校验如果姓名在user表为空，那么就保存收货人姓名到用户昵称
			if( $user->name == '' )
			{
				$rs = $SysLoginModel->modify( array('name'=>'DES'),array('id'=>$userid) );

				if ( $rs == 1 )
				{
					$userinfo =  $SysLoginModel->get( array('id'=>$userid) );
					$_SESSION['userinfo'] = $userinfo;
				}
			}

			if ( $from == 'orders' )
			{
				redirect('/address?act=choose');
			}
			else
			{
				redirect('/address?act=manage');
			}
		}
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 修改用户收货地址页面
	-----------------------------------------------------------------------------------------------------*/
	case 'edit':
		getAreasJson();
		$address_id 	= CheckDatas( 'aids', '' );
		$return_url 	= '/address?act=manage';  					// 如果返回地址为空则说明从个人中心进来，否则是确认订单进来

		if ( $address_id == '' )
		{
			redirect( '/address?act=manage', '非法操作！' );
		}

		// 获取指定地址的信息
	    $address_info   = $UserAddressModel->get( array('id'=>$address_id, 'user_id'=>$userid) );

		$areaIds 		= array();
		$address_info->province && $areaIds[] 	= $address_info->province;
		$address_info->city && $areaIds[] 		= $address_info->city;
		$address_info->area && $areaIds[] 		= $address_info->area;


		// 获取指定地址的省市区信息
		$_areas = $UserAddressModel->getAreaInfo( $areaIds );

		$areas = array();
		foreach($_areas as $v)
		{
			$areas[$v->id] = $v->name;
		}

		$areaArr = array();
		($address_info->province && $areas[$address_info->province]) && $areaArr[] 	= $areas[$address_info->province];
		($address_info->city && $areas[$address_info->city]) && $areaArr[] 			= $areas[$address_info->city];
		($address_info->area && $areas[$address_info->area]) && $areaArr[] 			= $areas[$address_info->area];

		$areaStr = implode(' ', $areaArr);

		include "tpl/address_edit_web.php";

	break;

	/*----------------------------------------------------------------------------------------------------
		-- 修改用户收货地址操作
	-----------------------------------------------------------------------------------------------------*/
	case 'edit_save':
		if( ! IS_POST() )
		{
			redirect('/address','非法操作！');
		}

		$return_url  = CheckDatas( 'return_url', '/address' );
		$address_id  = CheckDatas( 'aid', 0 );

		$address  	 = CheckDatas( 'address', '' );
		$consignee   = CheckDatas( 'shipping_firstname', 0 );
		$telephone   = CheckDatas( 'telephone', '' );
		$s_province  = CheckDatas( 's_province', 0 );
		$s_city  	 = CheckDatas( 's_city', 0 );
		$s_county  	 = CheckDatas( 's_county', 0 );
		$postcode  	 = CheckDatas( 'postcode', 0 );

		if ( (int) $address_id == 0 )
		{
			redirect('/address','非法操作！');
		}

		$arrParam = array(
			'province'			=>	$s_province,
			'city'				=>	$s_city,
			'area'				=>	$s_county,
			'address'			=>	$address,
			'consignee'			=>  $consignee,
			'consignee_phone'	=>	$telephone,
			'postcode'			=>	$postcode
		);

		$arrWhere = array(
			'id'		=> $address_id,
			'user_id'	=> $userid
		);

		$rs = $UserAddressModel->modify( $arrParam, $arrWhere );

		if ( $from == 'orders' )
		{
			redirect('/address?act=choose');
		}
		else
		{
			redirect('/address?act=manage');
		}
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 删除用户收货地址操作
	-----------------------------------------------------------------------------------------------------*/
	case 'del':
		$address_id  = CheckDatas( 'id', 0 );

		if ( (int) $address_id == 0 )
		{
			redirect('/address','非法操作！');
		}

		$rs = $UserAddressModel->delete( array( 'id'=>$address_id, 'user_id'=>$userid ) );
		redirect('/address');
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 用户收货地址列表页面(用于在确认订单时的地址选择)
	-----------------------------------------------------------------------------------------------------*/
	case 'choose':
		$jsonArea = file_get_contents('./data/area.json');
		include "tpl/choose_address_web.php";
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 用户收货地址列表页面
	-----------------------------------------------------------------------------------------------------*/
	default:
		$jsonArea = file_get_contents('./data/area.json');

		include "tpl/manage_address_web.php";
	break;
}
?>