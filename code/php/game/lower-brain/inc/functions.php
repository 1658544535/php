<?php


/*
 * 	微信帐号与网站帐号绑定
 */
function get_access_token($CODE) 	//feng add
{
	global $app_info;
	$url  = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$app_info['appid']."&secret=".$app_info['secret']."&code=".$CODE."&grant_type=authorization_code";
	list($return_code, $return_content) = http_post_data($url,'');
	$return_content= json_decode($return_content, true);
    return $return_content;
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
	if(isset($_SESSION['Team.Hn1'])) {
		$arr = $_SESSION['Team.Hn1'];
		return isset($arr[$key]) ? $arr[$key] : null;

	} else {
		return null;
	}
}
function getSession_userid() {
	//如果没有登录，则根据登录时间，生成一个临时的userid
	if($_SESSION['userinfo'] == null && $_SESSION['tempuserinfo'] == null){
		$_SESSION['tempuserinfo'] = time();
	//	$_SESSION['tempuserinfo'] = 5;
	}
	$user = $_SESSION['userinfo'];
	if($user != null){
		$userid = $user->id;
	}else{
		$userid = "250";//$_SESSION['tempuserinfo'];
	}
	return $userid;
}
function setSession($key = '', $value = '') {
	if(isset($_SESSION['Team.Hn1'])) {
		$arr = $_SESSION['Team.Hn1'];
		$arr[$key] = $value;
		$_SESSION['Team.Hn1'] = $arr;

	} else {
		$_SESSION['Team.Hn1'] = array(
			$key => $value,
		);
	}
}
function uploadfile($uploader = 'file', $path = '../upfiles/') {
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
		  $sql = addslashes($sql);
		}
		$sql = str_replace('%','\%',$sql);
		return $sql;
	}

	function sqlUpdateFilter($sql)
	{
		if (!get_magic_quotes_gpc()) {
		  $sql = addslashes($sql);
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
    	global $app_info;
		$url  = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$app_info['appid']."&secret=".$app_info['secret'];
		list($return_code, $return_content) = http_post_data($url,'');
		$return_content= json_decode($return_content, true);
        return $return_content['access_token'];
    }


/*
	function get_access_token($CODE) 	//feng add
	{
    	global $app_info;
		$url  = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$app_info['appid']."&secret=".$app_info['secret']."&code=".$CODE."&grant_type=authorization_code";
		list($return_code, $return_content) = http_post_data($url,'');
		$return_content= json_decode($return_content, true);
        return $return_content;
    }
*/

    function downloadImage($url, $filepath) {
        //服务器返回的头信息
        $responseHeaders = array();
        //原始图片名
        $originalfilename = '';
        //图片的后缀名
        $ext = '';
        $ch = curl_init($url);
        //设置curl_exec返回的值包含Http头
        curl_setopt($ch, CURLOPT_HEADER, 1);
        //设置curl_exec返回的值包含Http内容
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //设置抓取跳转（http 301，302）后的页面
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        //设置最多的HTTP重定向的数量
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);

        //服务器返回的数据（包括http头信息和内容）
        $html = curl_exec($ch);
        //获取此次抓取的相关信息
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        if ($html !== false) {
            //分离response的header和body，由于服务器可能使用了302跳转，所以此处需要将字符串分离为 2+跳转次数 个子串
            $httpArr = explode("\r\n\r\n", $html, 2 + $httpinfo['redirect_count']);
            //倒数第二段是服务器最后一次response的http头
            $header = $httpArr[count($httpArr) - 2];
            //倒数第一段是服务器最后一次response的内容
            $body = $httpArr[count($httpArr) - 1];
            $header.="\r\n";

            //获取最后一次response的header信息
            preg_match_all('/([a-z0-9-_]+):\s*([^\r\n]+)\r\n/i', $header, $matches);
            if (!empty($matches) && count($matches) == 3 && !empty($matches[1]) && !empty($matches[1])) {
                for ($i = 0; $i < count($matches[1]); $i++) {
                    if (array_key_exists($i, $matches[2])) {
                        $responseHeaders[$matches[1][$i]] = $matches[2][$i];
                    }
                }
            }
            //获取图片后缀名
            if (0 < preg_match('{(?:[^\/\\\\]+)\.(jpg|jpeg|gif|png|bmp)$}i', $url, $matches)) {
                $originalfilename = $matches[0];
                $ext = $matches[1];
            } else {
                if (array_key_exists('Content-Type', $responseHeaders)) {
                    if (0 < preg_match('{image/(\w+)}i', $responseHeaders['Content-Type'], $extmatches)) {
                        $ext = $extmatches[1];
                    }
                }
            }
            //保存文件
            if (!empty($ext)) {
            	//echo  $ext;
                $filepath .= ".$ext";
//echo $filepath;die;
                //如果目录不存在，则先要创建目录
                //CFiles::createDirectory(dirname($filepath));
                $local_file = fopen($filepath, 'w');
                if (false !== $local_file) {
                    if (false !== fwrite($local_file, $body)) {
                        fclose($local_file);
                        $sizeinfo = getimagesize($filepath);
                       return true;
                     //  return array('filepath' => realpath($filepath), 'width' => $sizeinfo[0], 'height' => $sizeinfo[1], 'orginalfilename' => $originalfilename, 'filename' => pathinfo($filepath, PATHINFO_BASENAME));
                    }
                }
            }
        }
        return false;
    }

	function http_post_data($url, $data_string) {
        $ch = curl_init();
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

    function create_meun($data,$token) {


	$url  = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
	list($return_code, $return_content) = http_post_data($url,$data);
	print_R($return_code);
	print_R($return_content);
	$return_content= json_decode($return_content, true);



    if($return_content['errcode']==0){
    	return true;
        }else{
        	 return false;
        }
    }

      function product_qrcode($business_id){
		global $site;
		$website=$site."product_detail.php?id=".$business_id;
		include "../qrcode/phpqrcode/phpqrcode.php";
		if (preg_match('/^http:\/\//', $website) || preg_match('/^https:\/\//', $website)) {
			$data= $website;
		} else {
			$data= '<a href="http://'.$website.'>http://'.$website.'</a>';
		}
				//        $data.="MEBKM:TITLE:".$title.";URL:".$website.";;";
		$errorCorrectionLevel="L";
		$matrixPointSize="20";
		$picname=$business_id.".png";
		QRcode::png($data,"../qrcode/qrcode/pic/product/".$picname,$errorCorrectionLevel,$matrixPointSize);
		$filename="../qrcode/qrcode/pic/product/".$picname;
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


	// Encrypt Function
	function mc_encrypt($encrypt, $mc_key)
	{
	    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
	    $passcrypt = trim(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $mc_key, trim($encrypt), MCRYPT_MODE_ECB, $iv));
	    $encode = base64_encode($passcrypt);
	    return urlencode($encode);
	}

	// Decrypt Function
	function mc_decrypt($decrypt, $mc_key)
	{
	    $decoded = base64_decode($decrypt);
	    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
	    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $mc_key, trim($decoded), MCRYPT_MODE_ECB, $iv));
	    return $decrypted;
	}





?>