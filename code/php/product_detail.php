<?php

define('HN1', true);
require_once('./global.php');

/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
//兼容APP不同版本传递的参数
if(!isset($_REQUEST['pid']) && isset($_REQUEST['product_id'])){
	$_REQUEST['pid'] = $_REQUEST['product_id'];
}


$act  = CheckDatas( 'act', 'info' );
$pid  = CheckDatas( 'pid', 0 );
$aid  = CheckDatas( 'aid', '' );

$atype = CheckDatas( 'type', 3 );					// 判断活动类别
$return_url = CheckDatas( 'return_url', '/' );

$activeId = (isset($_GET['acid']) || !empty($_GET['acid'])) ? intval($_GET['acid']) : 0;
$ProductModel 			= D('Product');
$SyntheticalDictModel 	= M('synthetical_dict');
$UserCollectModel 		= D('UserCollect');
$UserShopModel          = M('user_shop');


require_once LOGIC_ROOT.'productBean.php';
require_once LOGIC_ROOT.'user_commentBean.php';
require_once LOGIC_ROOT.'user_shopBean.php';

$product 		= new productBean();
$user_shop 		= new user_shopBean();
$user_comment 	= new user_commentBean();




/*----------------------------------------------------------------------------------------------------
	-- 获取商品的信息及相关的SKU
-----------------------------------------------------------------------------------------------------*/
$pid = CheckDatas( 'pid', 0 );

if ( (int)$pid == 0 )
{
	redirect( $return_url, '找不到该商品！' );
	exit;
}

// 获取商品信息

$objProductInfo = $ProductModel->getProductInfo( $pid, '', $aid, $atype  );
// $objProductInfo = $ProductModel->get(array('id'=>$pid));




//判断是否为自营商品
$objShop        = $UserShopModel->get(array('user_id'=>$objProductInfo->user_id));


if ( $objProductInfo ==null )
{
	redirect( $return_url, '该商品已下架！' );
}

//if ( $objProductInfo->enable == 0 )
//{
//	redirect( $return_url, $objProductInfo->msg_tip );
//}


/*----------------------------------------------------------------------------------------------------
	-- 获取颜色SKU列表
-----------------------------------------------------------------------------------------------------*/
$sku_color_list  = $ProductModel->getSkuList( $pid,  $type='color');


/*----------------------------------------------------------------------------------------------------
	-- 获取规格SKU列表
-----------------------------------------------------------------------------------------------------*/
$sku_format_list = $ProductModel->getSkuList( $pid,  $type='format');


