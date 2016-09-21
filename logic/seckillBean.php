<?php
/**
 * 秒杀
 */
if ( !defined('HN1') ) die("no permission");

include_once(LOGIC_ROOT.'comBean.php');
class seckillBean extends comBean{
    /**
     * 根据开始时间获取活动信息
     *
     * @param string $time 时间点
     * @param string $date 日期
     * @return object
     */
    public function getActivityByTime($time, $date){
        $sql = "SELECT * FROM `activity_time` WHERE `activity_date`='{$date}' AND `begin_time`='{$time}' AND `channel`=2";
        return $this->conn->get_row($sql);
    }

    /**
     * 获取活动对应的商品
     *
     * @param integer $actid 活动id
     * @return array
     */
    public function getActivityProducts($actid){
        $sql = 'SELECT p.*,ag.`id` AS act_goods_id,ag.`sorting` AS act_sorting,ag.`time_id`,ag.`active_price`,ag.`tips`,ag.`status` AS act_status,ag.`create_by` AS act_create_by,ag.`create_date` AS act_create_date,ag.`update_by` AS act_update_by,ag.`update_date` AS act_update_date,ag.`activity_stock`,ag.`activity_num` FROM `activity_goods` AS ag LEFT JOIN `product` AS p ON ag.`product_id`=p.`id` WHERE ag.`time_id`='.$actid.' AND ag.`status`=1 AND p.`status`=1 ORDER BY ag.`sorting` DESC';
        return $this->conn->get_results($sql);
    }

    /**
     * 获取指定产品中有效的秒杀产品
     *
     * @param array $pid 产品id
     * @return array(productid=>price)
     */
    public function getValidProduct($pid){
        $result = array();
        $time = date('H:i', time());
        $sql = "SELECT * FROM `activity_time` WHERE `begin_time`<='{$time}' AND `end_time`>'{$time}' AND `channel`=2";
        $actiInfo = $this->conn->get_row($sql);
        if(!empty($actiInfo)){
            $actiPros = $this->getActivityProducts($actiInfo->id);
            if(!empty($actiPros)){
                foreach($actiPros as $v){
                    (in_array($v->id, $pid) && $v->status && $v->act_status && ($v->activity_stock > 0) && ($v->activity_num && $v->activity_stock <= $v->activity_num)) && $result[$v->id] = $v;
                }
            }
        }
        return $result;
    }

    /**
     * 减少库存
     *
     * @param integer $id 活动产品id
     * @param integer $num 减少数量
     */
    public function reduceStore($id, $num){
        $num = intval($num);
        $sql = 'UPDATE `activity_goods` SET `activity_stock`=`activity_stock`-'.$num.' WHERE `id`='.$id.' AND `activity_stock`-'.$num.'>=0';
        return $this->conn->query($sql);
    }
}