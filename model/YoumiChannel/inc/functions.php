<?php
/**
 * 功能：生成png类型的二维码图片
 * @param string $website 要生成二维码的数据，网址类型，例如：http://www.weixin.com/product_detail.php?id=1
 * @param string $path 保存二维码图片路径
 * @param string $picname 二维码png图片名称，例如：test.png
 * */
function get_qrcode($website,$path="../upfiles/phpqrcode/",$picname = '')
{
	include "../lib/phpqrcode/phpqrcode.php";
	if (preg_match('/^http:\/\//', $website) || preg_match('/^https:\/\//', $website))
	{
		$data= $website;
	}
	else
	{
		$data= '<a href="http://'.$website.'>http://'.$website.'</a>';
	}
	$errorCorrectionLevel="L";
	$matrixPointSize="20";
	if(empty($picname))
	{
		$picname = date('YmdHis',time()).'.png';
	}
	if(empty($path))
	{
		$path = "../upfiles/phpqrcode/";
	}
	if(!file_exists($path))
		mkdir($path, 0777,true);

	QRcode::png($data,$path.$picname,$errorCorrectionLevel,$matrixPointSize);

	return $picname;
}
/**
 * set back url
 *
 */
function setBackUrl() {
	$url = $_SERVER['REQUEST_URI'];
	setSession('BackUrl', $url);
}

/**
 * get back url
 *
 * @param string $default
 */
function getBackUrl($default = '') {
	$default = trim($default) == '' ? 'index.php' : $default;
	$url = getSession('BackUrl');
	$url = $url == null ? '' : $url;
	$url = $url == '' ? $default : $url;
	return $url;
}
/**
 * Url
 *
 * @param string $url
 */
function redirect($url = '', $msg = '') {
	if($url == '')
		$url = 'index.php';

	$strs = '<script type="text/javascript">location.href="' . $url . '";</script>';
	if($msg != '')
		$strs = '<script type="text/javascript">alert("' . $msg . '");location.href="' . $url . '";</script>';

	echo $strs;
	exit();
}

function getSession($key = '') {
	if(session_is_registered('Team.Hn1')) {
		$arr = $_SESSION['Team.Hn1'];
		return isset($arr[$key]) ? $arr[$key] : null;

	} else {
		return null;
	}
}

function setSession($key = '', $value = '') {
	if(session_is_registered('Team.Hn1')) {
		$arr = $_SESSION['Team.Hn1'];
		$arr[$key] = $value;
		$_SESSION['Team.Hn1'] = $arr;

	} else {
		$_SESSION['Team.Hn1'] = array(
			$key => $value,
		);
	}
}
function uploadfile($uploader = 'file', $path = '../upfiles/',$id = '') {
	$return = '';
	$uptypes = array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png','audio/mpeg','audio/mp3');
	$time = date('YmdHis');
	if(!file_exists($path))
		mkdir($path, 0777);
	if(is_uploaded_file($_FILES[$uploader]['tmp_name']))
	{
		$file = $_FILES[$uploader];
		if(in_array($file['type'], $uptypes)) {
			$filename = $file['tmp_name'];
			$pinfo = pathinfo($file['name']);

			$dest = $path . $time . '.' . $pinfo['extension'];
			if($id != '')
			{
				$dest = $path . $id . '.' . $pinfo['extension'];
			}
			if(move_uploaded_file($filename, $dest)) {
				//上传完成
				$pinfo = pathinfo($dest);
				$return = $pinfo['basename'];
			}
		}
	}
	return $return;
}
function uploadfile2($uploader = 'file', $path = '../upfiles/') {
	$return = '';
	$uptypes = array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png','audio/mpeg','audio/mp3');
	$time = date('YmjHis').floor(microtime()*100000);
	var_dump($time);

//	$time = date('YmdHis');
	if(!file_exists($path))
		mkdir($path, 0777);
	if(is_uploaded_file($_FILES[$uploader]['tmp_name']))
	{
		$file = $_FILES[$uploader];
		if(in_array($file['type'], $uptypes)) {
			$filename = $file['tmp_name'];
			$pinfo = pathinfo($file['name']);
			$dest = $path . $time . '.' . $pinfo['extension'];
			if(move_uploaded_file($filename, $dest)) {
				//上传完成
				$pinfo = pathinfo($dest);
				$return = $pinfo['basename'];
			}
		}
	}
	return $return;
}
function ResizeImage($up_folder,$up_mixfolder,$name,$newwidth){

    	$res=explode(".",$name);
   // 	echo $res[1];
    	if($res[1] == "pjpeg"||$res[1] == "PJPEG"||$res[1] == "jpg"||$res[1] == "JPG"||$res[1]== "jpeg"||$res[1]== "JPEG"){
            $im = imagecreatefromjpeg($up_folder.$name);
        }else if($res[1] == "x-png"||$res[1] == "X-PNG"||$res[1] == "png"||$res[1] == "PNG"){
            $im = imagecreatefrompng($up_folder.$name);
        }else if($res[1]== "gif"||$res[1] == "GIF"){
            $im = imagecreatefromgif($up_folder.$name);
        }

    	 if($im){

        //取得当前图片大小
        $width = imagesx($im);
        $height = imagesy($im);
//        $newwidth=250;
        $newheight=$height*$newwidth/$width;
        //生成缩略图的大小

        if($width>$newwidth){
            if(function_exists("imagecopyresampled")){
                $newim = imagecreatetruecolor($newwidth, $newheight);
                imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            }else{
                $newim = imagecreate($newwidth, $newheight);
                imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            }
            ImageJpeg ($newim,$up_mixfolder.$name);
            ImageDestroy ($newim);
        }else{
            ImageJpeg ($im,$up_mixfolder.$name);
        }
        @ImageDestroy ($newim);
        @ImageDestroy ($im);
    	}
}
/**
 * HTML编辑器
 * 仅在panel目录中使用
 * @param string $name
 * @param string $value
 * @param string $width
 * @param string $height
 * @param bool $defaultStyle
 */
