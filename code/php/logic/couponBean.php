<?php
if ( !defined('HN1') ) die("no permission");

class couponBean{
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
     * 生成劵码(时间戳+5位随机数字)
     *
     * @return string
     */
    private function genNo(){
        $str1 = '0123456789';
        return time().substr(str_shuffle($str1), 0, 5);
//        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01234546789';
//        list($mic, $sec) = explode(' ', microtime());
//        $hsec = $mic * 1000;
//        $str = str_shuffle($str);
//        return date('YmdHis', $sec).intval($hsec).substr($str, 0, 3);
    }

    /**
     * 获取优惠券规则信息
     *
     * @param integer $id 优惠券id
     * @return object
     */
    public function get($id){
        $sql = 'SELECT * FROM `coupon` WHERE `coupon_id`='.$id;
        return $this->db->get_row($sql);
    }

    /**
     * 绑定优惠券给会员
     *
     * @param integer $uid 会员id
     * @param integer $cid 优惠券id
     * @param string $cpnno 券码
     * @param array $extparam 额外参数
     *      starttime 有效开始时间
     *      endtime 有效结束时间
     *      source 来源类型
     * @return boolean
     */
    public function bind_user($uid, $cid, &$cpnno='', $extparam=array()){
        $result = false;
        $objCpn = $this->get($cid);
        if(!empty($objCpn)){
            $cpnno = $this->genNo();
            !isset($extparam['source']) && $extparam['source'] = 5;
            $sql = "INSERT INTO `user_coupon`(`coupon_no`,`user_id`,`coupon_id`,`status`,`gen_time`,`valid_stime`,`valid_etime`,`source`) VALUES('{$cpnno}',{$uid},{$cid},".$objCpn->status.",".time().",'{$extparam[starttime]}','{$extparam[endtime]}',{$extparam[source]})";
            $result = $this->db->query($sql);
            $result = $result ? true : false;
        }
        return $result;
    }

    /**
     * 根据券码获取券信息
     *
     * @param string $no 券码
     * @return object
     */
    public function get_by_no($no){
        $sql = "SELECT c.*,uc.`coupon_no`,uc.`user_id`,uc.`status` AS cpn_status,uc.`gen_time`,uc.`used`,uc.`use_time`,uc.`valid_stime` AS usercoupon_valid_stime,uc.`valid_etime` AS userconpon_valid_etime FROM `user_coupon` AS uc LEFT JOIN `coupon` AS c ON uc.`coupon_id`=c.`coupon_id` WHERE uc.`coupon_no`='{$no}'";
        return $this->db->get_row($sql);
    }

