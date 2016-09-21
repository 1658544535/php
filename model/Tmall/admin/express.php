<?php
define('HN1', true);
require_once('../global.php');


$TmallModel = M('tmall');


$market_admin 		= isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  		= isset( $_REQUEST['act'] ) 	? $_REQUEST['act'] : '';


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

		$dir 		= dirname(dirname(__FILE__)) . '/tmall_files/';							// excel文件的保存目录
		$date 		=  isset( $_REQUEST['date'] ) ? $_REQUEST['date'] : date('Y-m-d');		// 获取要保存的日期
		$filename 	= uploadexcelfile( 'files', $dir);										// 把excel文件保存到本地，并且返回存储内容

		if ( $filename === FALSE )
		{
			redirect( $site . 'admin/express.php','文件导入有误！' );
		}

		$tmallInfo = getLogistics( $filename );											// 获取Excel表的内容

		foreach( $tmallInfo as $Logistics )
		{
			
			$arrParam = array(
				'pid'            => $Logistics[0],
				'url'	         => $Logistics[1],
				'price'		     => $Logistics[2],
 				'addtime'	     => date('Y-m-d H:i:s')
			);

			Log::DEBUG( "商品ID:{$Logistics[0]} --  链接地址:{$Logistics[1]} -- 商品价格:{$Logistics[2]}  ");
			$TmallModel->add( $arrParam );		// 添加记录

		}

		redirect( $site . 'admin/tmall_action.php?act=list','数据导入成功！' );

	break;


	default:
		
		require_once('tpl/header.php');
		require_once('tpl/express.php');
	break;
	
	
}
	
	function getLogistics( $filename )
	{
		$dir 		 = dirname(dirname(__FILE__));
		require_once( $dir . '/inc/phpexcel.php' );
		require_once( $dir . '/tools/PHPExcel/IOFactory.php');		// 当前脚本所在路径
		$excelfile 	 = $dir . '/tmall_files/' . $filename;
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
	
	
	function getExpressInfo( $ExpressName )
	{
		$arrExpress = getExpressList();
		$rs = array_keys( $arrExpress, $ExpressName);
		return $rs[0];
	}
	

?>