switch($act)
{
	case 'price':
		$productId   	= CheckDatas( 'pid', '' );
		$skuColorId  	= CheckDatas( 'scid', '' );
		$skuFormatId 	= CheckDatas( 'sfid', '' );

		$skuInfo 		= $ProductModel->getSkuInfo( $productId, $skuColorId, $skuFormatId, $objProductInfo->activity_id );

		if ( $skuInfo == null )
		{
			
			echo get_json_data_public( -1, 'sku信息缺省' );
			return ;
		}

		$onjProductInfo  = $ProductModel->getProductInfo( $productId, $skuInfo->Id, $objProductInfo->activity_id );

		$result['skuid'] = $onjProductInfo->sku_link_id;
		$result['price'] = sprintf('%.1f',$onjProductInfo->distribution_price);

		echo get_json_data_public( 1, '成功获取参数', $result );
	break;


	case 'sku_color':
		$sku_id = CheckDatas( 'sid', '' );

		do
		{
			if ( $sku_id > 0 )
			{
				$rs = $ProductModel->getValidSku('color', $pid, $sku_id, $objProductInfo->activity_id );

				foreach( $sku_color_list as $key=>$info )
				{
					if ( isset( $rs[$key] ) )
					{
						$sku_color_list[$key]->has = 1;
					}
					else
					{
						$sku_color_list[$key]->has 	= 0;
					}
				}
			}
			else
			{
				foreach( $sku_color_list as $key=>$info )
				{
					$sku_color_list[$key]->has = 1;
				}
			}

		}while(0);

		echo get_json_data_public( 1, '成功获取参数', $sku_color_list );
	break;


	case 'sku_format':
		$sku_id = CheckDatas( 'sid', '' );
		$arr		= array( 'code'=>1,'msg'=>'成功获取参数','data'=>'' );

		do
		{
			if ( $sku_id > 0 )
			{
				$rs = $ProductModel->getValidSku('format', $pid, $sku_id, $objProductInfo->activity_id );

				foreach( $sku_format_list as $key=>$info )
				{
					if ( isset( $rs[$key] ) )
					{
						$sku_format_list[$key]->has = 1;
					}
					else
					{
						$sku_format_list[$key]->has = 0;
					}
				}
			}
			else
			{
				foreach( $sku_format_list as $key=>$info )
				{
					$sku_format_list[$key]->has = 1;
				}
			}

		}while(0);

		echo get_json_data_public( 1, '成功获取参数', $sku_format_list );
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 商品图文详情
	-----------------------------------------------------------------------------------------------------*/
	case 'desc':
		$content 	= $objProductInfo->content;
	    $version 	= $objProductInfo->version;
	//截取文本图文内容方法		
		
     	
     	$url = split('>',$content);
	     	foreach ($url as $u){
	     		$ok=preg_replace('/(img.+src=\"?.+)(\/upfiles\/)(.+\.\"?.+)/i',"\${1}$site_image\${3}",$u);
	     		$url2 .= $ok.'>';
	     	}
     	$i=strlen($url2);
     	$url3=substr($url2,0,$i-1);
		
     	
     	
     	
		$ProductImagesModel = M('product_images');
		$imageList 	= $ProductImagesModel->getAll( array('product_id'=>$pid, 'status'=>1), 'images', '`Sorting` ASC');
	
		include "tpl/product_description_web.php";
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 买家口碑页面
	----------------------------------------------------------------------------------------------------*/
	case 'comment':
		include "tpl/comment_product_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 买家口碑（评论列表 用于ajax调用）
	-----------------------------------------------------------------------------------------------------*/
	case 'comment_content':
		$nScore 			= CheckDatas( 'score', 0 );

		$UserCommentModel 	= M('user_comment');

		$arrParam 			= array('product_id'=>$pid, 'status'=>1);
		if ( $nScore > 0 )
		{
			$arrParam['score'] = $nScore;
		}

		$commentList 	  = $UserCommentModel->getAll( array('product_id'=>$pid, 'status'=>1), array('score','score_product','user_name','comment','create_date'), '`id` DESC');

		if ( $commentList == NULL )
		{
			echo get_json_data_public( -1, '评论结果为空' );
		}
		else
		{
			echo get_json_data_public( 1, '评论返回结果', $commentList );
		}
	break;





	/*----------------------------------------------------------------------------------------------------
		-- 商品收藏操作
	-----------------------------------------------------------------------------------------------------*/
	case 'collect':

		$pid 			= CheckDatas( 'pid', 0 );
		if ( (int)$pid == 0 )
		{
			redirect( '/', '找不到该商品！' );
		}

		// 获取商品信息
		$objProductInfo = $ProductModel->getProductInfo( $pid );
		if ( $objProductInfo == null )
		{
			redirect( '/', '找不到该商品！' );
		}


		$isFav 	= $UserCollectModel->isCollect( (int)$user->id, (int)$objProductInfo->id );

		if ( $isFav == 0 )
		{
			$rs   = $UserCollectModel->CollectAdd( (int)$user->id, (int)$objProductInfo->id, (int)$objProductInfo->activity_id );
			$code = 1;
			$msg  = '添加收藏成功！';
		}
		else
		{
			$rs   = $UserCollectModel->CollectDel( (int)$user->id, (int)$objProductInfo->id );
			$code = 2;
			$msg  = '取消收藏成功！';
		}

		echo get_json_data_public( $code, $msg, $rs );

	break;


	/*----------------------------------------------------------------------------------------------------
		-- 商品详情
	-----------------------------------------------------------------------------------------------------*/
	default:
		// 更新浏览数
		$ProductModel->UpdateViewedNum( $pid, $objProductInfo->hits );

		// 判断该商品是否被收藏
		if ( ! $bLogin )
		{
			$is_fav = 0;
		}
		else
		{
			$is_fav = $UserCollectModel->isCollect( (int)$user->id, (int)$pid );
		}

		//显示倒计时
// 		if( $objProductInfo->status >0 && $objProductInfo->enable > 0 )
// 		{
// 			if ($objProductInfo->activity_info->status == 2)
// 			{
// 				$date 	= DataTip( $objProductInfo->activity_info->begin_time, '+' );
// 			}
// 			else
// 			{
// 				$date 	= DataTip( $objProductInfo->activity_info->end_time, '-' );
// 			}

// 			$dateTip  			= $date['date_tip'];
// 			$seckillTimeDiff 	= $date['date_time'];
// 		}

		// 获取该产品的包装方式
		$pack		= $SyntheticalDictModel->get( array( 'type'=>'pack', 'value'=>$objProductInfo->pack ) );

		// 获取该产品的单位
		$unitDesc	= $SyntheticalDictModel->get( array( 'type'=>'unit', 'value'=>$objProductInfo->unit ) );

		// 获取该产品的材质
		$texture	= $SyntheticalDictModel->get( array( 'type'=>'texture', 'value'=>$objProductInfo->texture ) );

		// 获取商品详情图
// 		$ProductFocusImagesModel = M('product_focus_images');
// 		$imageList	 		= $ProductFocusImagesModel->getAll( array('product_id'=>$pid),'*','`Sorting` ASC' );

		// 获取评论数
		$UserCommentModel 	=  M('user_comment');
		$commentNum 		= $UserCommentModel->getCount(array('product_id'=>$pid));

		// 获取对应的专场数
		$SpecialShowModel 	= M('special_show');
		$SpecialInfo 		= $SpecialShowModel->get(array('activity_id'=>$objProductInfo->activity_id),'id');

		// 获取商品对应的商家信息
		$shop_info = $ProductModel->getProductShopInfo( $objProductInfo->user_id );


		/*
		 *  功能：如果没有当天的浏览记录，则添加浏览记录
		 *  条件：当商品已下架，或用户未登录时不添加足迹
		 * */

		if( $bLogin )
		{
			$HistoryModel = D('History');

			if  ( $HistoryModel->checkIsHas( (int)$user->id, 1, $pid ) == 0)
			{
				$HistoryModel->HistoryAdd( (int)$user->id, 1, $pid, $objProductInfo->activity_id );
			}
			else  // 否则则更新时间
			{
				$HistoryModel->HistoryUpdate( (int)$user->id, 1, $pid, $objProductInfo->activity_id );
			}
		}

		// 产品推荐列表(猜你喜欢列表)
		$similar_products = NULL;
		if ( $objProductInfo->enable == 1 )
		{
			$similar_products = $ProductModel->getProductListFromActicityID( $objProductInfo->activity_id, 4 );

		}

		$showDownBar = true;

		include "tpl/product_detail_web.php";
}

?>