    /**
     * 查找优惠券信息列表
     *
     * @param array $cond 条件
     *  uid integer|array 会员id
     *  type integer 类型，0兑换产品，1满m减n金额
     *  valid boolean 有效状态，true有效(有有效期内且未被禁用)，false无效(未到使用期限/已过期/被禁用)
     *  used boolean 使用状态，false未使用，true已使用
     *  useTime string 使用期限，over过期，use有限期内，
     * @param integer $page 页数，0为全部
     * @param integer $per 每页数量
     * @param string $orderby 生成时间排序
     * @return array
     */
    public function search_info_list($cond=array(), $page=0, $per=10, $orderby='ASC'){
        $time = time();
        $where = array(1);
        $cond['uid'] = 125;
        isset($cond['uid']) && $where[] = is_array($cond['uid']) ? 'uc.`user_id` IN ('.implode(',', 21).')' : 'uc.`user_id`='.$cond['uid'];
        isset($cond['type']) && $where[] = 'c.`type`='.$cond['type'];
        isset($cond['used']) && $where[] = 'uc.`used`='.($cond['used'] ? 1 : 0);
        if(isset($cond['valid'])){
            if($cond['valid']){
                $where[] = 'c.`status`=1';
                $where[] = 'uc.`status`=1';
                $where[] = '((uc.`valid_stime`=0) OR (uc.`valid_stime`<='.$time.'))';
                $where[] = '((uc.`valid_etime`=0) OR (uc.`valid_etime`>='.$time.'))';
            }else{
                $where[] = '(c.`status`=0 OR uc.`status`=0 OR ((uc.`valid_stime`>0) AND (uc.`valid_stime`>'.$time.')) OR ((uc.`valid_etime`>0) AND (uc.`valid_etime`<'.$time.')))';
            }
        }
        if(isset($cond['useTime'])){
            switch($cond['useTime']){
                case 'use':
                    $where[] = '((uc.`valid_stime`=0) OR (uc.`valid_stime`<='.$time.'))';
                    $where[] = '((uc.`valid_etime`=0) OR (uc.`valid_stime`>='.$time.'))';
                    break;
                case 'over':
                    $where[] = 'uc.`valid_etime`>0';
                    $where[] = 'uc.`valid_etime`<'.$time;
                    $where[] = 'uc.`used`=0';
                    break;
            }
        }
        $sql = "SELECT c.*,uc.`coupon_no`,uc.`user_id`,uc.`status` AS cpn_status,uc.`gen_time`,uc.`used`,uc.`use_time`,uc.`valid_stime` AS usercoupon_valid_stime,uc.`valid_etime` AS userconpon_valid_etime FROM `user_coupon` AS uc LEFT JOIN `coupon` AS c ON uc.`coupon_id`=c.`coupon_id` WHERE ".implode(' AND ', $where);
        $sql .= ' ORDER BY uc.`used` ASC,uc.`gen_time` '.($orderby ? $orderby : 'ASC');
echo $sql;
        if($page > 0){
            $list = get_pager_data($this->db, $sql, $page, $per);
        }else{
            $list = array();
            $_list = $this->db->get_results($sql);
            if(!empty($_list)){
                foreach($_list as $k => $v){
                    $v->content = json_decode($v->content);
                    $list[$k] = $v;
                }
            }
        }
        return $list;
    }

//    /**
//     * 查找可使用的满减类型的券
//     *
//     * @param number $money 满足使用条件的金额
//     * @param array $cond 条件
//     *  uid integer|array 会员id
//     *  valid boolean 有效状态，true有效(有有效期内且未被禁用)，false无效(未到使用期限/已过期/被禁用)
//     *  used boolean 使用状态，false未使用，true已使用
//     * @param integer $page 页数，0为全部
//     * @param integer $per 每页数量
//     * @return array
//     */
//    public function search_discount_money($money, $cond, $page=0, $per=10){
//        $return = array();
//        $cond['type'] = 1;
//        $list = $this->search_info_list($cond);
//        foreach($list as $_cpn){
//            $content = unserialize($_cpn['content']);
//            if(!$content) continue;
//            ($content['om'] >= $money) && $return[] = $_cpn;
//        }
//        return $return;
//    }

    /**
     * 使用优惠券
     *
     * @param string $no 券码
     * @param integer $user_id 会员id
     * @return boolean
     */
    public function use_coupon($no, $user_id){
        $result = false;
        if($no && $user_id){
            $sql = 'UPDATE `user_coupon` SET `used`=1,`use_time`='.time()." WHERE `coupon_no`='{$no}' AND `user_id`={$user_id}";
            $result = $this->db->query($sql);
        }
        return $result;
    }

    /**
     * 关联使用到的订单
     *
     * @param integer $order_id 订单号
     * @param string $cpn_no 券码
     * @param numeric $money 优惠券面额
     * @param integer $status 状态
     * @return boolean
     */
    public function relate_order($order_id, $cpn_no, $money=0, $status=0){
        $result = false;
        if($order_id && $cpn_no){
            $sql = "INSERT INTO `coupon_order`(`order_id`,`coupon_no`,`rel_time`,`used_price`,`status`) VALUES('{$order_id}','{$cpn_no}',".time().",{$money},{$status})";
            $result = $this->db->query($sql);
        }
        return $result;
    }

