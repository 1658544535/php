<?php

define('HN1', true);
require_once('../global.php');

require_once( LOGIC_ROOT . 'UserOrderBean.php');

$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  = isset( $_REQUEST['act'] ) 	? $_REQUEST['act'] : '';

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
	case 'paid':
		redirect($site . 'alipay/test.php');
	break;

	case 'info':

		$order_id = isset($_GET['id']) ? $_GET['id'] : '';

		if ( $order_id == '' )
		{
			redirect("order.php",'非法操作！');
		}

		// 获取订单信息
		$UserOrderBean 		= new UserOrderBean( $db,  'user_order' );
		$data = $UserOrderBean->get_one($order_id);
		$arrOrderStatus 	= getStatusDesc($db,'order_status');
		$arrPayStatus 		= getStatusDesc($db,'pay_status');

		if ( $data == null )
		{
			redirect("order.php",'非法操作！');
		}

		// 如果未付款，则生成支付二维码，并修改对外订单号
		if ( $data->pay_status == 0 )
		{
			$rs = updateTradeNo( $db, $data->id );
		}

		$data = $UserOrderBean->get_one($order_id);

		require_once('tpl/header.php');
		require_once('tpl/order_info.php');
	break;

	case 'edit':
		$OrderStatus 	= $_POST['OrderStatus'];
		$PayStatus 		= $_POST['PayStatus'];
		$OrderID 		= $_POST['ID'];

		$UserOrderBean 		= new UserOrderBean( $db,  'user_order' );
		$UserOrderBean->update( array('pay_status'=>$PayStatus, 'order_status'=>$OrderStatus), array('id'=>$OrderID));
		redirect('order.php?act=info&id='.$OrderID,'更新成功');
	break;

	case 'getQrCode':
		$UserOrderBean 		= new UserOrderBean( $db,  'user_order' );
		$order_id 			= !isset($_REQUEST['order_id']) || $_REQUEST['order_id']=='' ? '' : $_REQUEST['order_id'];
		$rs = $UserOrderBean->getOne( array('id'=>$order_id) );

		if ( $rs->order_status == 1 && $rs->pay_status == 0 )
		{
			updateTradeNo( $db, $order_id );
			echo "<img src='http://weixinm2c.taozhuma.com/model/ClickFarm/qrcode_img/wxpay/{$order_id}.png?_".rand()."'>";
		}
		else
		{
			echo '该订单已支付！';
		}
	break;

	default:
		$order_no 		= !isset($_REQUEST['oid'])   || $_REQUEST['oid']=='' ? '' : $_REQUEST['oid'];
		$sdate 			= !isset($_REQUEST['sdate']) || $_REQUEST['sdate']=='' ? date('Y-m-d') . ' 00:00' : $_REQUEST['sdate'];
		$edate 			= !isset($_REQUEST['edate']) || $_REQUEST['edate']=='' ? date('Y-m-d') . ' 23:59' : $_REQUEST['edate'];
		$page 			= !isset($_REQUEST['page'])  || $_REQUEST['page']=='' ? 1 : $_REQUEST['page'];
		$order_status 	= !isset($_REQUEST['order_status'])  ? '' : $_REQUEST['order_status'];
		$url 			= "?act=list&sdate={$sdate}&edate={$edate}&order_status={$order_status}&oid={$order_no}";
		$outputLink 	= $_SERVER["SCRIPT_URI"] .'?'. $_SERVER["QUERY_STRING"] . '&type=out';

		// 获取待刷商品
		$UserOrderBean 		= new UserOrderBean( $db,  'user_order' );
		$arrUserOrderList 	= $UserOrderBean->get_list( $sdate,$edate,$page,$order_status,$order_no );
		$arrOrderStatus 	= getStatusDesc($db,'order_status');
		$arrPayStatus 		= getStatusDesc($db,'pay_status');
		$fAllPrice 			= $UserOrderBean->get_price( $sdate,$edate,$order_status,$order_no);

		if ( isset($_GET['type']) && $_GET['type'] == 'out' )
		{
			$arrUserOrderList 	= $UserOrderBean->get_list( $sdate,$edate,$page,$order_status,$order_no ,false );
			getOutput( $arrUserOrderList,$arrOrderStatus,$arrPayStatus, $page );
		}

		require_once('tpl/header.php');
		require_once('tpl/order.php');
}


/**
 *	获取字典表状态信息
 *
 */
