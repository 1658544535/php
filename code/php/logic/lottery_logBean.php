<?php
if ( !defined('HN1') ) die("no permission");

class lottery_logBean{
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
     * 添加记录
     *
     * @param array $data 数据
     *  uid 会员id
     *  prize 奖品
     *  ptype 奖品类型
     * @return boolean
     */
    public function add($data){
        $sql = "INSERT INTO `lottery_log`(`user_id`,`time`,`prize`,`prize_type`,`prize_val`) VALUES({$data[uid]},".time().",'{$data[prize]}',{$data[ptype]},'{$data[pval]}')";
        return $this->db->query($sql) ? true : false;
    }

    /**
     * 更改记录的拥有者
     *
     * @param integer $oldUid 旧的拥有者
     * @param integer $newUid 新的拥有者
     * @return boolean
     */
    public function change_owner($oldUid, $newUid){
        $sql = 'UPDATE `lottery_log` SET `user_id`='.$newUid.' WHERE `user_id`='.$oldUid;
        return $this->db->query($sql);
    }
}