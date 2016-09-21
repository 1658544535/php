<?php

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
	private $activity_prize;				// 当前的活动的奖品信息
	private $nUserID;						// 用户ID
	private $shake_user_info;				// 游戏参与者的信息

	public function __construct( $shake_activityBean, $shake_prize_recordsBean, $shake_prizeBean, $shake_linkBean )
	{
		$this->shake_activityBean 		= $shake_activityBean;
		$this->shake_prize_recordsBean 	= $shake_prize_recordsBean;
		$this->shake_prizeBean 			= $shake_prizeBean;
		$this->shake_linkBean			= $shake_linkBean;
		$this->now_activity 			= $this->get_activity_info();
		$this->activity_prize			= $this->get_activity_prize();
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
		$arrCol = array('id','title','starttime','endtime','play_num');
		$strOrderBy = '`id` DESC';
		return $this->shake_activityBean->get_one( $arrWhere, $arrCol, $strOrderBy );
	}

	/*
	 * 功能：获取该活动的奖品列表
	 * */
	 private function get_activity_prize()
	 {
	 	$arrWhere = array(
	 		'shake_id' 	=> $this->now_activity->id,
	 		'status'	=> 1
	 	);

		$arrCol = array('id','prize_no','name','probability','introduce','image');

	 	$rs = $this->shake_prizeBean->get_list( $arrWhere, $arrCol );

		if ( $rs != NULL )
		{
			foreach ( $rs as $arr )
		 	{
		 		$data[$arr->id] = (array)$arr;
		 	}
		}
		else
		{
			$data = $rs;
		}

		return $data;
	 }

	 /*
	  * 功能：抽奖（获取抽到的奖项）
	  * 参数：
	  * @param int $nUser： 抽奖的用户
	  * */
	 private function get_prize()
	 {
		$arrPrizeList = $this->activity_prize;

		foreach ( $arrPrizeList as $prize )
		{
			$proArr[$prize['id']] = $prize['probability'];
		}

		$nPrizeID = get_rand( $proArr );					// 获取用户抽到的奖品编号
		return $this->activity_prize[$nPrizeID];			// 获取用户抽到奖品的信息
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
	 function get_user_allow_lottery_draw_num()
	 {
	 	$per_free_num = $this->now_activity->play_num;			// 后台设置允许用户参与的次数
	 	//$per_free_num = 2;		// 后台设置允许用户参与的次数

	 	$arrWhere = array(
	 		'share_openid'  => $this->nUserID,
	 		'shake_id'		=> $this->now_activity->id,
	 		'subscribe'		=> 1								// 需关注的用户
	 	);

	 	$rs = $this->shake_linkBean->get_list( $arrWhere );

	 	if ( $rs == null )
	 	{
	 		$allow_num = 0;
	 	}
	 	else
	 	{
	 		$allow_num = count($rs);
	 	}

	 	return $per_free_num + $allow_num;
	 }

	 /*
	 * 功能：用户进行抽奖，并返回获奖信息
	 * 参数：
	 * @param int $nUserID  用户ID
	 *
	 * 说明：
	 * 当用户要抽奖的时候，调用此方法。
	 * 此方法做两件事：
	 * 1、获取抽奖结果
	 * 2、将结果写到中奖记录中
	 * */
	 public function set_prize_record()
	 {
		$arrPrizeInfo = $this->get_prize();										// 进行抽奖，并得到抽到的奖品信息

		$arrParam = array(
			'userid'		=> $this->nUserID,
			'prize_id'		=> $arrPrizeInfo["id"],
			'shake_id'		=> $this->now_activity->id,
			'addtime'		=> time()
		);

		$rs = $this->shake_prize_recordsBean->create( $arrParam );				// 添加抽奖记录到记录表中

		unset($arrPrizeInfo['id']);
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
	  * 功能：检测活动是否进行中
	  * 返回值：
	  * @return int  1:有效 / 0:无效
	  * */
	 public function check_activity_status()
	 {
		return ( $this->now_activity->starttime < time() && $this->now_activity->endtime > time() ) ? 1 : 0;
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