function htmlEditor($name = 'htmlEditor1', $value = '', $width = '100%', $height = '100%', $defaultStyle = true) {
	include("../fckeditor/fckeditor.php");
	$sBasePath = dirname($_SERVER['PHP_SELF']);
	$sBasePath = 'fckeditor/' ;

	$oFCKeditor = new FCKeditor($name) ;
	$oFCKeditor->BasePath = $sBasePath ;
	$oFCKeditor->ToolbarSet = $defaultStyle ? 'Default' : 'Basic';
	$oFCKeditor->Value = $value;
	$oFCKeditor->Width = $width;
	$oFCKeditor->Height = $height;
	$oFCKeditor->Create() ;
}


function get_pager_data($link, $sql = '', $page = 1, $pageSize = 20) {
	$recordCount = 0;
	$pageCount = 1;
	$fPageIdx= $pPageIdx = $nPageIdx = $lPageIdx = 1;
	$rows = null;
	$recordCount = $link->get_var("select count(*) from ($sql) as pagertable");
	if($recordCount > 0) {
		$pageCount = $lPageIdx = ceil($recordCount/$pageSize);

		$page = $page <= 0 ? 1 : $page;
		$page = $page > $pageCount ? $pageCount : $page;
		$pPageIdx = $page > 1 ? $page - 1 : 1;
		$nPageIdx = $page >= $pageCount ? $pageCount : $page + 1;

		$start = ($page - 1)*$pageSize;
		$rows = $link->get_results($sql . " limit " . $start . "," . $pageSize);
	}

	$data = array(
		'RecordCount' => $recordCount,
		'PageCount' => $pageCount,
		'PageSize' => $pageSize,
		'CurrentPage' => $page,
		'First'	=> $fPageIdx,
		'Prev' => $pPageIdx,
		'Next' => $nPageIdx,
		'Last' => $lPageIdx,
		'PagerStr' => '',
		'DataSet' => $rows,
	);

	return $data;
}

function get_pager_data_user($link, $sql = '', $page = 1, $pageSize = 20) {
	$recordCount = 0;
	$pageCount = 1;
	$fPageIdx= $pPageIdx = $nPageIdx = $lPageIdx = 1;
	$rows = null;
	$temp = $link->get_results($sql);
//	$recordCount = $link->get_var("select count(*) from ($sql) as pagertable");
	$recordCount = count($temp);
	if($recordCount > 0) {
		$pageCount = $lPageIdx = ceil($recordCount/$pageSize);

		$page = $page <= 0 ? 1 : $page;
		$page = $page > $pageCount ? $pageCount : $page;
		$pPageIdx = $page > 1 ? $page - 1 : 1;
		$nPageIdx = $page >= $pageCount ? $pageCount : $page + 1;

		$start = ($page - 1)*$pageSize;
		$rows = $link->get_results($sql . " limit " . $start . "," . $pageSize);
	}

	$data = array(
		'RecordCount' => $recordCount,
		'PageCount' => $pageCount,
		'PageSize' => $pageSize,
		'CurrentPage' => $page,
		'First'	=> $fPageIdx,
		'Prev' => $pPageIdx,
		'Next' => $nPageIdx,
		'Last' => $lPageIdx,
		'PagerStr' => '',
		'DataSet' => $rows,
	);

	return $data;
}

