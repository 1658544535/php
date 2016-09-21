<?php
define('HN1', true);
require_once('./global.php');



/*----------------------------------------------------------------------------------------------------
	-- 配置
-----------------------------------------------------------------------------------------------------*/
$ProductModel 	= D('Product');
$nProductType 	= CheckDatas('pid', 0);
$types 			= CheckDatas('pid', '');
$bid 			= CheckDatas('bid', '');
$act 			= CheckDatas('act', 'lists');
$isShowBar		= TRUE;

switch($act)
{
	/*----------------------------------------------------------------------------------------------------
		-- 商品列表
	-----------------------------------------------------------------------------------------------------*/
	case "lists":
		$url = "/product?act=lists&pid={$types}";
		$ProductTypeModel 	= M('product_type');
// 		$type = 3; 				// 活动类型

		// 获取商品分类信息
		$objProductTypeInfo = $ProductTypeModel->get(array('id'=>$types), 'name');
		$actTitle 			= empty($objProductTypeInfo) ? "商品列表" : $objProductTypeInfo->name;
		
		// 获取商品列表
		$Col  				= CheckDatas('col', 'id');
		$OrderByType 		= CheckDatas('order_by', 'DESC');
		$OrderByType		= strtoupper($OrderByType);

		// 获取排序对应的URL
		$arrOrderBy 	= getOrderBy( $Col, $OrderByType );
		$strOrderBy		= $arrOrderBy['desc'];
		$ColUrl			= $arrOrderBy['url'];

		// 输入对应的商品列表信息
		$productList 	= $ProductModel->getProductList( $nProductType, $strOrderBy );


		include "tpl/product_web.php";
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 每日十件
	-----------------------------------------------------------------------------------------------------*/
	case 'top':
		$type = 3; 				// 活动类型
		$actTitle 			= "每日十件";
		$productList      	= $ProductModel->getTopTenList();

		include "tpl/product_top_ten_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- TOP排行
	-----------------------------------------------------------------------------------------------------*/
	case 'rank':
		$isShowBar			= FALSE;
		$type = 3; 				// 活动类型
		$url = "/product?act=rank";
		$actTitle 			= "TOP排行";

		// 获取商品列表
		$Col  				= CheckDatas('col', 'product_id');
		$OrderByType 		= CheckDatas('order_by', 'ASC');
		$OrderByType		= strtoupper($OrderByType);

		// 获取排序对应的URL
		$arrOrderBy 	= getOrderBy( $Col, $OrderByType );
		$strOrderBy		= $arrOrderBy['desc'];
		$ColUrl			= $arrOrderBy['url'];

		$productList      	= $ProductModel->getProductList( '', $strOrderBy, '', '0,20','rank' );

		include "tpl/product_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 钱包专区
	-----------------------------------------------------------------------------------------------------*/
	case 'wallet':
		$type = 1; 				// 活动类型
		$actTitle 		= "钱包专区";
		$url 			= "/product?act=wallet";
		$isShowBar		= FALSE;

		// 获取商品列表
		$Col  			= CheckDatas('col', 'product_id');
		$OrderByType 	= CheckDatas('order_by', 'ASC');
		$OrderByType	= strtoupper($OrderByType);

		// 获取排序对应的URL
		$arrOrderBy 	= getOrderBy( $Col, $OrderByType );
		$strOrderBy		= $arrOrderBy['desc'];
		$ColUrl			= $arrOrderBy['url'];

		$productList 	= $ProductModel->getWalletProductList();

		include "tpl/product_web.php";
	break;


	/*----------------------------------------------------------------------------------------------------
		-- 品牌商品
	-----------------------------------------------------------------------------------------------------*/
	case 'brand':
		$url = "/product?act=brand&bid={$bid}";
					
		// 获取商品列表
		$Col  				= CheckDatas('col', 'id');
		$OrderByType 		= CheckDatas('order_by', 'DESC');
		$OrderByType		= strtoupper($OrderByType);

		// 获取排序对应的URL
		$arrOrderBy 	= getOrderBy( $Col, $OrderByType );
		$strOrderBy		= $arrOrderBy['desc'];
		$ColUrl			= $arrOrderBy['url'];
			
		$UserBrandModel 	= M('user_brand');
		$ActivityGoodsModel = M('activity_goods');
		$BrandDicModel      = M('brand_dic');
		
		$page = $_REQUEST['page'] = null ? '0' : intval($_REQUEST['page']);
		$bid  = $_REQUEST['bid'] == null ? '' : $_REQUEST['bid'];;
		$Dic   =  $UserBrandModel->get(array('id'=>$bid));
		$Brand =  $BrandDicModel ->get(array('id'=>$Dic->brand_id));
   	
   		$actTitle 		= $Brand->brand;

		
		// 获取品牌商品列表信息
		$BrandList = $ProductModel->query("select * from product where 1=1 and user_brand_id ='".$bid."' and status =1  order by $strOrderBy ",false,true,$page);

		include "tpl/brand_web.php";
	break;

	/*----------------------------------------------------------------------------------------------------
		-- 商品列表(搜索结果显示)
	-----------------------------------------------------------------------------------------------------*/
	case 'search':
		// 输出的商品信息
		$strKeyWord 	= CheckDatas('key','');
		$url = "/product?act=search&key=" . $strKeyWord;
		$type = 3; 				// 活动类型
		$actTitle 	    = "搜索结果";
		// 获取商品列表
		$Col  			= CheckDatas('col', 'id');
		$OrderByType 	= CheckDatas('order_by', 'DESC');
		$OrderByType	= strtoupper($OrderByType);

		// 获取排序对应的URL
		$arrOrderBy 	= getOrderBy( $Col, $OrderByType );
		$strOrderBy		= $arrOrderBy['desc'];
		$ColUrl			= $arrOrderBy['url'];

  		$productList 	= $ProductModel->getProductList( $nProductType, $strOrderBy, $strKeyWord );

		// 保存搜索记录
		$SearchKeyModel = M('search_key');
		$rs = $SearchKeyModel->get( array( 'type'=>1, 'keyword'=>$strKeyWord ) );
		if ( $rs != NULL )
		{
			$SearchKeyModel->modify( array( 'hits' => $rs->hits + 1 ), array( 'id' => $rs->id ) );
		}
		else
		{
			$arrParam = array(
								'type'		 => 1,
								'hits'		 => 1,
								'keyword'	 => $strKeyWord,
								'create_date'=> date('Y-m-d H:i:s')
							);
			$SearchKeyModel->add( $arrParam );
		}

		include "tpl/product_web.php";
	break;



























	/*======================================  分页加载操作 =========================================*/
	case "api":

		$func = isset($_GET['func']) ? $_GET['func']  : 'lists';

		switch( $func )
		{
			case 'is_news':
				$productList = $product->get_product_news($db,$page,20);
			break;

			case 'lists':
				$objProType 	= new comBean($db, 'product_type');
				$_product_type 	=  $types > 0 ?  $objProType->get_list(array('pid'=>$types),array('id')) : -1;		// 如果id为父类，则输出该父类对应的分类； 否则输出指定类

				if ( $_product_type == -1   )
				{
					$product_type_id = -1;
				}

				if ( $_product_type == null )
				{
					$product_type_id = $types;
				}

				if ( is_array($_product_type) )
				{
					foreach($_product_type as $v){

						$product_type_id[] = $v->id;
					}
				}

				$arrData = array();
				$productList = $product->search_list($db,$page,20,$type=-1,$product_type_id,'');
			break;

			default:
				$productList = null;
		}

		echo get_json_data( $productList, $site_image );
	break;


}





	/**
	 *	获取列表中排序的描述
	 */
	function getOrderBy( $Col, $OrderByType )
	{
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

		$strOrderBy = "`{$Col}` {$OrderByType}";

		return array( 'desc'=>$strOrderBy, 'url'=>$ColUrl );
	}








/*
 * 功能：获取json数据
 * */
function get_json_data( $productList, $site_image )
{
	$productData['code'] = $productList == null ? 0 : 1;
	$productData['msg']  = $productList == null ? "记录为空" : "获取记录成功";

	if ( $productList == null )
	{
		$productData['data'] = null;
	}
	else
	{
		mb_internal_encoding('utf8');//以utf8编码的页面为例

		foreach ($productList as $key=>$info)
		{
			$productData['data'][$key]["id"] 				 	= $info->id;
			$productData['data'][$key]["image"] 			 	= $site_image ."product/small/" . $info->image;
			$productData['data'][$key]["product_name"] 			= mb_strlen($info->product_name)>10 ? mb_substr($info->product_name,0,10).'...' : $info->product_name;
			$productData['data'][$key]["distribution_price"] 	= number_format($info->distribution_price,1);
			$productData['data'][$key]["sell_number"] 			= $info->sell_number;
		}
	}

	return json_encode($productData);

}

?>
