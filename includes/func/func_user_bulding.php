<?php
	include_once( APP_INC . 'wxjssdk.php');
	/*
	 * 用户绑定类
	 * */
	class func_user_bulding extends JSSDK
	{
		private $appId;
		private $appSecret;
		private $db;
		private $log;

		public function __get($para_name)
		{
	        return isset($this->$para_name) ? $this->$para_name : NULL;
	    }

	    public function __set($para_name, $val)
	    {
	        $this->$para_name = $val;
	    }

		public function __construct($appId, $appSecret)
		{
			global $db;
			parent::__construct($appId, $appSecret);
			$this->db 	= $db;
			$this->appId = $appId;
			$this->appSecret = $appSecret;
		}

		/*
		 * 功能： 通过openid获取用户的信息
		 * */
		public function get_userinfo_from_openid( $openid, $unionid='' )
		{
			try
			{
				if ( empty($openid) )
				{
					throw new Exception('openid不能为空！');
				}

				if ( $unionid != '' )
				{
					$sql = "SELECT * FROM `sys_login` WHERE `openid`='{$openid}' or `unionid`='{$unionid}'";
					//$sql = "SELECT * FROM `sys_login` WHERE `unionid`='{$unionid}'";
				}
				else
				{
					$sql = "SELECT * FROM `sys_login` WHERE `openid`='{$openid}'";
				}

				$rs  = $this->db->get_row($sql);

				if ( empty($rs) )
				{
					throw new Exception('无该记录！');
				}

				$msg = "user login get user info!!   openid: {$openid}, 输出： {$rs->id},{$rs->loginname}, {$rs->name}";
				$this->log->put('/user/login', $msg);							// 记录日志
				return $rs;

			}catch( Exception $e )
			{
				//$msg = "user login get user info !!   openid: {$openid}, 输出：{$e->getMessage()}";
				//$this->log->put('/user/login', $msg);							// 记录日志
				return false;
			}
		}

		/*
		 *	功能：通过用户授权获取到的code来换取access_token和openid
		 * */
		 public function get_wx_openid( $code )
		 {
		 	global $isTest, $__testWXUserInfo;

		 	try
			{
				if ( $isTest )
				{
					// 测试数据
					$arrResult = array(
					  "subscribe"   => 1,
					  "openid"      => $__testWXUserInfo['openid'],// "o5Tz0ssOJBADNFMRlnMLYEO2W5-0",
					  "nickname"    => $__testWXUserInfo['nickname'],// "Band",
					  "sex"         => $__testWXUserInfo['sex'],// 1,
					  "language"    => "zh_CN",
					  "city"        => $__testWXUserInfo['city'],// "广州",
					  "province"    => $__testWXUserInfo['province'],// "广东",
					  "country"     => "中国",
					  "headimgurl"  => $__testWXUserInfo['headimgurl'],// "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
					  "subscribe_time"  => 1382694957,
					  "unionid"     => $__testWXUserInfo['unionid'],// " o6_bmasdasdsad6_2sgVt7hMZOPfL",
					  "remark"      => "",
					  "groupid"     => 0
					);
				}
				else
				{
					if ( empty( $code ) )
					{
						throw new Exception("code不能为空！");
					}

			 		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appId}&secret={$this->appSecret}&code={$code}&grant_type=authorization_code";
					$rs = $this->https_request( $url );

					$arrResult = json_decode($rs,true);

					if ( isset( $arrResult['errcode'] ) )
					{
						throw new Exception("获取access_token失败！ 原因： errcode:{$arrResult['errcode']}, errmsg:{$arrResult['errmsg']}");
					}

					$msg = "user login get wx info success!!    输出：access_token: {$arrResult['access_token']}, refresh_token: {$arrResult['refresh_token']}, openid: {$arrResult['openid']}, scope: {$arrResult['scope']}";
					$this->log->put('/user/login', $msg);							// 记录日志
				}

				return $arrResult;

			}catch( Exception $e )
			{
				$msg = "user login get wx info error!!   输出： {$e->getMessage()}";
				$this->log->put('/user/login', $msg);							// 记录日志
				return false;
			}
		 }


		/*
		 * 功能： 通过phone获取用户的信息
		 * */
		public function check_user_loginname( $loginname )
		{
			try
			{
				if ( empty($loginname) )
				{
					throw new Exception('loginname不能为空！');
				}

				$sql = "SELECT count(*) FROM `sys_login` WHERE `loginname`='{$loginname}'";
				return $this->db->get_var($sql);
			}
			catch( Exception $e )
			{
				$msg = "user login get user info !!   openid: {$openid}, 输出：{$e->getMessage()}";
				$this->log->put('/user/login', $msg);							// 记录日志
				return false;
			}
		}

		/*
		 * 通过微信openid获取微信信息
		 * */
		public function get_user_wx_info_from_openid( $openid )
		{
			$struserinfo = $this->get_userinfo( $openid );
			return $struserinfo;
		}

		/*
		 * 功能：添加 sys_login和 添加 user_info
		 * */
		public function create_user_info( $obj_user_info )
		{
			try
			{
				$strSQL = "SELECT count(*) as num FROM `sys_login` WHERE `openid`='{$obj_user_info->openid}'";
				!empty($obj_user_info->unionid) && $strSQL .= " OR `unionid`='{$obj_user_info->unionid}'";
				$rs 	= $this->db->get_row( $strSQL );

				if ( $rs->num >0 )
				{
					throw new Exception("绑定失败，原因：该openid或unionid已存在");
				}

				$this->db->query("BEGIN");

				$arrParam = array(
					'loginname' 			=> $obj_user_info->loginname,
					'password' 				=> $obj_user_info->password,
					'name' 					=> $obj_user_info->nickname,
					'openid' 				=> $obj_user_info->openid,
					'type' 					=> 1,
					'status'				=> 1,
					'create_by' 			=> -3,
					'create_date' 			=> date("Y-m-d H:i:s"),
					'update_date' 			=> date('Y-m-d H:i:s'),
					'unionid' 				=> $obj_user_info->unionid,
					'image' 				=> $obj_user_info->headimgurl,
					'external_sign_code' 	=> md5( $obj_user_info->loginname . $obj_user_info->openid . time() .rand(1000,9999) ),
					'invitation_code' 		=> createCode( 6, FALSE),
				);

				$user_id = $this->db->create( 'sys_login', $arrParam );

				if ( $user_id < 1 )
				{
					throw new Exception("绑定失败，原因：添加sys_login表失败");
				}

				$arrParam = array(
					'user_id' 		=> $user_id,
					'sex' 			=> $obj_user_info->sex,
					'phone' 		=> $obj_user_info->loginname,
					'address' 		=> $obj_user_info->province . $obj_user_info->city,
					'channel' 		=> 2,
					'status' 		=> 1,
					'create_by' 	=> -3,
					'create_date' 	=> date("Y-m-d H:i:s"),
					'update_date' 	=> date("Y-m-d H:i:s"),
//					'baby_sex'		=> $obj_user_info->baby_sex,
//					'baby_birthday'	=> $obj_user_info->baby_birthday,
				);

				$user_info_id = $this->db->create( 'user_info', $arrParam );
				if ( $user_info_id < 1 )
				{
					throw new Exception("绑定失败，原因：添加user_info表失败");
				}

				$this->db->query("COMMIT");

				$arrWhere = array(
					'loginname' => $obj_user_info->loginname
				);

				$rs = $this->db->get( 'sys_login', $arrWhere );					// 重新获取用户信息
				return $rs;

			}
			catch( Exception $e )
			{
				$this->db->query("ROLLBACK");

				$msg = "添加用户信息失败 !!  {$e->getMessage()}";
				$this->log->put('/user/login', $msg);							// 记录日志
				return false;
			}
		}

		/*
		 * 功能：绑定用户的微信帐号
		 * 返回值：
		 * >0: 成功
		 * -1: 密码失败
		 * -2： 数据表更新失败
		 * */
		public function bind_user_info( $openid, $unionid, $phone, $password )
		{
			try
			{
				$arrWhere = array(
					'loginname' => $phone,
					'password' => $password
				);

				$user = $this->db->get( 'sys_login', $arrWhere, array('id','unionid') );				// 判断密码是否正确

				if ( $user == null )
				{
					$errorNo = -1;
					throw new Exception("绑定失败，原因：您输入的密码有误！");
				}

				if ( $user->unionid != null )
				{
					$errorNo = -1;
					throw new Exception("绑定失败，原因：该帐号已绑定！");
				}

				$arrWhere = array( 'id' => $user->id );
				$arrParam = array( 'openid' => $openid, 'unionid'=> $unionid );
				$rs = $this->db->update( 'sys_login', $arrParam, $arrWhere );				// 更新sys_login表

				if ( $rs == 0 )
				{
					$errorNo = -2;
					throw new Exception("绑定失败，原因：微信帐号更新失败！");
				}

				$arrWhere = array(
					'loginname' => $phone
				);

				$arrWhere = array( 'id' => $user->id );
				$rs = $this->db->get( 'sys_login', $arrWhere );								// 重新获取用户信息
				return $rs;
			}
			catch( Exception $e )
			{
				$msg = "添加用户信息失败 !!  {$e->getMessage()}";
				$this->log->put('/user/login', $msg);										// 记录日志
				return $errorNo;
			}
		}


		/*
		 * 功能：解除绑定用户信息
		 * */
		public function unbind( $user_id )
		{
			$sql = "UPDATE `sys_login` SET `openid`='',`unionid`='' WHERE `id`={$user_id}";
			$rs  = $this->db->query($sql);
			return $rs == 1 ? true : false;
		}

		/**
		 *	功能:添加新注册用户优惠券
		 */
		public function getUserCoupon($userid)
		{
			$UserCouponModel = D('UserCoupon');

			//赠送的优惠券，om订单满额，m券额
			$giftCpns = array(
				array('om'=>10, 'm'=>5),
				array('om'=>30, 'm'=>5),
				array('om'=>99, 'm'=>10),
				array('om'=>169, 'm'=>20),
				array('om'=>169, 'm'=>20),
				array('om'=>399, 'm'=>40),
			);

			foreach($giftCpns as $val){
				// 获取系统优惠券信息
				$CouponID = $UserCouponModel->getCouponInfoFromName($val['om'], $val['m']);

				if ( $CouponID == NULL )
				{
					// 如果不存在则添加系统优惠券
					$CouponID = $UserCouponModel->addCoupon($val['om'], $val['m']);
				}

				// 添加用户优惠券
				$arrParam = array(
					'coupon_no'	=> genCouponNo(),
					'user_id'	=> $userid,
					'coupon_id'	=> $CouponID,
					'gen_time'	=> time(),
					'valid_stime'	=> time(),
					'valid_etime'	=> time() + 86400 * 30,
					'source'	=> 1
				);

				$rs = $UserCouponModel->addUserCoupon( $arrParam );
			}
		}



		 /**
		  *	功能: 生成用户钱包记录
		  */
		public function createUserWallet($userid)
		{
			$arrParam = array(
				'user_id'		=> $userid,
				'create_by'		=> $userid,
				'create_date'	=> date('Y-m-d H:i:s'),
				'update_by'		=> $userid,
				'update_date'	=> date('Y-m-d H:i:s')
			);

			$rs = $this->db->create( 'user_wallet', $arrParam );
			return $rs > 0 ? true : false;
		 }


		 /**
		  *	功能: 添加用户登录日志
		  */
		 public function addUserLoginLog( $userid )
		 {
		 	$arrParam = array(
					'user_id' 		=> $userid,
					'type' 			=> 3,
					'login_ip' 		=> GetIP(),
					'login_date' 	=> date("Y-m-d H:i:s")
				);

			$rs = $this->db->create( 'sys_login_log', $arrParam );
			return $rs > 0 ? true : false;
		 }
	}
?>