function getPageredData($link, $sql = '', $page = 1, $pageSize = 20, $url, $argvs) {
	$pdata = get_pager_data($link, $sql, $page, $pageSize);

	$pagerStr = '';
	$pagerUrl = '';
	if(trim($argvs) != '') {
		$xargvs = explode('&', $argvs);
		foreach ($xargvs as $argv)
		{
			if(strpos($argv, 'page=') === false)
				$pagerUrl .= ($pagerUrl == '' ? '' : '&') . $argv;
		}
	}
	$pagerUrl .= ($pagerUrl == '' ? '' : '&') . 'page=';
	$pagerUrl = $url . ($pagerUrl == '' ? '' : '?' . $pagerUrl);

	$pagerStr = 'Page&nbsp;&nbsp;<strong>' . $pdata['CurrentPage'] . '</strong>&nbsp;of&nbsp;<strong>' . $pdata['PageCount'] . '</strong>&nbsp;,&nbsp;&nbsp;&nbsp;';
	$pagerStr .= '<a href="' . $pagerUrl . $pdata['First'] . '">First</a>&nbsp;&nbsp;&nbsp;&nbsp;';
	$pagerStr .= '<a href="' . $pagerUrl . $pdata['Prev'] . '">Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;';
	$pagerStr .= '<a href="' . $pagerUrl . $pdata['Next'] . '">Next</a>&nbsp;&nbsp;&nbsp;&nbsp;';
	$pagerStr .= '<a href="' . $pagerUrl . $pdata['Last'] . '">Last</a>';

	$pdata['PagerStr'] = $pagerStr;

	return $pdata;
}
function getPageredDataCNWap($link, $sql = '', $page = 1, $pageSize = 20, $url, $argvs) {
	$pdata = get_pager_data($link, $sql, $page, $pageSize);

	$pagerStr = '';
	$pagerUrl = '';
	if(trim($argvs) != '') {
		$xargvs = explode('&', $argvs);
		foreach ($xargvs as $argv)
		{
			if(strpos($argv, 'page=') === false)
				$pagerUrl .= ($pagerUrl == '' ? '' : '&') . $argv;
		}
	}
	$pagerUrl .= ($pagerUrl == '' ? '' : '&') . 'page=';
	$pagerUrl = $url . ($pagerUrl == '' ? '' : '?' . $pagerUrl);

	$pagerStr = '&nbsp;&nbsp;第<strong>' . $pdata['CurrentPage'] . '</strong>页&nbsp;&nbsp;共<strong>' . $pdata['PageCount'] . '</strong>页&nbsp;&nbsp;';

	$pagerStr .= '<a href="' . $pagerUrl . $pdata['Prev'] . '">上一页</a>&nbsp;&nbsp;';
	$pagerStr .= '<a href="' . $pagerUrl . $pdata['Next'] . '">下一页</a>&nbsp;&nbsp;';


	$pdata['PagerStr'] = $pagerStr;

	return $pdata;
}
function getPageredDataCN($link, $sql = '', $page = 1, $pageSize = 20, $url, $argvs) {
	$pdata = get_pager_data($link, $sql, $page, $pageSize);

	$pagerStr = '';
	$pagerUrl = '';
	if(trim($argvs) != '') {
		$xargvs = explode('&', $argvs);
		foreach ($xargvs as $argv)
		{
			if(strpos($argv, 'page=') === false)
				$pagerUrl .= ($pagerUrl == '' ? '' : '&') . $argv;
		}
	}
	$pagerUrl .= ($pagerUrl == '' ? '' : '&') . 'page=';
	$pagerUrl = $url . ($pagerUrl == '' ? '' : '?' . $pagerUrl);

	$pagerStr = '&nbsp;&nbsp;第<strong>' . $pdata['CurrentPage'] . '</strong>页&nbsp;&nbsp;共<strong>' . $pdata['PageCount'] . '</strong>页&nbsp;,&nbsp;&nbsp;&nbsp;';
	$pagerStr .= '<a href="' . $pagerUrl . $pdata['First'] . '">第一页</a>&nbsp;&nbsp;&nbsp;&nbsp;';
	$pagerStr .= '<a href="' . $pagerUrl . $pdata['Prev'] . '">上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;';
	$pagerStr .= '<a href="' . $pagerUrl . $pdata['Next'] . '">下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;';
	$pagerStr .= '<a href="' . $pagerUrl . $pdata['Last'] . '">最后一页</a>';

	$pdata['PagerStr'] = $pagerStr;

	return $pdata;
}
/**================================================================*/
function get_pager_data2($link, $sql = '', $page = 1, $pageSize = 20) {
	$recordCount = 0;
	$pageCount = 1;
	$fPageIdx= $pPageIdx = $nPageIdx = $lPageIdx = 1;
	$rows = null;
	$recordCount = $link->get_var("select count(*) from ($sql) as pagertable");

	if($recordCount > 0) {
		$pageCount = $lPageIdx = ceil($recordCount/$pageSize);

		$page = $page <= 0 ? 1 : $page;
		$page = $page > $pageCount ? $pageCount : $page;
		$pPageIdx = $page > 1 ? $page - 1 : 1;
		$nPageIdx = $page >= $pageCount ? $pageCount : $page + 1;

		$start = ($page - 1)*$pageSize;
		$rows = $link->get_results($sql);
	}

	$data = array(
		'RecordCount' => $recordCount,
		'PageCount' => $pageCount,
		'PageSize' => $pageSize,
		'CurrentPage' => $page,
		'First'	=> $fPageIdx,
		'Prev' => $pPageIdx,
		'Next' => $nPageIdx,
		'Last' => $lPageIdx,
		'PagerStr' => '',
		'DataSet' => $rows,
	);

	return $data;
}

