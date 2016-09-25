<?php
class GrouponModel extends Model{
	public function __construct($db, $table=''){
        $table = 'groupon_activity';
        parent::__construct($db, $table);
    }

	/**
	 * 获取团购信息
	 *
	 * @param integer $id 团购活动信息
	 * @return array
	 */
	public function getInfo($id){
		$groupon = $this->get(array('id'=>$id), '*', ARRAY_A);
		if(!empty($groupon)){
			//已团购人数
			$groupon['user_count'] = $this->getCount(array('activity_id'=>$groupon['id']), 'groupon_user_record');
			//剩余人数
			$groupon['surplus_num'] = $groupon['num'] - $groupon['user_count'];
		}
		return $groupon;
	}

	/**
	 * 添加购买记录
	 *
	 * @param array $data 相关信息
	 *		activeid 团购id
	 *		type 类型，1普通团，2团免
	 *		uid	购买者id
	 *		couponid 团免券id
	 *		grouponnum 拼团人数
	 *		surplusnum 剩余人数
	 * @param boolean $isLeader 是否团长购买
	 * @return boolean
	 */
	public function addBuyRecord($data, $isLeader){
		$time = date('Y-m-d H:i:s', time());
		$this->startTrans();
		$attendid = 0;
		if($isLeader){
			$actRecData = array(
				'activity_type' => $data['type'],
				'activity_id' => $data['activeid'],
				'user_id' => $data['uid'],
				'num' => $data['grouponnum'],
				'surplus_num' => $data['surplusnum'],
				'status' => 0,
				'create_date' => $time,
				'create_by' => $uid,
				'update_date' => $time,
				'update_by' => $uid,
			);
			$attendid = $this->add($actRecData, 'groupon_activity_record');
			if($attendid == false){
				$this->rollback();
				return false;
			}
		}
		$urStatus = array(1=>0, 2=>1);
		$userRecData = array(
			'activity_type' => $data['type'],
			'activity_id' => $data['activeid'],
			'attend_id' => $attendid,
			'user_id' => $data['uid'],
			'status' => $urStatus[$data['type']],
			'is_head' => $isLeader ? 1 : 0,
			'attend_time' => $time,
			'coupon_id' => intval($data['couponid']),
			'create_date' => $time,
			'create_by' => $uid,
			'update_date' => $time,
			'update_by' => $uid,
		);
		$success = $this->add($userRecData, 'groupon_user_record');
		if($success == false){
			$this->rollback();
			return false;
		}else{
			$this->commit();
			return true;
		}
	}
}
?>