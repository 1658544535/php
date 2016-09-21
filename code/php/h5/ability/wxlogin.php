<?php
//本地开发：获取用户信息
if($_GET['mybug']) {
	$objWxUser = M('h5_ability_wxuser');
	$newUserInfo = $objWxUser->get(array('id' => 1), '*', ARRAY_A);
	$_SESSION[SESS_K_USER] = $newUserInfo;
}

if(!isset($_SESSION[SESS_K_USER]) || empty($_SESSION[SESS_K_USER])){
	$state = trim($_GET['state']);
	if($state == ''){
		$redirectUri = __CURRENT_ROOT_URL__;
		$wxOauthUrl = $gObjWX->getOauthRedirect($redirectUri, 'h5ability', 'snsapi_userinfo');
		header('location:'.$wxOauthUrl);
		exit();
	}else{
		$wxOAT = $gObjWX->getOauthAccessToken();
		$KDatetime = date('Y-m-d H:i:s', $gCurTime);
		$KFile = SYSTEM_LOG.'h5/wx_login_err.txt';
		if($wxOAT === false){
			$KContent = "【{$KDatetime}】获取oauthAccessToken\r\nERROR_CODE: ".$gObjWX->errCode."\r\n".$gObjWX->errMsg."\r\n";
			file_put_contents($KFile, $KContent, FILE_APPEND);
		}else{
			$wxOUser = $gObjWX->getOauthUserinfo($wxOAT['access_token'], $wxOAT['openid']);
			if($wxOUser === false){
				$KContent = "【{$KDatetime}】获取微信用户信息\r\nERROR_CODE: ".$gObjWX->errCode."\r\n".$gObjWX->errMsg."\r\n";
				file_put_contents($KFile, $KContent, FILE_APPEND);
			}else{
				$objWxUser = M('h5_ability_wxuser');
				$newUserInfo = array(
					'openid' => $wxOUser['openid'],
					'nickname' => $wxOUser['nickname'],
					'sex' => $wxOUser['sex'],
					'country' => $wxOUser['country'],
					'province' => $wxOUser['province'],
					'city' => $wxOUser['city'],
					'headimgurl' => $wxOUser['headimgurl'],
					'privilege' => $wxOUser['privilege'],
					'unionid' => $wxOUser['unionid'],
				);
				$user = $objWxUser->get(array('openid'=>$wxOUser['openid']));
				$newUserInfo['privilege'] = json_encode($newUserInfo['privilege']);

				if(empty($user)){
					$newid = $objWxUser->add($newUserInfo);
					if($newid === false){
						$KContent = "【{$KDatetime}】增加新微信用户失败\r\n";
						file_put_contents($KFile, $KContent, FILE_APPEND);
					}else{
						$newUserInfo['id'] = $newid;
					}
				}else{
					$objWxUser->modify($newUserInfo, array('id'=>$user->id));
					$newUserInfo['id'] = $user->id;
				}
				$newUserInfo['privilege'] = json_decode($newUserInfo['privilege'], true);
				$_SESSION[SESS_K_USER] = $newUserInfo;
				$_GET['act'] = '1';
			}
		}
	}
}