function brhtml($str)
{
   $str = str_replace(chr(13),'<br>',$str);
  return $str;
}
function uh($str)
{
   $str = str_replace("'","&#8217;",$str);
  return $str;
}



	function sqlFilter($sql)
	{
		if (!get_magic_quotes_gpc()) {
		  //$sql = addslashes($sql);
		  $sql = mysql_real_escape_string($sql);
		}
		$sql = str_replace('%','\%',$sql);
		return $sql;
	}

	function sqlUpdateFilter($sql)
	{
		if (!get_magic_quotes_gpc()) {
		  //$sql = addslashes($sql);
		  $sql = mysql_real_escape_string($sql);
		}
		return $sql;
	}
	function GetIP(){
	   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			   $ip = getenv("HTTP_CLIENT_IP");
		   else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			   $ip = getenv("HTTP_X_FORWARDED_FOR");
		   else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			   $ip = getenv("REMOTE_ADDR");
		   else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			   $ip = $_SERVER['REMOTE_ADDR'];
		   else
			   $ip = "unknown";
	   return($ip);
	}

	function get_token() {
		global $objWX, $wxOption;
		$accessToken = $objWX->checkAuth($wxOption['appid'], $wxOption['appsecret']);
		return $accessToken;
    }
	function get_access_token($CODE) {//feng add
    	global $app_info;
		$url  = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$app_info['appid']."&secret=".$app_info['secret']."&code=".$CODE."&grant_type=authorization_code";
		list($return_code, $return_content) = http_post_data($url,'');
		$return_content= json_decode($return_content, true);
        return $return_content;
    }
	function http_post_data($url, $data_string) {
        $ch = curl_init();
		@curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
        );
        ob_start();

        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();

        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);
    }

	function get_group($token) {
		$url  = "https://api.weixin.qq.com/cgi-bin/groups/get?access_token=".$token;
		list($return_code, $return_content) = http_post_data($url,'');
		$return_content= json_decode($return_content, true);
		return  $return_content;
    }

	function get_userinfo($token,$openid) {//feng add
		$url  = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid;
		list($return_code, $return_content) = http_post_data($url,'');
		$return_content= json_decode($return_content, true);
		return  $return_content;
    }
	function get_user_guanzhu($token,$NEXT_OPENID1='') {//feng add
		$url  = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$token;
		if($NEXT_OPENID1!="")
			$url =$url."next_openid=".$NEXT_OPENID1;
		list($return_code, $return_content) = http_post_data($url,'');
		$return_content= json_decode($return_content, true);
		return  $return_content;
    }
    function create_openid_orders_message($openid,$orders_number,$orders_products,$product_number,$price,$act_url) {
		global $site;
		$access_token = get_token();
		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
		$data_string='{"touser":"'.$openid.'","template_id":"","url":"'.$site.'orders.php","topcolor":"#FF0000","data":{"first": {"value":"您的订单已创建成功，感谢购买！","color":"#173177"},"orderno":{"value":"'.$orders_number.'","color":"#173177"},"refundno":{"value":"'.$product_number.'","color":"#173177"},"refundproduct":{"value":"￥'.$price.'","color":"#173177"},"remark":{"value":"订单详情：\n'.$orders_products.' 。 \n点击详情可查看订单！","color":"#173177"}}}';
		return http_post_data($url,$data_string);
	}
    function create_openid_prize_message($openid,$prizenumber,$act_url) {
		$access_token = get_token();
		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
		$data_string='{"touser":"'.$openid.'","template_id":"","url":"'.$act_url.'","topcolor":"#FF0000","data":{"first": {"value":"尊敬的客户：恭喜您的砸金蛋中奖啦！","color":"#173177"},"program":{"value":"中秋砸金蛋","color":"#173177"},"result":{"value":"您获得大奖。获奖号码为：'.$prizenumber.'.客服人员将会在活动结束后联系您，请您保存好您的获奖号码","color":"#173177"},"remark":{"value":"订单详情：\n","color":"#173177"}}}';
		return http_post_data($url,$data_string);
	}
    function create_openid_draw_message($openid,$draw_number,$act_url,$nickname,$title) {
		global $site;
		$access_token = get_token();
		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
		$data_string='{"touser":"'.$openid.'","template_id":"","url":"'.$site.'draw_activity.php?activity_id=5","topcolor":"#FF0000","data":{"first": {"value":"您已成功参与抽奖了！\n 恭喜您获得新的抽奖号码，您的抽奖号码为: '.$draw_number.'","color":"#173177"},"keyword1":{"value":"'.$nickname.'","color":"#173177"},"keyword2":{"value":"'.$title.'","color":"#173177"},"keyword3":{"value":"2014-12-25 至 2015-1-6","color":"#173177"},"keyword4":{"value":"公众号","color":"#173177"},"remark":{"value":"更多具体抽奖规则请点击详情","color":"#173177"}}}';
		return http_post_data($url,$data_string);
	}
	function create_openid_draw_message_s($openid,$draw_number,$act_url,$nickname,$title,$friend_name) {
		global $site;
		$access_token = get_token();
		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
		$data_string='{"touser":"'.$openid.'","template_id":"","url":"'.$site.'draw_activity.php?activity_id=5","topcolor":"#FF0000","data":{"first": {"value":"您的好友（'.$friend_name.'）成功参与抽奖了！\n 恭喜您获得新的抽奖号码，您的抽奖号码为: '.$draw_number.'","color":"#173177"},"keyword1":{"value":"'.$nickname.'","color":"#173177"},"keyword2":{"value":"'.$title.'","color":"#173177"},"keyword3":{"value":"2014-12-25 至 2015-1-6","color":"#173177"},"keyword4":{"value":"公众号","color":"#173177"},"remark":{"value":"更多具体抽奖规则请点击详情","color":"#173177"}}}';
		return http_post_data($url,$data_string);
	}
	function test_get_token() {
    	global $app_info, $wxOption;
		$url  = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$wxOption[appid]}&secret={$wxOption[appsecret]}";
		list($return_code, $return_content) = http_post_data($url,'');
		$return_content= json_decode($return_content, true);
        return $return_content['access_token'];
    }
    function test_message() {
		global $site;
		$access_token = test_get_token();
		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
		$data_string='{"touser":"","template_id":"","url":"'.$site.'draw_activity.php?activity_id=5","topcolor":"#FF0000","data":{"first":{"value":"你的投诉已有相关回应。","color":"#000"},"keyword1":{"value":"","color":"#000"},"keyword2":{"value":"2015年02月11日 23:27:44","color":"#000"},"keyword3":{"value":"请点击下面“详情”进入原帖浏览","color":"#000"},"keyword4":{"value":"（仅限上班时间）","color":"#000"},"remark":{"value":"如需进一步回应或补充说明，请使用原账号在原帖下发表评论，同时可继续上传照片。","color":"#000"}}}';
		return http_post_data($url,$data_string);
	}
    function create_openid_news($openid,$act_title,$act_content,$act_url,$picurl='') {
		$access_token = get_token();
		$url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
		$data_string='{"touser":"'.$openid.'","msgtype":"news",    "news":{        "articles": [         {             "title":"'.$act_title.'",             "description":"'.$act_content.'",             "url":"'.$act_url.'",             "picurl":"'.$picurl.'"         }         ]    }}';
		return http_post_data($url,$data_string);
	}

    function create_meun($data,$token) {
		$url  = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
		list($return_code, $return_content) = http_post_data($url,$data);
		$return_content= json_decode($return_content, true);

		if($return_content['errcode']==0){
    		return true;
        }else{
        	 return false;
        }
    }

