<?php
class GrouponFreeCouponModel extends Model{
	public function __construct($db, $table=''){
        $table = 'group_free_coupon';
        parent::__construct($db, $table);
    }

	/**
	 * 获取用户激活的团免券
	 *
	 * @param integer $uid 用户id
	 * @param array $ext 条件
	 *		valid 有效(已激活/未使用)
	 *		intime 当前处于激活时间段内
	 * @return array
	 */
	public function getUserCoupon($uid, $ext=array('valid'=>true,'intime'=>false)){
		$date = date('Y-m-d H:i:s', time());
		$cond = array('user_id'=>$uid);
		if($ext['valid']){
			$cond['status'] = 1;
			$cond['used'] = 0;
		}
		$cpn = $this->get($cond, '*', ARRAY_A);
		if(!empty($cpn) && isset($ext['intime']) && $ext['intime']){
			$time = time();
			if(($time < strtotime($cpn['active_time'])) || ($time > strtotime($cpn['invalid_time']))){
				$cpn = array();
			}
		}
		return $cpn;
	}
}
?>