<?php
define('HN1', true);
require_once('../global.php');

require_once LOGIC_ROOT.'user_commentBean.php';
require_once LOGIC_ROOT.'user_shopBean.php';
require_once LOGIC_ROOT.'productBean.php';
require_once LOGIC_ROOT.'couponBean.php';
require_once LOGIC_ROOT.'comBean.php';
require_once LOGIC_ROOT.'user_order_detailBean.php';

$user = $_SESSION['userinfo'];
$userid = $user->id;
$user_comment = new user_commentBean();
$user_shop = new user_shopBean();
$product = new productBean();
$user_order_detail 	= new user_order_detailBean();
$objCpn	= new couponBean();
$objCpn->db = $db;
$objOrderDetail = new comBean($db, 'user_order_detail');

$comPerPage = 10;
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perpage = isset($_GET['per']) ? intval($_GET['per']) : $comPerPage;
$repage = isset($_GET['rep']) ? intval($_GET['rep']) : 0;

$notIncOid = array();//不包含的订单id
if($sid == 4){//“待评论”列表不显示所购产品都申请退款且已通过审核的订单
    //已审核通过退款的产品
    $repro = $objOrderDetail->get_list(array('user_id'=>$userid,'re_status'=>4), 'order_id,product_id');
    $repros = array();
    foreach($repro as $v){
        isset($repros[$v->order_id]) ? $repros[$v->order_id]++ : ($repros[$v->order_id]=1);
    }

    //退款产品所在订单所购产品数量
    if(!empty($repros)){
        $reorder = $objOrderDetail->get_list(array('user_id'=>$userid, '__IN__'=>array('order_id'=>array_keys($repros))), 'order_id,product_id');
        $reorders = array();
        foreach($reorder as $v){
            isset($reorders[$v->order_id]) ? $reorders[$v->order_id]++ : ($reorders[$v->order_id]=1);
        }

        if(!empty($reorders)){
            foreach($reorders as $_oid => $_num){
                ($_num == $repros[$_oid]) && $notIncOid[] = $_oid;
            }
        }
    }
}

$cond = array('user_id'=>$userid, 'is_delete_order'=>0);
if($sid > 0){
    $cond['order_status'] = $sid;
    $cond['is_cancel_order'] = 0;
}
!empty($notIncOid) && $cond['__NOTIN__'] = array('id'=>$notIncOid);
$objOrder = new comBean($db, 'user_order');
$ordersList = $objOrder->gets($cond, array('create_date'=>'desc'), $page, $perpage);
if(!empty($ordersList['DataSet'])){//全部
    $_orderids = array();
    foreach($ordersList['DataSet'] as $v){
        $_orderids[] = $v->id;
    }
    $ods = $objOrderDetail->get_list(array('__IN__'=>array('order_id'=>$_orderids)));
    $oproducts = array();
    $closeProNum = array();//各订单中退款成功的产品数量
    $orderProNum = array();//各订单对应的产品数量
    foreach($ods as $v){
        $oproducts[$v->order_id][] = $v;
        isset($orderProNum[$v->order_id]) ? $orderProNum[$v->order_id]++ : ($orderProNum[$v->order_id]=1);
        if($v->re_status == 4){
            isset($closeProNum[$v->order_id]) ? $closeProNum[$v->order_id]++ : ($closeProNum[$v->order_id]=1);
        }
    }
    foreach($ordersList['DataSet'] as $k => $v){
        $ordersList['DataSet'][$k]->products = $oproducts[$v->id];
        //优惠券
        $_coupons = $objCpn->get_by_order($v->id, 1);
        $exCpnIndex = array();
        foreach($_coupons as $_k => $_cpn){
            if($_cpn->cpn_use_amount <= 0){
                $exCpnIndex[] = $_k;
                continue;
            }
            $_content = json_decode($_cpn->content);
            switch($_cpn->type){
                case 1://满m减n
                    if($v->fact_price >= $_content->om){
                        $ordersList['DataSet'][$k]->fact_price -= $_content->m;
                    }else{
                        $exCpnIndex[] = $_k;
                    }
                    break;
                case 2://直减
                    $ordersList['DataSet'][$k]->fact_price -= $_content->m;
                    ($ordersList['DataSet'][$k]->fact_price < 0) && $ordersList['DataSet'][$k]->fact_price = 0;
                    break;
            }
        }
        if(!empty($exCpnIndex)){
            foreach($exCpnIndex as $_index){
                unset($_coupons[$_index]);
            }
        }
        $ordersList['DataSet'][$k]->coupons = $_coupons;
        (!$sid && ($closeProNum[$v->id] == $orderProNum[$v->id])) && $ordersList['DataSet'][$k]->close = true;
    }
}

$selTab = array($sid => 'id="active_tab"');

$__page = $page;
$__index = 1;

