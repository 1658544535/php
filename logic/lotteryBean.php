<?php
if ( !defined('HN1') ) die("no permission");

class lotteryBean{
    private $db;
    private $setting;

    public function __get($para_name){
        if(isset($this->$para_name)){
            return($this->$para_name);
        }else{
            return(NULL);
        }
    }

    public function __set($para_name, $val){
        $this->$para_name = $val;
    }

    /**
     * 抽奖
     *
     * @param integer $uid 会员id
     * @return array
     */
    public function lottery(){
        return $this->get_result();
    }

    /**
     * 获得抽奖结果
     *
     * @return array
     */
    private function get_result(){
        $prizes = $this->setting['prize'];
        $chance = array();
        foreach($prizes as $prize){
            if($prize['chance'] == 0) continue;
            $fills = array_fill(0, $prize['chance'], array('type'=>$prize['type'],'data'=>$prize['data']));
            $chance = array_merge($chance, $fills);
        }
        shuffle($chance);
        $result = array_rand($chance);
        return $chance[$result];
    }

    /**
     * 判断能否抽奖
     *
     * @param integer $uid 会员id
     * @return boolean
     */
    public function can_lottery($uid){
        //当天范围
        list($_year, $_month, $_day) = explode('-', date('Y-m-d', time()));
        $trange['start'] = strtotime($_year.'-'.$_month.'-'.$_day.' 0:0:0');
        $trange['end'] = strtotime($_year.'-'.$_month.'-'.$_day.' 23:59:59');

        //未抽则可抽，已抽过则判断是否有额外的抽奖次数
        $sqlExt = 'SELECT * FROM `lottery_log` WHERE `user_id`='.$uid.' AND `time`>='.$trange['start'].' AND `time`<='.$trange['end'];
        $lotteriedNum = count($this->db->get_results($sqlExt));//已抽次数
        if($lotteriedNum == 0) return true;//未抽
//        if($lotteriedNum >= $this->setting['per_day_num']) return false;//每天次数已用完

        //当天抽中可额外的次数
        $sqlExt .= ' AND `prize_type`=2';
        $prizeExtNum = count($this->db->get_results($sqlExt));

        //转发次数
        $sql = 'SELECT * FROM `lottery_forward` WHERE `user_id`='.$uid.' AND `time`>='.$trange['start'].' AND `time`<='.$trange['end'];
        $forwardNum = count($this->db->get_results($sql));

        //如果抽中2次，只转发一次，额外未抽，则只有一次机会，额外抽一次，则没有机会
        //如果抽中2次，转了10次，额外未抽，则有2次机会，额外抽1次，则有1次机会，额外抽2次，则没有机会

        //额外机会次数
        $extNum = min($prizeExtNum, $forwardNum);

        //第1次不限制
        return ($lotteriedNum-intval($this->setting['per_day_free_num']) < $extNum) ? true : false;
    }

    /**
     * 添加转发记录
     *
     * @param integer $uid 会员id
     */
    public function add_forward_log($uid){
        $sql = 'INSERT INTO `lottery_forward`(`user_id`,`time`) VALUES('.$uid.','.time().')';
        $this->db->query($sql);
    }

    /**
     * 获取抽奖信息
     *
     * @param integer $id 抽奖id
     * @return object
     */
    public function get($id){
        $result = null;
        if($id){
            $sql = 'SELECT * FROM `lottery` WHERE `lottery_id`='.$id;
            $result = $this->db->get_row($sql);
        }
        return $result;
    }

    /**
     * 更改转发的拥有者
     *
     * @param integer $oldUid 旧的拥有者
     * @param integer $newUid 新的拥有者
     * @return boolean
     */
    public function change_forward_owner($oldUid, $newUid){
        $sql = 'UPDATE `lottery_forward` SET `user_id`='.$newUid.' WHERE `user_id`='.$oldUid;
        return $this->db->query($sql);
    }
}
?>