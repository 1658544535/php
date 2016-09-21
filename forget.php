<?php
/**
 * 忘记密码
 */
define('HN1', true);
require_once('./global.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $mobile = trim($_POST['mobile']);
    $verify = trim($_POST['verify']);
    $password = trim($_POST['password']);

    $failureUrl = '/forget.php';
    empty($mobile) && redirect($failureUrl, '手机号不能为空');
    empty($verify) && redirect($failureUrl, '验证码不能为空');
    empty($password) && redirect($failureUrl, '密码不能为空');
    ($verify != $_SESSION['modify_pwd_captcha']) && redirect($failureUrl, '验证码错误');

    require_once LOGIC_ROOT.'sys_loginBean.php';
    $objSysLogin = new sys_loginBean();
    $objSysLogin->modifyPassword($db, $password, $mobile);
    unset($_SESSION['modify_pwd_captcha']);
    redirect('/user_binding?act=user_bind', '密码设置成功');
}

$action = (isset($_GET['act']) && trim($_GET['act'])) ? $_GET['act'] : '';
switch($action){
    case 'sendcaptcha':
        $mobile = trim($_GET['m']);
        empty($mobile) && ajaxResponse(false, '手机号不能为空');
        !preg_match("/^1[0-9]{10}$/", $mobile) && ajaxResponse(false, '请填写正确的手机号');
        
        include_once(LIB_ROOT . 'SetKey.php');
        $SetKey = new SetKey();
        $captchaUrl = 'http://b2c.taozhuma.com/v3.3/captcha.do?&phone='.$mobile.'&source=2'; 
//            $captchaUrl = 'http://ext1.taozhuma.com/v3.3/captcha.do?&phone='.$mobile.'&source=2';
        $SetKey->getUrlParam( 'phone='.$mobile.'&source=2' );
        $sign 	= $SetKey->getSign();

        $captchaUrl	.= '&sign='.$sign;
   
//         $result = file_get_contents($captchaUrl);             
       
//         $result = json_decode($result, true);
        
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $captchaUrl);
         
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      
        curl_setopt($ch, CURLOPT_USERAGENT,'MicroMessenger');

        $data = curl_exec($ch);
        
        $result = json_decode($data);

        if($result->success == 'true'){
        	$_SESSION['modify_pwd_captcha'] = $result->result->captcha;
            ajaxResponse(true, '已发送');
        }else{
            ajaxResponse(false, $result->error_msg);
        }
        break;
}



include "tpl/forget_web.php";