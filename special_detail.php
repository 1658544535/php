<?php
define('HN1', true);
require_once('./global.php');

/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$SpecialModel 				= D('Special');
$UserSpecialCollectModel 	= D('UserSpecialCollect');
$act = CheckDatas( 'act', 'lists' );
$sid = CheckDatas( 'sid' );
$aid = CheckDatas( 'aid' );




if ( (int)$sid == 0 && (int)$aid == 0 )
{
	redirect('/','非法操作！');
}

/*----------------------------------------------------------------------------------------------------
	-- 获取专场信息
-----------------------------------------------------------------------------------------------------*/
// $objSpecialInfo = $SpecialModel->getSpecialInfo( $sid, $aid );
$objSpecialInfo = $SpecialModel->get( array('activity_id'=>$aid) );
if ( $objSpecialInfo == NULL )
{
	redirect('/','找不到该活动');
}

$dateTip  			= 0;
$seckillTimeDiff 	= 0;

if ( $objSpecialInfo->date_info['type'] == 1 )
{
	$date 				= DataTip( $objSpecialInfo->end_time );
	$dateTip  			= $date['date_tip'];
	$seckillTimeDiff 	= $date['date_time'];
}


/*----------------------------------------------------------------------------------------------------
	-- 该专场是否收藏
-----------------------------------------------------------------------------------------------------*/
$bUserCollect 	  = 0;
if ( $bLogin )
{
	$bUserCollect = $UserSpecialCollectModel->isCollect( $userid, $objSpecialInfo->id, $objSpecialInfo->activity_id );
}

switch( $act )
{
	case "collect":
		/*----------------------------------------------------------------------------------------------------
			-- 专场收藏操作
		-----------------------------------------------------------------------------------------------------*/
		if ( $bUserCollect == 0 )
		{
			// 添加收藏操作
			$rs   =  $UserSpecialCollectModel->CollectAdd( $userid, $objSpecialInfo->id, $objSpecialInfo->activity_id );
			$msg  = '成功添加收藏！';
			$code = 1;

		}
		else
		{
			// 取消收藏操作
			$rs   = $UserSpecialCollectModel->CollectDel( $userid, $objSpecialInfo->id, $objSpecialInfo->activity_id );
			$msg  = '成功取消收藏！';
			$code = 2;
		}

		echo get_json_data_public( $code, $msg );

	break;


	default:
		/*----------------------------------------------------------------------------------------------------
			-- 专场信息
		-----------------------------------------------------------------------------------------------------*/
		$url = "special_detail.php?sid={$sid}&aid={$aid}";

		// 排序规则
		$Col  				= CheckDatas('col', '');
		$OrderByType 		= CheckDatas('order_by', '');
		$OrderByType		= strtoupper($OrderByType);

		// 获取排序对应的URL
		$arrSearchCol = array( 'price','num','hits' );
		foreach( $arrSearchCol as $SearchCol )
		{
			$orderby  				= 'ASC';
			$ColUrl[$SearchCol] 	= "&col={$SearchCol}&order_by=ASC";

			if ( $SearchCol == $Col )
			{
				$orderby = ($OrderByType == 'ASC') ? 'DESC' : 'ASC';
				$ColUrl[$SearchCol] = "&col={$SearchCol}&order_by={$orderby}";
			}
		}

		// 转化传入字段成为数据表字段
		( $Col == 'price' ) && $Col = 'distribution_price';
		( $Col == 'num' )	&& $Col = 'sell_number';


		// 获取专场商品
		if ( $Col == '' || $OrderByType == '' )
		{
			$OrderBy = 'sorting DESC';
		}
		else
		{
			$OrderBy = $Col . ' ' . $orderby;
		}

		$objSpecialProductList = $SpecialModel->getSpecialProductList( $objSpecialInfo->activity_id, $OrderBy );

		include_once( 'tpl/special_detail_web.php' );
}








?>
