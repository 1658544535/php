<?php

require_once( dirname(dirname(__FILE__)) . '/global.php');

/*
 * 功能：与前台对应的接口类
 * 参数：
 * @param obj shake_activityBean 		: shake_activity表的操作类
 * @param obj shake_prize_recordsBean 	: shake_prize_records表的操作类
 * @param obj shake_prizeBean 			: shake_prize表的操作类
 * @param obj shake_linkBean 			: shake_link表的操作类
 *
 * */
class api
{
	private $shake_activityBean;
	private $shake_prize_recordsBean;
	private $shake_prizeBean;
	private $shake_linkBean;
	private $now_activity;					// 当前的活动信息
	private $nUserID;						// 用户ID
	private $shake_user_info;				// 游戏参与者的信息
	private $conn;							// 数据库链接

	public function __construct( $conn, $shake_activityBean, $shake_prize_recordsBean, $shake_prizeBean, $shake_linkBean )
	{
		$this->conn 					= $conn;
		$this->shake_activityBean 		= $shake_activityBean;
		$this->shake_prize_recordsBean 	= $shake_prize_recordsBean;
		$this->shake_prizeBean 			= $shake_prizeBean;
		$this->shake_linkBean			= $shake_linkBean;
		$this->now_activity 			= $this->get_activity_info();
	}

	function __get( $key )
	{
		return $this->$key;
	}

	function __set( $key, $val )
	{
		$this->$key = $val;
	}

	/*
	 * 功能：获取当前正在进行中的活动
	 * */
	private function get_activity_info()
	{
		$arrWhere['status'] = 1;
		$arrCol = array('id','title','starttime','endtime','play_num','status');
		$strOrderBy = '`id` DESC';
		return $this->shake_activityBean->get_one( $arrWhere, $arrCol, $strOrderBy );
	}

	/*
	 * 功能：获取该活动的奖品列表
	 *
	 * @return  null没有奖品信息
	 * */
	 public function get_activity_prize()
	 {
	 	do
	 	{
			$arrWhere = array(
	 			'shake_id' 	=> $this->now_activity->id,
	 			'status'	=> 1
		 	);

		 	$rs = $this->shake_prizeBean->get_list( $arrWhere );

		 	if ( $rs == null )
		 	{
		 		$data = null;
		 		break;
		 	}

			$data 			= array();
			$probability	= 0;

			foreach ( $rs as $arr )
		 	{
		 		if ( $arr->num > 0 )
		 		{
		 			$probability += $arr->probability;
		 			$data['probability'] = $probability;
		 			$data['goods'][$arr->id] = (array)$arr;
		 		}
		 		else
		 		{
		 			Log::DEBUG( '活动【'. $this->now_activity->id .'】中的奖品为【' . $arr->id . ' -- ' . $arr->name . '】数量为0，该奖品自动设置为无效！' );
					$sql = "UPDATE `shake_prize` SET `status`=0 WHERE `id`={$arr->id}";
					$this->conn->query($sql);
		 		}
		 	}

		 	if ( count( $data ) < 1 )
		 	{
		 		$data = null;
		 	}

	 	}while(0);

		return $data;
	 }

