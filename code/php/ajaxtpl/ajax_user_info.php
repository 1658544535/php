<?php
/**
 * 用户
 */
define('HN1', true);
require_once('../global.php');

require_once LOGIC_ROOT.'comBean.php';
$objUser = new comBean($db, 'sys_login');

$openid = $_SESSION['openid'];
$userInfo = empty($openid) ? null : $objUser->get(array('openid'=>$openid));
?>
<?php if(empty($userInfo)){ ?>
    <dl class="user_btn_warp">
        <a href="/user_binding" class="login_btn">
            <dd>绑定帐号</dd>
        </a>
    </dl>
<?php }else{ ?>
    <dl style="margin-left:15px;">
        <dd>
            <span style="float:left; color:#fff; font-size:13px;"><?php echo $userInfo->name; ?></span>
            <img src="images/user/user_type.png" />
        </dd>
    </dl>
<?php } ?>
