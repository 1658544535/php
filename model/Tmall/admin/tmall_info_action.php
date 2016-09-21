<?php
define('HN1', true);
require_once('../global.php');


$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  = isset( $_REQUEST['act'] ) 	? $_REQUEST['act'] : '';

$TmallInfoModel = M('tmall_info');

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

switch( $act ){
	case 'list':
	$pid      = !isset($_REQUEST['pid'])       || $_REQUEST['pid']     =='' ? '' : $_REQUEST['pid'];
	$addtime  = !isset($_REQUEST['addtime'])   || $_REQUEST['addtime'] =='' ? '' : $_REQUEST['addtime'];
 	$status   = !isset($_REQUEST['status'])  ? '' : $_REQUEST['status'];
	$page     = !isset($_REQUEST['page'])      || $_REQUEST['page']=='' ? 1 : $_REQUEST['page'];
	$outputLink 	= $_SERVER["SCRIPT_URI"] .'?'. $_SERVER["QUERY_STRING"] . '&type=out';
	
	$arrWhere=array(
		'status'=>1
	);
	
	if($pid !='' ){
		$arrWhere=array('pid'=>$pid) ;
	}
	$infoList = $TmallInfoModel->gets($arrWhere,array('id'=>'desc'),$page, $perpage = 20);

// if ( isset($_GET['type']) && $_GET['type'] == 'out' )
// {
	
// 	getOutput( $infoList,$arrWhere,array('id'=>'desc'),$page, $perpage = 20 );
// }




	
	
	$url 	   = "?act=list&addtime={$addtime}&pid={$pid}";
	
	require_once('tpl/header.php');
	require_once('tpl/tmall_info_list.php');
	
}





// function getOutput( $infoList,$arrWhere,$page, $perpage = 20 )
// {
// 	require_once( '../inc/phpexcel.php' );

// 	$line = 2;
// 	$objPHPExcel = new PHPExcel();
// 	$objSheet    = $objPHPExcel->getActiveSheet();
// 	$objSheet->setTitle('推广详情');

// 	$objSheet->setCellValue('A1',"商品ID");
// 	$objSheet->setCellValue('B1',"b2c商品价格");
// 	$objSheet->setCellValue('C1',"天猫商品价格");
// 	$objSheet->setCellValue('D1',"时间");

// 	$objPHPExcel->getActiveSheet()->getStyle( 'A1:D1' )->applyFromArray(
// 			array(
// 					'font' => array (
// 							'bold' => true
// 					),

// 					'alignment' => array(
// 							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
// 					)

// 			)
// 			);

// 	foreach( $arrUserOrderList as $info )
// 	{
// 		$objSheet->setCellValue('A' . $line, $info->pid);
// 		$objSheet->setCellValue('B' . $line, $info->b_price);
// 		$objSheet->setCellValue('C' . $line, $info->t_price);		
// 		$objSheet->setCellValue('D' . $line, $info->addtime);
		
// 		$objPHPExcel->getActiveSheet()->getStyle( 'A'. $line .':'. 'D'. $line )->applyFromArray(
// 				array(
// 						'alignment' => array(
// 								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
// 						)
// 				)
// 				);

// 		$line++;
// 	}

// 	$objSheet->getColumnDimension('A')->setWidth(12);
// 	$objSheet->getColumnDimension('B')->setWidth(12);
// 	$objSheet->getColumnDimension('C')->setWidth(30);
// 	$objSheet->getColumnDimension('D')->setWidth(120);
	
// 	$objWrtie = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
// 	browser_export( "Excel2007", "订单列表_" . date('Y-m-d',time()). "_" . $nPage . ".xlsx"  );
// 	$objWrtie->save('php://output');
// }


// function browser_export( $type, $filename )
// {
// 	if ( $type == "Excel5" )
// 	{
// 		header( "Content-Type:application/vnd.ms-excel" );
// 	}
// 	else
// 	{
// 		header( "Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
// 	}

// 	header( 'Content-Disposition:attachment;filename="'.$filename.'"' );
// 	header( 'Cache-Control:max-age=0' );
// }





?>






