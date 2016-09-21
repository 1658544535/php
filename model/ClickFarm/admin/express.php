<?php
define('HN1', true);
require_once('../global.php');

require_once( LOGIC_ROOT . 'UserOrderBean.php');
require_once( LOGIC_ROOT . 'LogisticsListBean.php');

$market_admin 		= isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  		= isset( $_REQUEST['act'] ) 	? $_REQUEST['act'] : '';
$LogisticsListBean 	= new LogisticsListBean( $db, 'logistics_list' );

if( $market_admin != null )								// 如果用户已登录
{
	$market_type 	 = $market_admin['type'];
	$market_name 	 = $market_admin['name'];
}
else													// 否则跳转到登录页面
{
	redirect("login.php");
	return;
}


switch( $act )
{
	case 'list':
		$ExpressList = getExpressList();				// 获取快递列表
		$page 			= !isset($_REQUEST['page'])  || $_REQUEST['page']=='' ? 1 : $_REQUEST['page'];
		$arrExpressList = $LogisticsListBean->getList( $page );
		$url 			= "?act=list";

		require_once('tpl/header.php');
		require_once('tpl/express_list.php');
	break;

	case 'add_save':

		set_time_limit(0);

		$dir 		= dirname(dirname(__FILE__)) . '/order_files/';							// excel文件的保存目录
		$date 		=  isset( $_REQUEST['date'] ) ? $_REQUEST['date'] : date('Y-m-d');		// 获取要保存的日期
		$filename 	= uploadexcelfile( 'files', $dir);										// 把excel文件保存到本地，并且返回存储内容

		if ( $filename === FALSE )
		{
			redirect( $site . 'admin/express.php','文件导入有误！' );
		}

		$LogisticsInfo = getLogistics( $filename );											// 获取Excel表的内容

		foreach( $LogisticsInfo as $Logistics )
		{
			$ExpressInfo = getExpressInfo( $Logistics[5] );
			$arrParam = array(
				'logistics_name' => $ExpressInfo,
				'logistics_no'	 => $Logistics[4],
				'address'		 => $Logistics[1],
				'consignee'		 => $Logistics[0],
				'date'			 => $date
			);

			Log::DEBUG( "name:{$Logistics[1]} -- en_name:{$ExpressInfo} -- logistics_no:{$Logistics[4]} -- date:{$date} ");
			$LogisticsListBean->add( $arrParam );		// 添加记录
		}

		redirect( $site . 'admin/express.php?act=list','数据导入成功！' );

	break;

	case 'run':
		$date = date('Y-m-d');
		require_once('tpl/header.php');
		require_once('tpl/express_update.php');
	break;

	case 'run_save':
		set_time_limit(0);

		$date 		=  isset( $_REQUEST['date'] ) ? $_REQUEST['date'] : date('Y-m-d');					// 获取要保存的日期

		// 订单数量
		$objOrderList 					= $LogisticsListBean->getOrderList( $date );
		$nOrderListCount				= count($objOrderList);

		// 快递数量
		$objLogisticsList 				= $LogisticsListBean->getLogisticsList( $date );
		$nLogisticsListCount			= count($objLogisticsList);

		// 快递仓库数量
		$objLogisticsWarehouseList 		= $LogisticsListBean->getLogisticsWarehouse( $date );
		$objLogisticsWarehouseListCount	= count($objLogisticsWarehouseList);

		if ( $nOrderListCount == 0 )
		{
			// 如果订单已全部“发货”完毕，则剩余快递单日期全部设置为空
			$num = 0;
			Log::DEBUG( "添加失败！原因：时间：{$date}　剩余订单数为：{$nOrderListCount}　剩余快递单数为：{$nLogisticsListCount}");

			if ( $nOrderListCount == 0 )
			{
				$msg = '当日订单号已用完！';
				$LogisticsListBean->updateLogisticsDate( $date );
			}
			redirect( $site . 'admin/express.php?act=run',"添加失败:{$msg}" );
			exit;
		}

		$j = 0;
		if ( $nOrderListCount > $nLogisticsListCount )
		{
			// 订单数量大于快递数量，则需要从快递仓库中获取快递单

			if ( $nLogisticsListCount != 0 )
			{
				$num = $nLogisticsListCount;	// 计算要循环的次数

				for ( $i = 0; $i <= $num-1; $i++ )
				{
					$rs = $LogisticsListBean->addOrderShip( $objOrderList[$i]->id, $objLogisticsList[$i]->logistics_name, $objLogisticsList[$i]->logistics_no, $objLogisticsList[$i]->consignee, $objLogisticsList[$i]->address );
					$j++;
				}

				$nOrderListCount = $nOrderListCount - $nLogisticsListCount;
			}

			$num = $nOrderListCount - $objLogisticsWarehouseListCount < 0 ? $nOrderListCount : $objLogisticsWarehouseListCount;


			for ( $i = $j; $i <= $num-1; $i++ )
			{
				$rs = $LogisticsListBean->addOrderShip( $objOrderList[$i]->id, $objLogisticsWarehouseList[$i]->logistics_name, $objLogisticsWarehouseList[$i]->logistics_no, $objLogisticsWarehouseList[$i]->consignee, $objLogisticsWarehouseList[$i]->address );
			}
		}

		redirect( $site . 'admin/order.php?act=list','指定订单更新成功！' );

	break;

	default:
		$date = date('Y-m-d');
		require_once('tpl/header.php');
		require_once('tpl/express.php');
	break;

}




