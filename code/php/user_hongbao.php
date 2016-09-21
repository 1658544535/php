<?php
define('HN1', true);
require_once('./global.php');
date_default_timezone_set('Asia/Shanghai'); 							// 设置默认时区

if( $openid == null )
{
	redirect("login.php?dir=user_hongbao");
	return;
}
else if ( $user == null )
{
	redirect("user_binding?dir=user_hongbao");
	return;
}

$userid = $user->id;

$return_url  = !isset($_GET['return_url']) || $_GET['return_url']==null ? '/user' : $_GET['return_url'];
$page 		 = isset($_GET['page']) ? intval($_GET['page']) : 1;

require_once  LOGIC_ROOT.'hongbao_logBean.php';
$objHBL      = new hongbao_logBean();
$objHBL->db  = $db;


$condition = array('uid'=>$userid);
$list = $objHBL->search($condition, $page, 10);
$listTypeMap = array(0=>'全部红包', 1=>'邀请码');
$listType 	 = isset($_GET['vt']) ? intval($_GET['vt']) : '';
$act = isset($_GET['act']) ? trim($_GET['act']) : '';

/*
 * 功能：邀请码激活操作
 * 流程：
 * 1、通过接收的code 去查找是否存在且有效
 * 2、更新该code的记录
 * 3、记录红包日志
 * */

switch($act)
{
	case 'active':
		require_once  LOGIC_ROOT.'redpacket_codeBean.php';
		$redpacket_code = new redpacket_codeBean($db, 'redpacket_code');

		$code 	= !isset($_REQUEST['code']) ? '' : $_REQUEST['code'];

		do
		{
			if ( $code == null )
			{
				$rs = get_json_data( -1, '请输入邀请码！' );
				break;
			}

			$arrWhere  = array( 'code'=>$code, 'status'=>1 );
			$arrCol    = array( 'id' );
		    $code_data = $redpacket_code->get($arrWhere,$arrCol);

		  	if ( ! $code_data )
			{
				$rs = get_json_data( -1, '无效邀请码' );
			}
            else
           	{
					// 中奖与中奖的类型对应参数
	          $arrPro = array( '1'=>85, '2'=>14, '3'=>1 );

	               // 获取中奖的类型
	          $type = get_rand($arrPro);

	              // 获取到要发红包的金额
	        switch ( $type )
	           {
		          case 1:
			      $amount = rand( 100, 1000 );
		          break;

		          case 2:
			      $amount = rand( 1000, 10000 );
		          break;

		          case 3:
			      $amount = rand( 10000, 20000 );
		          break;
	           }

				$wxpay_recode = send_redpacket( $openid, $amount);		//发送红包记录

				if ( ! $wxpay_recode )
				{
					$rs = get_json_data( -1, '发送红包失败，请重试！' );
					break;
				}

				if ( $wxpay_recode['return_code'] == 'SUCCESS' && $wxpay_recode['result_code'] == 'SUCCESS' )
				{
	                $arrWhere  = array( 'id'=>$code_data->id, 'status'=>1 );
		            $arrParam 	= array (
		            	'user_id' 	    => $userid,
		        		'create_time'   => time(),
		        		'amout'	        => $wxpay_recode['total_amount']/100,
		        		'out_trade_id' 	=> $wxpay_recode['mch_billno'],
		        		'status'		=> 0
		            );

	              	if( ! $redpacket_code->update( $arrParam, $arrWhere ) )
	           		{
	           			$rs = get_json_data( -1, '邀请码发送失败！' );
	           			break;
	           		}

	           		$arrParam = array(
	           			'money'		=> $wxpay_recode['total_amount'],
	           			'remark'	=> '该记录来源于邀请码，邀请码id为：' . $code_data->id,
	           			'type'		=> 2,
	           		);

	           		if ( ! $objHBL->add($userid, $arrParam) )
	           		{
	           			$rs = get_json_data( -1, '邀请码发送失败！' );
	           			break;
	           		}

			        $rs = get_json_data( 1, '邀请码发送成功！' );
				}
           }

           break;
		}
		while(0);

		echo $rs;

	break;

  	case'red':
  		include "tpl/redpacket_code_web.php" ;
  	break;

	default:
      include "tpl/user_hongbao_web.php" ;
}

/*
 * 功能：获取json数据
 * */
function get_json_data( $code, $msg, $data='' )
{
	$rs = array(
		'code' 	=> $code,
		'msg'	=> $msg,
		'data'	=> $data
	);

	return json_encode( $rs );
}

function send_redpacket($openid, $amount)
{
	require_once SCRIPT_ROOT . './wxpay/inc_hongbao.php';
	$HongBao = new HongBao();

	$HongBao->set_val( 'openid', $openid );
	//$HongBao->set_val( 'openid', 'o6MuHtwL7s7gntl6xYmXHikcD6zQ' );
	$HongBao->set_val( 'total_amount', $amount );
	$arrXmlData = $HongBao->sendredpack();
	return $arrXmlData;

}

	// 中奖概率算法
function get_rand( $arrPro )
	{
		$result = "";

		$proSum = array_sum( $arrPro );

		foreach( $arrPro as $key=>$proCur )
		{
			$randNum = mt_rand( 1, $proSum );

			if ( $randNum <= $proCur )
			{
				$result = $key;
				break;
			}
			else
			{
				$proSum -= $proCur;
			}
		}

		unset( $arrPro );

		return $result;
	}


?>