<?php
define('HN1', true);
require_once('../global.php');

require_once LOGIC_ROOT.'hongbao_logBean.php';

$_GET['page'] = intval($_GET['page']);
$page = $_GET['page'] ? $_GET['page'] : 1;

$objHBL = new hongbao_logBean();
$objHBL->db = $db;
$user = $_SESSION['userinfo'];
$condition = array('uid'=>$user->id);
$list = $objHBL->search($condition, $page, 10);
?>

<?php foreach($list['DataSet'] as $_hongbao){ ?>
    <div class="order_list">
        <div class="order_list_title">
            <?php echo $_hongbao->remark;?>
            <span class="status_desc"<?php if($_hongbao->money < 0){?> style="color:#999"<?php } ?>>
                <?php echo $_hongbao->money/100;?>元
            </span>
        </div>
        <div class="coupon_detail"><?php echo date('Y-m-d H:i:s', $_hongbao->log_time);?></div>
    </div>
<?php } ?>