    /**
     * 获取订单所使用的优惠券
     *
     * @param integer $oid 订单id
     * @param integer $paystate 支付使用优惠券的状态，0不限，1已使用，2未使用
     * @return array
     */
    public function get_by_order($oid, $paystate=0)
    {
        $list = array();
        if($oid)
        {
            $cpnNos = array();
            $sql = 'SELECT * FROM `coupon_order` WHERE `order_id`='.$oid;
            switch($paystate){
                case 1:
                    $sql .= ' AND (`status`=1 OR `used_price`>0)';
                    break;
                case 2:
                    $sql .= ' AND (`status`=0 OR `used_price`>0)';
                    break;
            }
            $rs = $this->db->get_results($sql);

            if(!empty($rs))
            {
                $mapCpnAmount = array();
                foreach($rs as $v)
                {
                    $cpnNos[] = $v->coupon_no;
                    $mapCpnAmount[$v->coupon_no] = $v->used_price;
                }

                if(!empty($cpnNos))
                {
                    $sql = "SELECT c.*,uc.`coupon_no`,uc.`user_id`,uc.`status` AS cpn_status,uc.`gen_time`,uc.`used`,uc.`use_time` FROM `coupon` AS c LEFT JOIN `user_coupon` AS uc ON c.`coupon_id`=uc.`coupon_id` WHERE uc.`coupon_no` IN ('".implode("','", $cpnNos)."')";
                    $list = $this->db->get_results($sql);
                    foreach($list as $_k => $_v){
                        $list[$_k]->cpn_use_amount = $mapCpnAmount[$_v->coupon_no];
                    }
                }
            }
        }
        return $list;
    }

    /**
     * 更改优惠券的拥有者
     *
     * @param integer $oldUid 旧的拥有者
     * @param integer $newUid 新的拥有者
     * @return boolean
     */
    public function change_owner($oldUid, $newUid){
        $sql = 'UPDATE `user_coupon` SET `user_id`='.$newUid.' WHERE `user_id`='.$oldUid;
        return $this->db->query($sql);
    }

    /**
     * 根据信息获取优惠券信息
     *
     * @param array $info 指定的信息
     *      type 类型
     *      content 内容参数
     * @return object
     */
    public function getByInfo($info){
        $sql = "SELECT * FROM `coupon` WHERE `type`={$info[type]} AND `content`='{$info[content]}'";
        return $this->db->get_row($sql);
    }

    /**
     * 激活
     *
     * @param string $cpnno 券号
     * @param integer $uid 用户id
     * @param array $info 其他信息
     *      cpnid 优惠券id
     *      start 有效开始时间
     *      end 有效结束时间
     *      source 来源类型
     * @return boolean
     */
    public function activate($cpnno, $uid, $info=array()){
        !isset($info['source']) && $info['source'] = 5;
        $val = array('`user_id`='.$uid, '`gen_time`='.time(), '`source`='.$info['source']);
        isset($info['cpnid']) && $val[] = '`coupon_id`='.$info['cpnid'];
        isset($info['start']) && $val[] = '`valid_stime`='.$info['start'];
        isset($info['end']) && $val[] = '`valid_etime`='.$info['end'];
        echo $sql = "UPDATE `user_coupon` SET ".implode(',', $val)." WHERE `coupon_no`='{$cpnno}'";
        return $this->db->query($sql);
    }

    /**
     * 获取用户使用状态的优惠券数量
     *
     * @param integer $uid 用户id
     * @param integer $used 使用状态，0未使用，1已使用，null不限
     * @return integer
     */
    public function getUserUseCount($uid, $used=null){
        $count = 0;
        if($uid){
            $sql = 'SELECT COUNT(*) AS num FROM `user_coupon` WHERE `user_id`='.$uid;
            in_array($used, array(0,1)) && $sql .= ' AND `used`='.$used;
            if($used == 0){
                $time = time();
                $sql .= ' AND `valid_stime`<='.$time.' AND `valid_etime`>='.$time;
            }
            $row = $this->db->get_row($sql);
            $count = $row->num;
        }
        return $count;
    }
}