function getSession_userid() {//feng add
	//如果没有登录，则根据登录时间，生成一个临时的userid
	if($_SESSION['userInfo'] == null && $_SESSION['tempUserInfo'] == null){
		$_SESSION['tempUserInfo'] = time();
	//	$_SESSION['tempUserInfo'] = 5;
	}
	$user = $_SESSION['userInfo'];
	if($user != null){
		$userid = $user->id;
	}else{
		$userid = $_SESSION['tempUserInfo'];
	}
	return $userid;
}

//查看微信支付订单详情
function check_wxpay_order($order_number){
	global $wxOption;
    $access_token= getAccessToken($wxOption['appid'],$wxOption['appsecret']);
    $reponse_array = json_decode($access_token);
    $access_token= $reponse_array->access_token;

    $sign = getSign($order_number,"1219040301","297851fa578bf9b95727631ea47bf1fb");

    $app_signature = getAppsignature($wxOption['appid'],"","out_trade_no=".$order_number."&partner=1219040301&sign=".$sign."","1398900120");
    $data='{"appid" : "'.$wxOption['appid'].'","package" : "out_trade_no='.$order_number.'&partner=1219040301&sign='.$sign.'","timestamp" : "1398900120","app_signature" : "'.$app_signature.'","sign_method" : "sha1"}';
    //echo $data;exit;
    $result = getContent($access_token,'orderquery',$data);
    $result_array = json_decode($result);
    header("content-type:text/html; charset=utf8");
	return $result_array;
  }

  function getSign($number,$partner,$key){
    $content  = "out_trade_no=".$number."&partner=".$partner."&key=".$key;

    $sign   = strtoupper(md5($content));
    return $sign;
  }

  function getAppsignature($appid,$appkey,$package,$timestamp){
    $array=array("appid"=>$appid,"appkey"=>$appkey,"package"=>$package,"timestamp"=>$timestamp);

    $array = formatBizQueryParaMap($array, false);
    return sha1($array);
  }

  function getAppsignature_d($appid,$appkey,$openid,$transid,$out_trade_no,$deliver_timestamp,$deliver_status,$deliver_msg){
    $array=array("appid"=>$appid,
				 "appkey"=>$appkey,
				 "openid"=>$openid,
          		 "transid"=>$transid,
				 "out_trade_no"=>$out_trade_no,
				 "deliver_timestamp"=>$deliver_timestamp,
				 "deliver_status"=>$deliver_status,
			     "deliver_msg"=>$deliver_msg);

    $array = formatBizQueryParaMap($array, false);
    return sha1($array);


  }

  function formatBizQueryParaMap($paraMap, $urlencode){
    $buff = "";
    ksort($paraMap);
    foreach ($paraMap as $k => $v){
    //  if (null != $v && "null" != $v && "sign" != $k) {
          if($urlencode){
           $v = urlencode($v);
        }
        $buff .= strtolower($k) . "=" . $v . "&";
      //}
    }
    $reqPar="";
    if (strlen($buff) > 0) {
      $reqPar = substr($buff, 0, strlen($buff)-1);
    }
    return $reqPar;
  }

  function getContent($access_token,$way,$data){
    $ch = curl_init();
    @curl_setopt($ch, CURLOPT_URL, 'https://api.weixin.qq.com/pay/'.$way.'?access_token='.$access_token);
    @curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    @curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    @curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	@curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
    @curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    @curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    @curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $tmpInfo = curl_exec($ch);
    if (curl_errno($ch)) {
      return curl_error($ch);
    }
    curl_close($ch);
    return $tmpInfo;
  }



  function getAccessToken($appid, $appsecret) {
    $ch = curl_init();
    @curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret");
    @curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    @curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    @curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	@curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
    @curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)");
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    @curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    //@curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $tmpInfo = curl_exec($ch);
    if (curl_errno($ch)) {
      return curl_error($ch);
    }
    curl_close($ch);
    return $tmpInfo;
  }

  function hide_name($name){
	if(strlen($name) > 6){
		return substr($name,0,3)."**".substr($name,strlen($name)-3,strlen($name));
	}else if(strlen($name)>3 && strlen($name)<=6){
		return substr($name,0,3)."**";
	}else{
		return $name;
	}
  }

  //获取上个月的第一天
