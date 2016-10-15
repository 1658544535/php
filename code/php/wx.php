<?php
/**
  * wechat php test
  */

define('HN1', true);
define('APP_INC', dirname(__FILE__) . '/includes/inc/');
define('LOG_INC', dirname(__FILE__) . '/logs/');
define('SCRIPT_ROOT',  dirname(__FILE__).'/');

define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest($db);



$wechatObj->valid();
$wechatObj->responseMsg();

$isTest = false;
require_once APP_INC.'wxjssdk.php';
include_once(APP_INC . 'config.php');
include_once(APP_INC . 'ez_sql_core.php');
include_once(APP_INC . 'ez_sql_mysql.php');
include_once(APP_INC . 'inic_log.php');
require_once(APP_INC . 'db.php');
require_once SCRIPT_ROOT.'logic/sys_loginBean.php';
require_once SCRIPT_ROOT.'logic/user_verifyBean.php';
require_once SCRIPT_ROOT.'logic/promotion_linkBean.php';
require_once SCRIPT_ROOT.'activity/shake/logic/shake_linkBean.php';		// 摇一摇数据


$db 	= new ezSQL_mysql($dbUser, $dbPass, $dbName, $dbHost);
$db->query('SET character_set_connection=' . $dbCharset . ', character_set_results=' . $dbCharset . ', character_set_client=binary');