	 /*
	  * 抽奖（获取抽到的奖项）
	  *
	  * @param int $nUser： 抽奖的用户
	  * @return int -1奖品发送完，活动结束  0用户抽中的奖品数量为0  >0奖品ID
	  * */
	 private function get_prize( $arrPrizeList )
	 {
		foreach ( $arrPrizeList['goods'] as $prize )
		{
			$proArr[$prize['id']] = $prize['probability'];
		}

		$nPrizeID = get_rand( $proArr );								// 获取用户抽到的奖品编号

		// 实时查询数据表奖品的数量
		$this->conn->query("BEGIN");
		$sql = "SELECT `num`,`name`,`prize_no` FROM `shake_prize` WHERE `id`={$nPrizeID} FOR UPDATE";
		$rs = $this->conn->get_row($sql);

		if ( $rs->num > 0 )
		{
			Log::DEBUG( '用户 【 ' . $this->nUserID . ' 】 抽到的奖品ID为 【'. $nPrizeID .'】, 该奖品数量为 【'. $rs->num .'】' );
			$sql = "UPDATE `shake_prize` SET `num`=`num`-1 WHERE `id`={$nPrizeID}";
			$this->conn->query($sql);

			if ( $rs->prize_no == 1 || $rs->prize_no == 0  )	//如果是红包则设置为已领取
			{
				$status 	=	$rs->prize_no == 1 ? 1 : 0;
				$arrParam = array(
					'userid'		=> $this->nUserID,
					'prize_id'		=> $nPrizeID,
					'shake_id'		=> $this->now_activity->id,
					'addtime'		=> time(),
					'is_used'		=> 1,
					'used_time'		=> time(),
					'status'		=> $status
				);
			}
			else
			{
				$arrParam = array(
					'userid'		=> $this->nUserID,
					'prize_id'		=> $nPrizeID,
					'shake_id'		=> $this->now_activity->id,
					'addtime'		=> time(),
					'status'		=> 1
				);
			}

			$this->shake_prize_recordsBean->create( $arrParam );				// 添加抽奖记录到记录表中

			$is_get = TRUE;
		}
		else
		{
			Log::DEBUG( '用户 【 ' . $this->nUserID . ' 】 抽到的奖品ID为 【'. $nPrizeID .'】, 因为数量为0则需要重新抽奖' );
			$is_get = FALSE;
		}

		$this->conn->query("COMMIT");

		return $is_get ? $arrPrizeList['goods'][$nPrizeID] : FALSE;			// 获取用户抽到奖品的信息
	 }


	 /*
	  * 功能：获取指定用户的已抽奖的次数
	  * */
	 private function get_lottery_draw_num()
	 {
	 	$arrParam = array(
	 		'userid'		=> $this->nUserID,
			'shake_id'		=> $this->now_activity->id,
	 	);

	 	$rs = $this->shake_prize_recordsBean->get_list( $arrParam );

	 	return count($rs);
	 }

	 /*
	  * 功能：获取指定用户允许抽奖的次数
	  * */
	 private function get_user_allow_lottery_draw_num()
	 {
	 	return $this->now_activity->play_num;			// 后台设置允许用户参与的次数
	 }


	 /*
	 * 功能：用户进行抽奖，并返回获奖信息
	 *
	 * @param int $nUserID  用户ID
	 * @return int 0获得的奖品数量为0需重新抽取  -1奖品都发送完 -2没有进行中的活动  array奖品信息
	 *
	 * 流程：
	 * 1、判断有没正在进行的活动          				如果没有活动 (-2)
	 * 2、获取正在进行的活动的奖品					如果没有奖品 (-1)
	 * 3、抽奖并获取奖品信息(减少奖品数量，写入数据)		如果为FLASE则说明获得的奖品数量为0 (0)
	 *
	 * */
	 public function set_prize_record()
	 {
	 	if ( $this->now_activity == null )
	 	{
	 		Log::DEBUG( '没有进行中的活动！！' );
	 		return -2;
	 	}

	 	$arrPrizeList = $this->get_activity_prize();						// 获取活动奖品

	 	if ($arrPrizeList == null )
	 	{
	 		Log::DEBUG( '进行中的活动奖品已经发完，活动结束！！' );
	 		return -1;
	 	}

		$arrPrizeInfo = $this->get_prize($arrPrizeList);					// 进行抽奖，并得到抽到的奖品信息

		if ( $arrPrizeInfo === FALSE )
		{
			return 0;
		}

		unset($arrPrizeInfo['id']);
		unset($arrPrizeInfo['num']);
		unset($arrPrizeInfo['probability']);
		return $arrPrizeInfo;

	 }


	 /*
	  * 功能：检测用户是否允许抽奖
	  * */
	 public function is_allow_lottery_draw()
	 {
	 	$nUserLotteryDrawNum 		= $this->get_lottery_draw_num();				// 获取指定用户的已经抽奖次数
	 	$nUserAllowLotteryDrawNum 	= $this->get_user_allow_lottery_draw_num();		// 获取指定用户的允许抽奖的次数

	 	return ( $nUserLotteryDrawNum >= $nUserAllowLotteryDrawNum ) ? false : true;
	 }


	 /*
	  * 功能：获取游戏参与者的信息
	  * */
	 public function get_shake_user_info()
	 {
	 	$arrParam = array(
	 		'openid' => $this->nUserID
	 	);

	 	$arrCol = array( 'subscribe' );

		return $this->shake_linkBean->get_one( $arrParam, $arrCol);
	 }
}
?>