function getStatusDesc($db,$type)
{
	$sysDict = M( 'sys_dict', $db );
	$arrRs 	 = $sysDict->get_list(array('type'=>$type,'status'=>1),array('name','value'));

	foreach( $arrRs as $rs )
	{
		$data[$rs->value] = $rs->name;
	}

	return $data;
}

/**
 * 功能：更新对外订单号，并更新支付二维码
 */
function updateTradeNo( $db, $order_id )
{
	// 修改对外订单id
	$UserOrderBean 				= new UserOrderBean( $db,  'user_order' );
	$dataParam['out_trade_no'] 	= set_out_trade_no();
	$dataWhere['id']			= $order_id;
	$rs = $UserOrderBean->update( $dataParam, $dataWhere);

	if ($rs == 0)
	{
		return false;
	}

	$rs = $UserOrderBean->getOne($dataWhere);								// 获取用户订单表

	$WxpayOrderInfoBean = M( 'wxpay_order_info', $db );
	$arrParam = array(
		'out_trade_no'	=>	$rs->out_trade_no,
		'total_fee'		=>	$rs->fact_price,
		'trade_status'	=>	'WAIT_BUYER_PAY',
		'create_date'	=>	date('Y-m-d H:i:s'),
		'update_date'	=>	date('Y-m-d H:i:s')
	);

	$WxpayOrderInfoBean->create($arrParam);									// 新增wxpay_order_info记录

	$fPrice = $rs->fact_price * 100;

	$rs = getQrCode( $fPrice, $rs->out_trade_no, $order_id );

	return $rs;
}


function getOutput( $arrUserOrderList,$arrOrderStatus,$arrPayStatus, $nPage )
{
	require_once( '../inc/phpexcel.php' );

	$line = 2;
	$objPHPExcel = new PHPExcel();
	$objSheet    = $objPHPExcel->getActiveSheet();
	$objSheet->setTitle('推广详情');

	$objSheet->setCellValue('A1',"订单ID");
	$objSheet->setCellValue('B1',"用户ID");
	$objSheet->setCellValue('C1',"订单编号");
	$objSheet->setCellValue('D1',"产品名称");
	$objSheet->setCellValue('E1',"收货人");
	$objSheet->setCellValue('F1',"生成时间");
	$objSheet->setCellValue('G1',"应付金额");
	$objSheet->setCellValue('H1',"订单状态");

	$objPHPExcel->getActiveSheet()->getStyle( 'A1:H1' )->applyFromArray(
        array(
        		'font' => array (
                    'bold' => true
                ),

                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                )

        )
    );

	foreach( $arrUserOrderList as $info )
	{
		$objSheet->setCellValue('A' . $line, $info->id);
		$objSheet->setCellValue('B' . $line, $info->user_id);
		$objSheet->setCellValue('C' . $line, chunk_split($info->order_no));
		$objSheet->setCellValue('D' . $line, chunk_split($info->product_name));
		$objSheet->setCellValue('E' . $line, $info->consignee);
		$objSheet->setCellValue('F' . $line, $info->create_date);
		$objSheet->setCellValue('G' . $line, chunk_split($info->all_price));
		$objSheet->setCellValue('H' . $line, $arrOrderStatus[$info->order_status]);

		$objPHPExcel->getActiveSheet()->getStyle( 'A'. $line .':'. 'H'. $line )->applyFromArray(
            array(
	                'alignment' => array(
	                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
	                )
            )
        );

		$line++;
	}

	$objSheet->getColumnDimension('A')->setWidth(12);
	$objSheet->getColumnDimension('B')->setWidth(12);
	$objSheet->getColumnDimension('C')->setWidth(30);
	$objSheet->getColumnDimension('D')->setWidth(120);
	$objSheet->getColumnDimension('E')->setWidth(20);
	$objSheet->getColumnDimension('F')->setWidth(20);
	$objSheet->getColumnDimension('G')->setWidth(20);
	$objSheet->getColumnDimension('H')->setWidth(20);

	$objWrtie = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
	browser_export( "Excel2007", "订单列表_" . date('Y-m-d',time()). "_" . $nPage . ".xlsx"  );
	$objWrtie->save('php://output');
}


function browser_export( $type, $filename )
{
	if ( $type == "Excel5" )
	{
		header( "Content-Type:application/vnd.ms-excel" );
	}
	else
	{
		header( "Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
	}

	header( 'Content-Disposition:attachment;filename="'.$filename.'"' );
	header( 'Cache-Control:max-age=0' );
}





?>

