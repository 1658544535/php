<?php
if ( !defined('HN1') ) die("no permission");


class hongbao_logBean {
    private $db;

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
     * @param integer $uid 会员id
     * @param array $data 记录信息
     *  money 红包金额，负数为减少
     *  remark 备注说明
     * @return boolean
     */
    public function add($uid, $data)
    {
        $success = false;
        if($uid)
        {
            $sql = "INSERT INTO `hongbao_log`(`user_id`,`log_time`,`money`,`remark`,`type`) VALUES({$uid},".time().",{$data['money']},'{$data['remark']}','{$data['type']}')";
            $success = $this->db->query($sql);
        }
        return $success;
    }

    /**
     * 列表
     *
     * @param array $cond 筛选条件
     *  uid 会员id
     * @param integer $page 当前页数
     * @param integer $per 每页数量
     * @return array
     */
    public function search($cond, $page=1, $per=10, $orderby='DESC'){
        $where = array(1);
        $where[] = '`user_id`='.$cond['uid'];
        $sql = 'SELECT * FROM `hongbao_log` WHERE '.implode(' AND ', $where).' ORDER BY `log_time` '.($orderby ? $orderby : 'DESC');
        $pager = get_pager_data($this->db, $sql, $page, $per);
        return $pager;
    }

    /**
     * 更改记录拥有者
     *
     * @param integer $oldUid 旧拥有者id
     * @param integer $newUid 新拥有者id
     * @return boolean
     */
    public function change_owner($oldUid, $newUid){
        $sql = 'UPDATE `hongbao_log` SET `user_id`='.$newUid.' WHERE `user_id`='.$oldUid;
        return $this->db->query($sql);
    }
}