function getPrevMonthFirstDay($date) {
    return strtotime(date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' -1 month')));
}
//获取上个月的最后一天
function getPrevMonthLastDay($date) {
    return strtotime(date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' -1 day')));
}
//获取本月的第一天
function getCurMonthFirstDay($date) {
    return strtotime(date('Y-m-01', strtotime($date)));
}
//获取本月的最后一天
function getCurMonthLastDay($date) {
    return strtotime(date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month -1 day')));
}

function create_openid_redbag_message_s($openid,$act_url,$nickname,$title,$friend_name) {
	global $site;
	$access_token = get_token();
	$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;

	$data_string='{"touser":"'.$openid.'","template_id":"","url":"'.$site.'redbag_activity.php?activity_id=1","topcolor":"#FF0000","data":{"first": {"value":"您的好友（'.$friend_name.'）成功参与抢红包活动了！\n 恭喜您获得新的抢红包机会，赶紧点击参与吧！","color":"#173177"},"keyword1":{"value":"'.$nickname.'","color":"#173177"},"keyword2":{"value":"'.$title.'","color":"#173177"},"keyword3":{"value":"","color":"#173177"},"keyword4":{"value":"公众号","color":"#173177"},"remark":{"value":"更多具体抢红包规则请点击详情","color":"#173177"}}}';
	return http_post_data($url,$data_string);
}

function get_signature($noncestr,$timestamp,$urls) {//woo add
	global $site;
	$token = get_token();
	$url  = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$token."&type=jsapi";
	list($return_code, $return_content) = http_post_data($url,'');
	$return_content= json_decode($return_content, true);
	$ticket = $return_content['ticket'];
	return sha1("jsapi_ticket=".$ticket."&noncestr=".$noncestr."&timestamp=".$timestamp."&url=".$site.$urls);
}

/**
 * 随机生成7位数的字符串
 */
function create_randomstr( $length = 16 ) {
	$chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$str ="";
	for ( $i = 0; $i < $length; $i++ )  {
		$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
	}
	return $str;
}

/**
 * 随机生成length位数的数字串
 */
function create_number_randomstr( $length = 16 ) {
	$chars = "0123456789";
	$str ="";
	for ( $i = 0; $i < $length; $i++ )  {
		$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
	}
	return $str;
}

function http_get_data($url){
		$ch = curl_init($url) ;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
		$output = curl_exec($ch) ;
		return $output;
    }

function change_txmap($lat,$lng){//woo add
		$url  = "http://apis.map.qq.com/ws/coord/v1/translate?locations=".$lat.",".$lng."&type=3&key=XSYBZ-YE7K4-KRMUR-DHKFJ-W6CHQ-MOF7X";
		$return_content= json_decode(http_get_data($url), true);
        $location = $return_content['locations'][0];
        return $location;
    }
//用户参加摇一摇游戏之后调转到获得奖品的页面时，同时客户得到一条模版消息($user->openid,$re_prize->name,$obj_r->ticket_no,$user->name,$picktime,$booktime);
	function create_shake_prize_message($openid,$prizename,$prizeno,$nickname,$pickuptime,$booktime) {
		$access_token = get_token();
		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;

		$data_string='{"touser":"'.$openid.'","template_id":"","url":"http://weixin.fresh-skin.com/shop_detail.php?"topcolor":"#FF0000","data":{"first": {"value":"尊敬的用户：（'.$nickname.'）\n 您通过摇一摇活动获得奖品【'.$prizename.'】兑奖号为：'.$prizeno.'(一个月内有效)。","color":"#173177"},"keyword1": {"value":"'.$nickname.'","color":"#173177"},"keyword2": {"value":"'.date('Y-m-d',$booktime).'","color":"#173177"},"remark":{"value":"","color":"#173177"}}';


		return http_post_data($url,$data_string);
	}
		//用户兑换奖品时得到一条模版消息($obj_user->openid,$obj_prize->name,$obj->ticket_no,$obj_user->name,$obj->used_time);
	function create_used_prize_message($openid,$prizename,$prizeno,$nickname,$booktime) {
		$access_token = get_token();
		$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;

		$data_string='{"touser":"'.$openid.'","template_id":"","url":"http://weixin.fresh-skin.com/my.php","topcolor":"#FF0000","data":{"first": {"value":"尊敬的用户：（'.$nickname.'）\n 您通过摇一摇活动获得的奖品【'.$prizename.'】 兑奖号为：'.$prizeno.'\n 已于：'.date('Y-m-d',time()).'成功领取，欢迎继续关注，更多惊喜等着您！","color":"#173177"},"keyword1": {"value":"'.$nickname.'","color":"#173177"},"keyword2": {"value":"'.date('Y-m-d',$booktime).'","color":"#173177"},"remark":{"value":"","color":"#173177"}}}';


		return http_post_data($url,$data_string);
	}
function get_card_list() {//woo add
	$token = get_token();
	$url  = "https://api.weixin.qq.com/card/batchget?access_token=".$token;
	$data_string='{"offset":"2","count":"50"}';
	list($return_code, $return_content) = http_post_data($url,$data_string);
	$return_content= json_decode($return_content, true);
	return $return_content;
}

function get_card_info($cart_id) {//woo add
	$token = get_token();
	$url  = "https://api.weixin.qq.com/card/get?access_token=".$token;
	$data_string='{"card_id":"'.$cart_id.'"}';
	list($return_code, $return_content) = http_post_data($url,$data_string);
	$return_content= json_decode($return_content, true);
	return $return_content;
}

function get_card_qrcode($cart_id) {//woo add
	$token = get_token();
	$url  = "https://api.weixin.qq.com/card/qrcode/create?access_token=".$token;
	$data_string='{"action_name":"QR_CARD","action_info":{"card":{"card_id":"'.$cart_id.'"}}}';
	list($return_code, $return_content) = http_post_data($url,$data_string);
	$return_content= json_decode($return_content, true);
	return $return_content;
}

function consume_card_code($code) {//woo add
	$token = get_token();
	$url  = "https://api.weixin.qq.com/card/code/consume?access_token=".$token;
	$data_string='{"code":"'.$code.'"}';
	list($return_code, $return_content) = http_post_data($url,$data_string);
	$return_content= json_decode($return_content, true);
	return $return_content;
}

function modify_card_stock($card_id,$increase_number=0,$reduce_number=0) {//woo add
	$token = get_token();
	$url  = "https://api.weixin.qq.com/card/modifystock?access_token=".$token;
	$data_string='{"card_id":"'.$card_id.'","increase_stock_value":"'.$increase_number.'","reduce_stock_value":"'.$reduce_number.'"}';
	list($return_code, $return_content) = http_post_data($url,$data_string);
	$return_content= json_decode($return_content, true);
	return $return_content;
}

function is_before68($db,$product_id,$userid){ //是否6月8号前浏览过产品
	global $showPriceProduct;
	if(in_array($product_id,$showPriceProduct)){
		return true;
	}
    $records = $db->get_results("select * from visit_records where userid='".$userid."' and product_id='".$product_id."' and addtime<".strtotime('2015-06-09 00:00:00')." order by id desc");
    return count($records)>0;
}

function is_small_price($db,$product_id,$price){
	$smallest_price = $db->get_row("select * from product_price where product_id='".$product_id."' order by price asc limit 1");
	if($price - $smallest_price->price > 0){
		return false;
	}
	return true;
}

function orderquery($out_trade_no){
	global $app_info;
	$nonce_str = create_randomstr(16);
	$url  = "https://api.mch.weixin.qq.com/pay/orderquery";
	$str1 = "appid=".$app_info['appid']."&mch_id=1235944202&out_trade_no=".$out_trade_no."&nonce_str=".$nonce_str;
	$sign = strtoupper(md5($str1."&key=2db7ccd42c6bb1481064224dd8d239aa"));
//	$data_string='{"appid":"'.$app_info['appid'].'","mch_id":"1235944202","out_trade_no":"'.$out_trade_no.'","nonce_str":"'.$nonce_str.'","sign":"'.$sign.'"}';
//	list($return_code, $return_content) = http_post_data($url,$data_string);
//	$return_content= json_decode($return_content, true);
	$url.="?".$str1."&sign=".$sign;
	echo $url;
	$return_content= json_decode(http_get_data($url), true);
	print_r($return_content);
	return $return_content;
}

/**
 * 判断是否微信访问
 *
 * @return boolean
 */
function isWeixin(){
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	return ((strpos($agent, 'micromessenger') === false) && (strpos($agent, 'windows phone') === false)) ? false : true;
}

/**
 * 渲染图片
 *
 * @param string $pic 图片路径
 * @param string $sizetype 尺寸类型，big/middle/small
 * @param integer $type 图片类型，1产品封面,2logo,3产品图片
 * @param array $size 行内指定大小，w宽度，h高度
 * @param array $info 额外相关信息
 * 		cls class样式类名
 * 		style 样式
 * @param boolean $echo 是否直接输入
 * @return null|string
 */
function renderPic($pic, $sizetype='small', $type=1, $size=array(), $info=array(), $echo=true){
	$defaultSize = array('big'=>'default_big.png', 'middle'=>'default_middle.png', 'small'=>'default_small.png');
	$default = __IMG__.'/'.$defaultSize[$sizetype];
	if(empty($pic)){
		$img = '<img src="'.$default.'" />';
	}else{
		//用于兼容前期与后期传递的参数的类型
		$typeMap = array(1=>'product', 2=>'logo', 3=>'productimage');
		$picType = is_int($type) ? $typeMap[$type] : $type;

		$types = array(1=>'product/');
		switch($picType){
			case 'product':
				$pics = '/product/';
				switch($sizetype){
					case 'small':
						$pics .= 'small/';
						break;
					case 'big':
						$pics .= 'large/';
						break;
				}
				$picLink = $pics.$pic;
//				$pic = UPLOAD_DIR.$types[$type].$pic;
//				($sizetype == 'middle') && $pic .= '_thumb.jpg';
				break;
			case 'logo':
				$picLink = '/upfiles/logo/'.$pic;
				break;
			case 'productimage':
				$picLink = '/upfiles/'.$pic;
				break;
		}
		$img = '<img src="'.$picLink.'"';
		isset($size['w']) && $size['w'] && $img .= ' width="'.$size['w'].'"';
		isset($size['h']) && $size['h'] && $img .= ' height="'.$size['h'].'"';
		isset($info['cls']) && $info['cls'] && $img .= ' class="'.$info['cls'].'"';
		isset($info['style']) && $info['style'] && $img .= ' style="'.$info['style'].'"';
		$img .= ' onerror="this.onerror=null;this.src=\''.$default.'\'" />';
	}
	if($echo){
		echo $img;
	}else{
		return $img;
	}
}

/**
 * 打印结构，调试使用
 *
 * @param mix $data 要打印的数据
 * @param boolean $exit 中止
 */
function testPS($data, $exit=true){
	echo '<pre>'.print_r($data,true).'</pre>';
	if($exit) exit();
}

/**
 * 获取session中当前用户信息
 *
 * @param strin $jumpDir 登录后跳转的地址
 * @param boolean $jump 没有用户信息时是否跳转到登录页面
 * @return void|object
 */
function getCurSessionUser($jumpDir='', $jump=true){
	$user = null;
	if(isset($_SESSION['userInfo']) && !empty($_SESSION['userInfo'])){
		$user = $_SESSION['userInfo'];
	}else{
		if($jump){
			$url = 'login.php';
			!empty($jumpDir) && $url .= '?dir='.$jumpDir;
			redirect($url);
			exit();
		}
	}
	return $user;
}

/**
 * 根据是否有设置参数判断是否打印结构，调试使用
 *
 * @param mix $data 要打印的数据
 * @param boolean $exit 中止
 * @param string $paramName 参数名称
 */
function testPSByParam($data, $exit=true, $paramName='debug'){
	isset($_GET[$paramName]) && testPS($data, $exit);
}
?>