/**
 *	功能：获取运单号
 */
function getLogistics( $filename )
{
	$dir 		 = dirname(dirname(__FILE__));
	require_once( $dir . '/inc/phpexcel.php' );
	require_once( $dir . '/tools/PHPExcel/IOFactory.php');		// 当前脚本所在路径
	$excelfile 	 = $dir . '/order_files/' . $filename;
	$objPHPExcel = PHPExcel_IOFactory::load( $excelfile );		// 加载文件
	$sheetCount  = $objPHPExcel->getSheetCount();

//		for( $i=0; $i<$sheetCount; $i++ )
//		{
//			$data = $objPHPExcel->getSheet($i)->toArray();
//			print_r($data);
//			exit;
//		}

	foreach( $objPHPExcel->getWorksheetIterator() as $sheet )
	{
		$i = 0;
		foreach( $sheet->getRowIterator() as $row )
		{
			if ( $row->getRowIndex()<2 )
			{
				continue;
			}

			$j = 0;

			foreach( $row->getCellIterator() as $cell )
			{
				$data[$i][$j] = $cell->getValue();
				$j++;
			}
			$i++;
		}
	}

	return $data;
}

/*============================== 物流类型  ==============================*/
function getExpressInfo( $ExpressName )
{
	$arrExpress = getExpressList();
	$rs = array_keys( $arrExpress, $ExpressName);
	return $rs[0];
}

function getExpressList()
{
	return array(
		'shunfeng' 	 	=> '顺丰速运',
		'shentong' 	 	=> '申通快递',
		'zhongtong'  	=> '中通快递',
		'yuantong' 	 	=> '圆通速递',
		'huitong' 	 	=> '汇通快递',
		'tiantian' 	 	=> '天天快递',
		'yunda' 	 	=> '韵达快递',
		'dhl' 		 	=> 'DHL快递',
		'zhaijisong' 	=> '宅急送',
		'debang' 	 	=> '德邦物流',
		'ems' 		 	=> 'EMS国内',
		'eyoubao' 	 	=> 'E邮宝',
		'guotong' 		=> '国通快递',
		'longbang' 	 	=> '龙邦速递',
		'lianbang' 	 	=> '联邦快递',
		'tnt' 		 	=> 'TNT快递',
		'xinbang' 	 	=> '新邦物流',
		'zhongtie' 		=> '中铁快运',
		'zhongyou' 	 	=> '中邮物流',
		'huitongkuaidi'	=> '百世快递',
		'kuaijiesudi'	=> '快捷快递'
	);
}


?>

