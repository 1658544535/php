<?php
	include_once( APP_INC . 'wxjssdk.php');
	/*
	 * 用户邀请类
	 * */
	class func_user_invite extends JSSDK
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
			parent::__construct($appId, $appSecret);

			$this->appId = $appId;
			$this->appSecret = $appSecret;
		}


		/*
		 * 功能：通过external_sign_code来获取用户ID
		 * a9ba0810397a7b2afeb7c6f6a2c26f63
		 * */
		public function get_id_from_external_sing_code( $external_sing_code )
		{
			$strSQL = "SELECT `user_id` FROM `user_distribution_info` WHERE `user_id`=(SELECT `id` FROM `external_sign_code`='{$external_sing_code}') AND `status`=1";
			return $this->db->get_var($strSQL);
		}

		/*
		 * 功能：判断指定用户是否被绑定，如果未被绑定则添加inviter_id
		 *
		 * 流程：
		 * 1、通过用户ID获取该用户是否被绑定，如果该用户未被绑定则更新inviter_id的值
		 * */
		 public function update_inviter_id( $user_id, $inviter_id )
		 {
		 	try
		 	{
		 		if ( empty ($user_id) || empty($inviter_id))
		 		{
		 			throw new Exception("参数有误！ user_id:{$user_id}, inviter_id:{$inviter_id}");
		 		}

		 		$user_id   = intval($user_id);
		 		$inviter_id = intval($inviter_id);

		 		$strSQL = "SELECT `inviter_id` FROM `sys_login` WHERE `id`={$user_id}";
		 		$rs = $this->db->get_row( $strSQL );

		 		if ( empty($rs) )
		 		{
		 			throw new Exception("无法找到该用户 user_id:{$user_id}, inviter_id:{$inviter_id}");
		 		}

		 		if ( !empty($rs->inviter_id) )
		 		{
		 			throw new Exception("该用户已被绑定 user_id:{$user_id}, inviter_id为:{$rs->inviter_id}");
		 		}

				$strSQL = "UPDATE `sys_login` SET `inviter_id`={$inviter_id} WHERE `id`={$user_id}";
				$rs = $this->db->query($strSQL);

				$msg = "推荐成功！ user_id:{$user_id}, inviter_id:{$inviter_id}";
				$this->log->put('/user/invite', $msg);						// 记录日志

		 	}
		 	catch( Exception $e )
		 	{
				$msg = "推荐失败，原因：{$e->getMessage()}";
				$this->log->put('/user/invite', $msg);						// 记录日志
		 	}
		 }

		 /*
		  * 功能：获取推荐者列表
		  * */
		 public function get_inviter_list( $user_id )
		 {
			$strSQL = "SELECT `id`, `name`,`create_date` FROM `sys_login` WHERE `inviter_id`=$user_id ORDER BY `id` DESC";
			$rs 	= $this->db->get_results( $strSQL );
			return $rs;
		 }


		 /*
		  * 功能：获取推荐者完成订单列表
		  * 参数:
		  * $user_id:指定ID
		  * $inviter_id: 1:推荐者ID  0: 全部订单
		  * */
		 public function get_inviter_order_list( $user_id, $inviter_id=0 )
		 {

			if( $inviter_id == 0 )
			{
				$strSQL = "SELECT * FROM `user_order` WHERE `user_id` in ( SELECT `id` FROM `sys_login` WHERE `inviter_id`={$user_id} ) and `order_status`>=4 ORDER BY `id` DESC";
			}
			else
			{
				$strSQL = "SELECT count(*) as num FROM `sys_login` WHERE `id`={$inviter_id} AND `inviter_id`={$user_id}";			// 查找指定的推荐者是否是自己推荐的
				$num = $this->db->get_var($strSQL);

				if ( $num < 1 )
				{
					return false;
				}

				$strSQL = "SELECT * FROM `user_order` WHERE `user_id`={$inviter_id} and `order_status`>=4 ORDER BY `id` DESC";
			}

			$rs 	= $this->db->get_results( $strSQL );
			return $rs;
		 }


	}
?>