if(!empty($ordersList['DataSet'])) {
    foreach ($ordersList['DataSet'] as $order) {
        $commentList = $user_comment->get_results_order($db, $order->id);
        $shop_info = $user_shop->detail($db, $order->suser_id);            // 获取店铺名称
?>
<div class="order_list" id="list-order-item-<?php echo $order->id;?>" pitem="<?php echo $order->id;?>" curpage="<?php echo $__page;?>">
    <div class='product_line_warp'>
        <a href="/shop_detail?id=<?php echo $shop_info->id; ?>" onclick="preShow(<?php echo $order->id;?>)">
            <dt>
                <img src="<?php echo $site_image ?>shop/<?php echo $shop_info->images; ?>" height='30'
                     style="margin:-5px 10px 0 0; float:left;"/>
                <strong><?php echo $shop_info->name; ?></strong>
            <p>
                <?php
                if ($order->close || ($order->is_cancel_order > 0)) {
                    echo "交易关闭";
                } else {
                    switch ($order->order_status) {
                        case 1:
                            echo "等待付款";
                            break;

                        case 2:
                            echo "等待发货";
                            break;

                        case 3:
                            echo "等待收货";
                            break;

                        case 4:
                            echo "待评价";
                            break;

                        case 5:
                            echo "交易成功";
                            break;
                    }
                }
                ?>
            </p>
            </dt>
        </a>

        <a href="/orders_info?order_id=<?php echo $order->id; ?>" onclick="preShow(<?php echo $order->id;?>)">

            <?php
            // 循环属于该订单的产品信息
            $totalPrice = 0;
            $sum_num = 0;

            foreach ($order->products as $cart) {
                $productImage = $product->get_results_productid($db, $cart->product_id);
                $productInfo = $product->details($db, $cart->product_id);
                $sum_num += $cart->num;
                ?>
                <dd>
                    <div class="p_img_warp">
                        <img src="<?php echo $site_image ?>/product/small/<?php echo $productImage->image; ?>"
                             alt="" width="80"/>
                    </div>
                    <div class="p_desc_warp">
                        <p>
                            <?php
                            $name = $cart->product_name;
                            mb_internal_encoding('utf8');//以utf8编码的页面为例
                            //如果内容多余16字
                            echo (mb_strlen($name) > 16) ? mb_substr($name, 0, 16) . '...' : $name;
                            ?>
                        </p>

                        <p>
                            ￥<?php echo number_format($cart->stock_price, 1); ?> * <?php echo $cart->num; ?>
                        </p>
                    </div>
                    <div class="clear"></div>
                </dd>
            <?php } ?>
        </a>
    </div>

    <?php if (!empty($order->coupons)) { ?>
        <div class="order_list_cals" style="padding:10px 10px;">
            <span style="font-weight:bold; font-size:14px;">优惠券：</span>
            <?php foreach ($order->coupons as $_cpn) { ?>
                <span class="priceWarp">
                    <?php echo $_cpn->name; ?>&nbsp;&nbsp;
                </span>
            <?php } ?>
        </div>
    <?php } ?>

    <div class="order_list_cals" style="padding:10px 10px;">
        <p class="priceWarp" style="text-align:right;">
            共 <span style="color:#df434e"><?php echo $sum_num ?></span> 件 &nbsp;&nbsp;
            总金额： <span style="color:#df434e">¥<?php echo number_format($order->fact_price, 1); ?></span>
        </p>
    </div>

    <?php if ($order->order_status != 2 && $order->is_cancel_order == 0) { ?>
        <div class="order_but_warp">
            <?php if ($order->order_status == 1 || $order->order_status == 5) { ?>
                <input style="margin:5px;" name="" type="submit" value="删除订单"
                       onclick='del(<?php echo $order->id; ?>)' class="write_btn"/>
            <?php } ?>
            <?php if ($order->is_cancel_order == 0 && $order->is_delete_order == 0) { ?>
                <?php if ($order->order_status == 1) {    // 如果状态为待付款	 ?>
                    <input style="margin:5px;" name="" type="submit" value="关闭订单"
                           onclick="replace(<?php echo $order->id; ?>);" class="write_btn"/>
                    <input name="" type="submit" value="我要付款"
                           onclick="location.href='orders_confirm?order_id=<?php echo $order->id; ?>';"
                           class="red_btn btn" style="margin:5px;"/>
                <?php } else { ?>
                    <?php if ($order->order_status == 3) { ?>
                        <input name="" type="submit" value="确认收货"
                               onclick="location.href='orders.php?act=confirm&order_id=<?php echo $order->id; ?>&userid=<?php echo $userid; ?>';"
                               class="red_btn btn" style="margin:5px;"/>
                    <?php } else if ($order->order_status == 4) { ?>
                        <?php if ($user_order_detail->get_order_allow_comment($db, $order->id, $userid) > 0) {    //判断订单商品中是否都是退货商品，如果是则不给评论 ?>
                            <input name="" type="submit" value="我要评论"
                                   onclick="location.href='comment?order_id=<?php echo $order->id; ?>';"
                                   class="red_btn btn" style="margin:5px;"/>
                        <?php } ?>
                    <?php } ?>

                    <?php if ($order->consignee_type == 1 && $order->order_status > 2) {        // 如果为物流状态则显示查看物流 ?>
                        <input style="margin:5px;" name="" type="submit" value="查看物流"
                               onclick="location.href='check_express?order_id=<?php echo $order->id; ?>';"
                               class="write_btn btn"/>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<?php
    }
    if($repage){
        if($__index < $comPerPage){
            $__index++;
        }else{
            $__page++;
            $__index = 1;
        }
    }
}
?>