class wechatCallbackapiTest
{
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function valid()
    {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature())
        {
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr))
		{
              	$postObj 	= simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
              	$RX_TYPE 	= trim($postObj->MsgType);

              	switch($RX_TYPE)
              	{
                    case "event":
                        $resultStr = $this->handleEvent($postObj);
                    break;

                    case "text":
                    	$resultStr = $this->handleText($postObj);
                    break;

                    default:
                        $resultStr = $this->handleText($postObj);
              	}
				echo  $resultStr;
        }
        else
        {
        	echo "";
        	return;
        }
    }

	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN"))
        {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	 * 如果输入文字，则执行
	 * */
	private function handleText( $postObj )
	{
//		$type 				= substr( $postObj->Content,0,3);
//
//		if ( strtolower($type) == 'yzm' )
//		{
//			$userverify 		= new user_verifyBean();
//			$rs 				= $userverify->verify( $this->conn, substr( $postObj->Content,3));
//			$verify_code 		= ( $rs == null ) ? '查询不到该手机的验证码' : $rs;
//
//			$textTpl 	= "<xml>
//				<ToUserName><![CDATA[%s]]></ToUserName>
//				<FromUserName><![CDATA[%s]]></FromUserName>
//				<CreateTime>%s</CreateTime>
//				<MsgType><![CDATA[text]]></MsgType>
//				<Content><![CDATA[%s]]></Content>
//			</xml>";
//
//			$resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $verify_code);
//		}

		switch($postObj->Content){
			case 'www':
				$content = "<a href='http://weixinm2c.taozhuma.com'>点击进入微商城</a>";
				$textTpl 	= "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
				</xml>";

				$resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $content);
				break;

			case 'yy':
				$content = "<a href='http://weixinm2c.taozhuma.com/activity/shake/'>点击进入摇一摇</a>";
				$textTpl 	= "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
				</xml>";

				$resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $content);
			break;

			case '圣诞快乐':
				$content = "<a href='http://weixinm2c.taozhuma.com/activity/shake_new/'>点击进入摇一摇</a>";
				$textTpl 	= "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
				</xml>";

				$resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $content);
			break;

			case '抢购':
				$content = "<a href='http://weixinm2c.taozhuma.com/seckill.php'>点击进入抢购</a>";
				$textTpl 	= "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
				</xml>";

				$resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $content);
				break;
			default:
				$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[transfer_customer_service]]></MsgType>
				</xml>";

				$resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time());
				break;
		}

         return $resultStr;
	}



	/*
	 * 如果是事件，则执行
	 * */
	private function handleEvent( $postObj )
	{
		$contentStr = "";

		//file_put_contents('./game/lower-brain/inc/text.txt',"Event: {$postObj->Event}, EventKey:{$postObj->EventKey}, Content:{$resultStr}");

		// 关注淘竹马服务号推送信息
		switch ($postObj->Event)
        {
        	case "subscribe":		// 关注订阅号

        		if ( $postObj->EventKey != '')
        		{
        			//$EventKey = substr($postObj->EventKey,8);
					//$strContent = ($this->check_purchaser( $postObj->FromUserName, $EventKey )) ? "您已是淘竹马平台采购商！" : "恭喜你！！<a href='http://weixinm2c.taozhuma.com/user_registered?act=from_qrcode&promotion=$EventKey&openid=$postObj->FromUserName'>点击注册</a>" ;

					$strContent = "由于平台升级，该功能已停用，请您关注'竹马分销'微信服务号！！ 感谢您的配合！";

        			$contentStr 	= "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[". $strContent ."]]></Content>
					</xml>";
        		}
        		else
        		{
        			$this->check_shake_link_info( $postObj->FromUserName );

//        			$contentStr 	= " <xml>
//						<ToUserName><![CDATA[%s]]></ToUserName>
//						<FromUserName><![CDATA[%s]]></FromUserName>
//						<CreateTime>%s</CreateTime>
//						<Event><![CDATA[subscribe]]></Event>
//						<MsgType><![CDATA[news]]></MsgType>
//						<ArticleCount>1</ArticleCount>
//						<Articles>
//							<item>
//								<Title><![CDATA[您有一份专属的【淘竹马】优惠，打开即可领取！]]></Title>
//								<Description><![CDATA[淘竹马用专业的态度提供便捷的用户体验；用优质的产品打动妈妈们的心；用细致入微的服务关注每一个宝宝的健康成长；淘竹马从每个细节，关爱妈妈呵护宝宝！]]></Description>
//								<PicUrl><![CDATA[http://weixinm2c.taozhuma.com/images/wxarticle.jpg]]></PicUrl>
//								<Url><![CDATA[http://mp.weixin.qq.com/s?__biz=MzA3OTEzMDA4OA==&mid=209647691&idx=1&sn=5ceffc9580dc4cdf376bf783c06ef232#rd]]></Url>
//							</item>
//						</Articles>
//					</xml>";
//					<Content><![CDATA[感谢亲持续的关注，由于平台维护升级，淘竹马服务号已经转移阵地啦！新朋友【竹马分销】服务号已开启使用，新朋友，还一样，更有料！赶紧搜索或长按二维码关注获得更多惊喜吧！]]></Content>

					$strContent = <<<EOF
么么哒，欢迎关注淘竹马，大牌玩具任你买，海量专场由你逛呦！
☆买玩具上竹马，妈妈的放心之选！
    --> <a href="http://weixinm2c.taozhuma.com">戳我去看看</a>
    下载竹马APP，注册即享100元代金券！
    --> <a href="https://itunes.apple.com/us/app/tao-zhu-ma-ma-ma-quan-wan/id1025618713?l=zh&ls=1&mt=8">戳我去看看</a>
EOF;
					$contentStr 	= " <xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[". $strContent ."]]></Content>
					</xml>";
        		}
				$resultStr = sprintf($contentStr, $postObj->FromUserName, $postObj->ToUserName, time());
			break;

			case "SCAN":		// 扫描二维码
				//$strContent = ($this->check_purchaser( $postObj->FromUserName, $postObj->EventKey )) ? "您已是淘竹马平台采购商！" : "恭喜你！！<a href='http://weixinm2c.taozhuma.com/user_registered?act=from_qrcode&promotion=$postObj->EventKey&openid=$postObj->FromUserName'>点击注册</a>" ;
				$strContent = "由于平台升级，该功能已停用，请您关注'竹马分销'微信服务号！！ 感谢您的配合！";

				$contentStr 	= "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[". $strContent ."]]></Content>
				</xml>";
				$resultStr = sprintf($contentStr, $postObj->FromUserName, $postObj->ToUserName, time());
			break;

			case 'CLICK':
				switch($postObj->EventKey){
					case 'service':
						$content = <<<EOF
Hi，淘竹马的亲们，您的在线客服功能已打开，点击左边的键盘图标即可给小马留言~

欢迎你们各种戳我，我一定尽力为您服务

我的工作时间为：
周一到周日 9:00 - 22:00

您也可以来电咨询
客服电话：4001501677
EOF;

						$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA[%s]]></Content>
						</xml>";
						$resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $content);
						break;
					case 'giftpackage';
						$title = '客户端专享礼包';
						$desc = '点击下载淘竹马，100元现金卷马上领取页面最低部直接点击下载淘竹马APP';
						$pic = 'http://weixinm2c.taozhuma.com/images/wxcpnad.png';
						$url = 'https://5315.taozhuma.com/taozhuma.php';
						$textTpl 	= "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>1</ArticleCount>
							<Articles>
								<item>
									<Title><![CDATA[%s]]></Title>
									<Description><![CDATA[%s]]></Description>
									<PicUrl><![CDATA[%s]]></PicUrl>
									<Url><![CDATA[%s]]></Url>
								</item>
							</Articles>
						</xml> ";
						$resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $title, $desc, $pic, $url);
						break;
				}
				break;
        }

 //file_put_contents('./game/lower-brain/inc/text.txt',"Event: {$postObj->Event}, Content:{$resultStr}");
        return $resultStr;
	}

	/*
	 * 功能：检测采购商是否存在
	 * */
	function check_purchaser( $openid,$promotion )
	{
		$promotion_link 	= new promotion_linkBean();
		$sys_login 			= new sys_loginBean();
		$user_info 			= $sys_login->detail_openid($this->conn,$openid);

		if ( $user_info == null )
		{
			$wxjssdk        = new JSSDK( $this->app_info['appid'], $this->app_info['secret']) ;
			$objuserinfo 	= $wxjssdk->get_userinfo( $openid );

			$purchaser = $sys_login->create_weixin_account('',$openid,'-2',$objuserinfo->unionid,$this->conn);
			$promotion_link->create( $this->conn, $promotion, $purchaser );
			return false;
		}

		if ( is_object($user_info) && $user_info->type == 3 )						// 如果该用户存在，并且已经是分销商，则退出
		{
			return true;
		}

		return false;
	}

	/*
	 * 功能：检查shake_link表里面的记录，如果openid存在且subscribe=0，则修改其记录
	 * */
	function check_shake_link_info( $openid )
	{
		$shake_linkBean = new shake_linkBean( $this->conn, 'shake_link' );

		$arrParam = array(
			'openid' 	=> $openid
		);

		$rs = $shake_linkBean->get( $arrParam );

		if ( $rs != null )
		{
			// 如果有记录，则进行更新
			$arrParam = array( 'subscribe' => 1 );
			$arrWhere = array( 'openid' => $openid );
			$rs = $shake_linkBean->update( $arrParam, $arrWhere );
		}

	}

}
?>