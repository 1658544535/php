<?php
define('HN1', true);
require_once('../global.php');

require_once LOGIC_ROOT.'couponBean.php';

$user = $_SESSION['userinfo'];

$_GET['page'] = intval($_GET['page']);
$page = $_GET['page'] ? $_GET['page'] : 1;
$viewType = intval($_GET['vt']);

$objCpn	= new couponBean();
$objCpn->db = $db;

$userid = $user->id;
$condition = array('uid'=>$userid);
switch($viewType){
    case 1://可使用
        $condition['valid'] = true;
        $condition['used'] = false;
        break;
    case 2://已过期
        $condition['useTime'] = 'over';
        break;
}
$list = $objCpn->search_info_list($condition, $page, 10, 'DESC');

$time = time();
foreach($list['DataSet'] as $_k => $v){
    if(!$v->status || !$v->cpn_status){
        $v->useStatus = 0;
        $v->statusMsg = '不可用';
    }elseif($v->userconpon_valid_etime && ($v->userconpon_valid_etime < $time)){
        $v->useStatus = 0;
        $v->statusMsg = '已过期';
    }elseif($v->used){
        $v->useStatus = 0;
        $v->statusMsg = '已使用';
    }else{
        $v->useStatus = 1;
        $v->statusMsg = '可使用';
    }
//    if(!$v->valid_stime && !$v->valid_etime){
//        $v->validTime = '永久有效';
//    }elseif(!$v->valid_stime && $v->valid_etime){
//        $v->validTime = date('Y-m-d H:i:s', $v->valid_etime).'到期';
//    }elseif(!$v->valid_etime && $v->valid_stime){
//        $v->validTime = date('Y-m-d H:i:s', $v->valid_stime).'开始';
//    }else{
//        $v->validTime = date('Y-m-d H:i:s', $v->valid_stime).' 至 '.date('Y-m-d H:i:s', $v->valid_etime);
//    }
    $v->validEndTime = $v->userconpon_valid_etime ? date('Y-m-d', $v->userconpon_valid_etime) : '永久有效';

    //规则
    $_content = json_decode($v->content,true);
    switch($v->type){
        case 0://兑换产品
            break;
        case 1://满m减n
            $v->money = $_content['m'];
            $v->rule = '订单满'.$_content['om'].'元可用';
            break;
        case 2://直减
            $v->money = $_content['m'];
            break;
    }
}
$cpnBG = array(0=>'/images/coupon/tzm-295.png', 1=>'/images/coupon/tzm-294.png');
$noColor = array(0=>'unvalid', 1=>'');
?>
<?php foreach($list['DataSet'] as $_coupon){ ?>
    <?php
    $_stateIcon = '';
    if($_coupon->used){
        $_stateIcon = '/images/coupon/tzm-296.png';
    }elseif($_coupon->userconpon_valid_etime < $time){
        $_stateIcon = '/images/coupon/tzm-297.png';
    }
    ?>
    <div class="coupon-item">
        <div class="cpn-info">
            <div class="cpn-base">
                <span class="cpn-money">￥<?php echo $_coupon->money;?></span>
                <span class="cpn-no <?php echo $noColor[$_coupon->useStatus];?>"><?php echo $_coupon->coupon_no;?></span>
            </div>
            <div class="cpn-binfo">
                <div class="cpn-name"><?php echo $_coupon->name;?></div>
                <?php if(isset($_coupon->rule) && $_coupon->rule){ ?><div class="cpn-rule"><?php echo $_coupon->rule;?></div><?php } ?>
            </div>
        </div>
        <div class="cpn-state">
            <?php if($_stateIcon){ ?><div class="cpn-state-icon"><img src="<?php echo $_stateIcon;?>" /></div><?php } ?>
            <div class="cpn-valid-tip">有效期</div>
            <div><?php echo $_coupon->validEndTime;?></div>
        </div>
        <img class="cpn-bg" src="<?php echo $cpnBG[$_coupon->useStatus];?>" />
        <div class="clear"></div>
    </div>
<?php } ?>