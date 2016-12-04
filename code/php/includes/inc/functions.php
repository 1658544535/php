<?php

/*
 * 功能：获取需要调用的Bean对象
 * 此函数包含的动作：
 * 1、加载Bean文件
 * 2、实例化Bean对象
 * */
function get_bean_obj( $path, $bean_name, $arrParam="" )
{
	require_once $path . $bean_name . '.php';
	$obj = new $bean_name();

	if ( ! empty( $arrParam ) )
	{
		foreach( $arrParam as $key=>$val )
		{
			$obj->$key = $val;
		}
	}

	return $obj;
}


/*
 * 获取当前正在操作的功能
 * */
function get_now_func()
{
	$rs_data = preg_split( '#\/#', $_SERVER['REQUEST_URI'] );		// 截取第一段功能段
	preg_match( '#(\w+)(.php)*.*#', $rs_data[1],$data);				// 如果是php则去掉.php和后面的参数，如果是文档则直接返回文档
	return $data[1];
}

/*
 * 远程获取url的数据，用于微信
 * */
function get_url_data_from_wx( $url, $data="" )
{
 $curl = curl_init();

 curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
 curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
 curl_setopt ($curl, CURLOPT_TIMEOUT, 10 );
 curl_setopt($curl, CURLOPT_HEADER, 0);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

 if ( $data != "" )
 {
 	curl_setopt($curl, CURLOPT_POST, 1);
 	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
 }
 curl_setopt($curl, CURLOPT_USERAGENT,'MicroMessenger');
 curl_setopt($curl, CURLOPT_URL, $url );

 $result = curl_exec ($curl);
 curl_close ( $curl );
 return  $result;
}
/*
 * 判断是否为微信浏览器
 * @return boolean
 */
function is_weixin()
{
	//if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && (strpos($agent, 'windows phone') !== false) )
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false )
	{
		return true;
	}
	return false;
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
function uploadfile($uploader = 'file', $path = '../upfiles/')
{
	$return = '';
	$uptypes = array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png','audio/mpeg','audio/mp3');
	$time = date('YmdHis');
	if( !file_exists($path) )
	{
		mkdir($path, 0777);
	}

	if( is_uploaded_file($_FILES[$uploader]['tmp_name']) )
	{
		$file = $_FILES[$uploader];
		if(in_array($file['type'], $uptypes))
		{
			$filename = $file['tmp_name'];
			$pinfo = pathinfo($file['name']);
			$dest = $path . $time . '.' . $pinfo['extension'];
			if(move_uploaded_file($filename, $dest))
			{
				//上传完成
				$pinfo = pathinfo($dest);
				$return = $pinfo['basename'];
			}
		}
		else
		{
			echo 'bb';
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
//function htmlEditor($name = 'htmlEditor1', $value = '', $width = '100%', $height = '100%', $defaultStyle = true) {
//	include("../fckeditor/fckeditor.php");
//	$sBasePath = dirname($_SERVER['PHP_SELF']);
//	$sBasePath = 'fckeditor/' ;
//
//	$oFCKeditor = new FCKeditor($name) ;
//	$oFCKeditor->BasePath = $sBasePath ;
//	$oFCKeditor->ToolbarSet = $defaultStyle ? 'Default' : 'Basic';
//	$oFCKeditor->Value = $value;
//	$oFCKeditor->Width = $width;
//	$oFCKeditor->Height = $height;
//	$oFCKeditor->Create() ;
//}


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
		if(file_exists(SCRIPT_ROOT.'localweixin.txt')){//本地测试微信
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
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


/*
 * 	匿名
 */
function hide_name($name)
{
	if(strlen($name) > 6)
	{
		return substr($name,0,3)."**".substr($name,strlen($name)-3,strlen($name));
	}
	else if(strlen($name)>3 && strlen($name)<=6)
	{
		return substr($name,0,3)."**";
	}
	else
	{
		return $name;
	}
}


/*
 * 	微信帐号与网站帐号绑定
 */
function get_access_token($CODE) 	//feng add
{
	global $app_info;
	$url  = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$app_info['appid']."&secret=".$app_info['secret']."&code=".$CODE."&grant_type=authorization_code";
	$return_content = http_post_data($url,'');
	return  json_decode($return_content[1], true);
}

/*
 *	功能：获取产品数量对应的的商品价格
 *
 *	参数：
 *  $strPrices:    商品梯阶价格(json格式)
 *  $product_num:  购买的商品数量
 *
 *  返回值：
 *  商品数量所对应的商品单价
 * */
 function get_price( $strPrices, $product_num )
 {
 	$arrPrices = json_decode( $strPrices );

 	foreach( $arrPrices as $price )
	{
		if( $price->max == $price->min )
	  	{
	  		$now_price = $price->price;
	  	}
	  	else
	  	{
		  	if ( $price->max == 0 )
		  	{
		  		if( $product_num >= $price->min && $product_num<=10000)
				{
			  	 	$now_price = $price->price;
				}
		  	}
		  	else
		  	{
				if(  $product_num >= $price->min  && $product_num <= $price->max )
				{
				   $now_price = $price->price;
				}
		  	}
	  	}
	}

	return $now_price;
}


/*
 * 	功能：获取邮费信息
 * 	参数：
 * 	$province:  省份的ID
 * 	$weight:	物体的重量
 */
function get_espress_price( $province, $weight )
{
	$espress 		=  0;
	$need_espress 	= array( 6,27,29,30,31,32 );
	if ( in_array( $province, $need_espress ) && $weight > 1 )
	{
		$espress =  15 * ( $weight - 1 );
	}

	return $espress;
	exit;


	// 获取用户选定地区的运费
	global $db;
	$ep 			= $db->get_results("SELECT a.`postage`, a.`postage2`, a.`add_postage`, a.`add_postage2` FROM `sys_area` as a WHERE `id`= $province ");
	$postage 		= $ep[0]->postage; 		// 邮费（3公斤内）
	$postage2 		= $ep[0]->postage2; 	// 邮费（3公斤外）
	$add_postage 	= $ep[0]->add_postage; 	// 续费（3公斤内）
	$add_postage2 	= $ep[0]->add_postage2; // 续费（3公斤外）
	$weight 		= ceil($weight);

	if ( $weight == 0 )
	{
		$espress_price = 0;
	}
	else
	{
		// 当重量在3公斤以内
		if ($weight <= 3)
		{
			$espress_price = $postage; // 获取3公斤内首重的邮费
			if ($weight > 1) {
				$espress_price += $add_postage * ($weight -1); // 超过1公斤部分的续重费
			}
		}
		 else // 如果超过3公斤则加续重费
		{
			$espress_price = $postage2; // 获取3公斤内首重的邮费
			$espress_price += $add_postage2 * ($weight -1); // 超过1公斤部分的续重费
		}
	}
	return $espress_price;
}

/**
 * 打印结构，调试使用(print data缩写)
 *
 * @param mix $data 要打印的数据
 * @param boolean $exit 中止
 * @param boolean $bFormat 是否输出变量格式
 */
function PD($data, $exit=true, $bFormat=FALSE)
{
	if ( $bFormat )
	{
		var_dump($data);
	}
	else
	{
		if ( $data == NULL )
		{
			var_dump($data);
		}
		else
		{
			echo '<pre>'.print_r($data,true).'</pre>';
		}
	}

	if($exit) exit();
}

/**
 * 检测提交变量，并返回相应的值
 *
 * @param string $val_name 变量名
 * @param string $default_val 默认值
 * @param string $submit_type 提交方式 （POST|GET|REQUEST）
 */
function CheckDatas( $val_name, $default_val='', $submit_type= 'REQUEST' )
{
	if ( strtoupper($submit_type) == 'POST' )
	{
		$data = isset( $_POST[$val_name] ) ? $_POST[$val_name] : $default_val;
	}
	else if( strtoupper($submit_type) == 'GET' )
	{
		$data = isset( $_GET[$val_name] ) ? $_GET[$val_name] : $default_val;
	}
	else
	{
		$data = isset( $_REQUEST[$val_name] ) ? $_REQUEST[$val_name] : $default_val;
	}

	return $data;
}

/**
 * 获取数组格式的地区列表
 *
 * @todo 根据需要待完善
 * @return array
 */
function getAreas(){
	global $db;
	$areaDir = SCRIPT_ROOT.'data/';
	$areaFile = $areaDir.'area.php';
	!file_exists($areaDir) && mkdir($areaDir, 0777, true);
	//数据文件不存在，或者数据文件修改超过一天(地区数据每24小时更新一次)
	if(!file_exists($areaFile) || (time() - filemtime($areaFile) > 86400)){
		$sql = 'SELECT `id`,`name`,`pid`,`postcode`,`postage`,`postage2`,`add_postage`,`add_postage2` FROM `sys_area` ORDER BY `pid` ASC,`id` ASC';
		$rs = $db->get_results($sql);
		$areas = array();
		$map = array();
		$tmpMap = array();
		foreach($rs as $v){
			if($v->pid == 0){//一级
				$areas[$v->id] = array('id'=>$v->id, 'name'=>$v->name);
			}elseif(isset($areas[$v->pid])) {//二级
				$areas[$v->pid]['child'][$v->id] = array('id'=>$v->id, 'name'=>$v->name);
				//下级地区已先获得，将其下级放入数据链中
				if(isset($tmpMap[$v->id])){
					$areas[$v->pid]['child'][$v->id]['child'] = $tmpMap[$v->id];
					unset($tmpMap[$v->id]);
				}
			}elseif(isset($map[$v->pid]) && isset($map[$map[$v->pid]['pid']])) {//三级
				$areas[$map[$v->pid]['pid']]['child'][$v->pid]['child'][$v->id] = array('id' => $v->id, 'name' => $v->name);
			}else{//当前地区非一级，且上级排在后面尚未存在于数据中
				$tmpMap[$v->pid][$v->id] = array('id'=>$v->id, 'name'=>$v->name);
			}
			$map[$v->id] = array('pid'=>$v->pid);
		}
		file_put_contents($areaFile, "<?php\r\nreturn ".var_export($areas, true).";\r\n?>");
		unset($map, $tmpMap);
	}else{
		$areas = include($areaFile);
	}
	return $areas;
}

/**
 * 获取json格式的地区列表
 *
 * @return string
 */
function getAreasJson(){
	$areaDir = SCRIPT_ROOT.'data/';
	$areaFile = $areaDir.'area.json';
	!file_exists($areaDir) && mkdir($areaDir, 0777, true);
	if(!file_exists($areaFile)){
		$areas = getAreas();
		$data = array();
		foreach($areas as $one){
			$_one = array('id'=>$one['id'], 'name'=>$one['name']);
			if($one['child']){
				$levTwo = array();
				foreach($one['child'] as $two){
					$_two = array('id'=>$two['id'], 'name'=>$two['name']);
					if($two['child']){
						$levThree = array();
						foreach($two['child'] as $three){
							$levThree[] = array('id'=>$three['id'], 'name'=>$three['name']);
						}
						!empty($levThree) && $_two['child'] = $levThree;
					}
					$levTwo[] = $_two;
				}
				!empty($levTwo) && $_one['child'] = $levTwo;
			}
			$data[] = $_one;
		}
		$areaData = array('data'=>$data);
		$areaData = json_encode($areaData);
		file_put_contents($areaFile, $areaData);
	}else{
		$areaData = file_get_contents($areaFile);
	}
	return $areaData;
}

/*
 * 功能：获取对外订单号
 * */
function set_out_trade_no()
{
	$time = explode(" ", microtime());
	return date('Ymd') . $time[1] . rand(100,999);
}

/*
 * 功能：生成随机码
 * */
function createCode($length = 4, $is_number=true)
{
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

	if ( $is_number )
	{
		$chars .= "0123456789";
	}

	$str = "";
	for ($i = 0; $i < $length; $i++)
	{
		$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $str;
}

/**
 * 生成优惠券劵码(时间戳+5位随机数字)
 *
 * @return string
 */
function genCouponNo()
{
	$str1 = '0123456789';
	return time(). rand( 1000,9999 );
}

/*
 * 功能：获取json数据
 * */
function get_json_data_public( $code, $msg, $data='' )
{
	$rs = array(
		'code' 	=> $code,
		'msg'	=> $msg,
		'data'	=> $data
	);

	return json_encode( $rs );
}

// 打印log
function  log_result( $file, $word, $err_level='DEBUG' )
{
    $fp = fopen( LOG_INC . $file,"a");
    flock($fp, LOCK_EX) ;
	fwrite( $fp,"================================================\n");
    fwrite( $fp,"[". date('Y-m-d H：i:s')."][{$err_level}]　{$word}\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}

/**
 * ajax返回信息
 *
 * @param boolean $state 状态
 * @param string $msg 信息
 * @param array $data 扩展信息
 */
function ajaxResponse($state, $msg, $data=array()){
	$info = array('state'=>$state ? 1 : 0, 'msg'=>$msg);
	!empty($data) && $info = array_merge($info, $data);
	echo json_encode($info);
	exit();
}



/**
 * 	模型类
 *
 * 	@param $dbName  数据表名
 *  @param $conn	数据库链接
 */
function M( $dbName, $db='' )
{
	global $db;
	static $_model  = array();
	require_once APP_INC . '/Model.class.php';

	if ( ! isset($_model[$dbName]) )
	{
		$_model[$dbName] = new Model( $db,$dbName);
	}

	return $_model[$dbName];
}

/**
 * 	模型类
 *
 * 	@param $dbName  模块名
 *  @param $conn	数据库链接
 * 	@param $conn	数据表名
 */
function D( $ModelName, $db='',  $dbName='' )
{
	global $db;
	static $_D  = array();
	require_once MODEL_DIR .'/'. $ModelName . 'Model.class.php';
	$strModel = $ModelName . 'Model';

	if ( ! isset($_D[$ModelName]) )
	{
		$_D[$ModelName] = new $strModel($db);
	}

	return $_D[$ModelName];
}

/**
 *	功能：判断提交方式是否为POST
 */
function IS_POST()
{
	return $_SERVER['REQUEST_METHOD'] == 'POST' ? TRUE : FALSE;
}

/**
 *	功能：判断提交方式是否为GET
 */
function IS_GET()
{
	return $_SERVER['REQUEST_METHOD'] == 'GET' ? TRUE : FALSE;
}


/**
 *	功能：判断是否微信登录（任何页面首次进入都需去调用微信API获取微信相关信息）
 */
 function IS_USER_WX_LOGIN()
 {
 	if( !isset($_SESSION['openid']) ||$_SESSION['openid'] == null )
	{
		redirect("/login.php?dir=" . urlencode($_SERVER['REQUEST_URI']));
		return;
	}
 }

/**
 *	功能：判断是否平台登录（通过判断is_login是否为true来获取是否可操作跟用户相关的信息）
 */
 function IS_USER_LOGIN()
 {
 	if( !isset($_SESSION['is_login']) || $_SESSION['is_login'] === FALSE )
	{
		redirect("/user_binding.php?dir=" . $_SERVER['REQUEST_URI'] );
		return;
	}
 }

 /**
  * 功能：通过时间获取时间离现在剩余的时间，显示格式
  * 参数：
  * @param datetime $date 时间
  * @param strting  $type -:剩余时间 +: 即将开始时间
  * */
 function DataTip( $date, $type='-' )
 {
 	$date_tip = '';

	// 计算剩余的天数
 	$date_num = floor((strtotime($date) - time())/86400);
 	
 	
	// 计算当天剩余的秒数
	$date_time = strtotime($date) - ( time() + $date_num * 86400 );

 	if ( $date_num >= 0 )
	{
		if ( $date_num > 30 )
		{
			$date_tip = floor($date_num / 30) . '个月';
		}
		else
		{
			 if ($date_num == 0)
			 {
			 	$date_tip = $type == '-' ? '即将开奖，请耐心等待' : '距活动开始：';
			 }
			 else
			 {
			 	$date_tip = '剩' . $date_num . '天';
			 }

		}
	}

	return array( 'date_num'=> $date_num, 'date_time'=>$date_time, 'date_tip'=>$date_tip );
 }


 

 
 
 
 
 
 /*=================================================================
 * 	功能：调用发送短信接口，并获取结果
 *
 *  参数：
 *  $phone:手机号
 * 	$source: 1=注册；  2=修改密码
 *
 *  返回结果:
 * object(stdClass)[15]
  	'phone' => string '13414057505' (length=11)
  	'captcha' => string '229640' (length=6)
  	'success' => boolean true
  	'error_msg' => string '发送成功！' (length=15)
 *
 =================================================================*/
function apireturn($phone, $source, $arrGeetestParam )
{
	global $log;

	// 给url参数设置一个sign用于接口验证
	include_once(LIB_ROOT . 'SetKey.php');
	$SetKey = new SetKey();
	$SetKey->getUrlParam( 'phone=' . $phone . '&source=' . $source . '&geetest_challenge=' . $arrGeetestParam['geetest_challenge'] . '&geetest_validate=' . $arrGeetestParam['geetest_validate'] . '&geetest_seccode=' . $arrGeetestParam['geetest_seccode'] );
	$sign 	= $SetKey->getSign();

    $validateCodeFile = SCRIPT_ROOT.'data/validcode/validcode_cookie_'.GetIP().'_'.$_COOKIE['validate_code_flag'].'.txt';

	$url 	= APIURL . '/captcha.do?phone=' . $phone . '&source=' . $source . '&sign=' . $sign . '&geetest_challenge=' . $arrGeetestParam['geetest_challenge'] . '&geetest_validate=' . $arrGeetestParam['geetest_validate'] . '&geetest_seccode=' . $arrGeetestParam['geetest_seccode'];
	$ch 	= curl_init($url) ;
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']) ; 					// 获取数据返回
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; 									// 获取数据返回
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; 									// 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
    curl_setopt($ch, CURLOPT_COOKIEFILE, $validateCodeFile);
	$output = curl_exec($ch) ;
	curl_close($ch);

	$log->put('/user/binding', '调用接口！');												// 记录日志
	$log->put('/user/binding',  $output );												// 记录日志
    @unlink($validateCodeFile);
	return json_decode($output);
}

/**
 * 是否ajax请求
 *
 * @param string $param ajax提交的参数名
 * @return boolean
 */
function isAjax($param='ajax'){
	return ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || !empty($_POST[$param]) || !empty($_GET[$param])) ? true : false;
}

/**
 * 获取上一页面地址
 *
 * @return string
 */
function getPrevUrl(){
	return empty($_SERVER['HTTP_REFERER']) ? '/' : $_SERVER['HTTP_REFERER'];
}

/**
 * 通过接口获取数据
 *
 * @param string $url 接口地址
 * @param array $param 接口参数，参数名=>值
 * @param string $method 接口调用方式，get/post
 * @return array
 */
function apiData($url, $param=array(), $method='get', $exit=false){
	$method = strtolower($method);
	!in_array($method, array('get', 'post')) && $method = 'get';

	// 给url参数设置一个sign用于接口验证
	include_once(LIB_ROOT . 'SetKey.php');
	$objKey = new SetKey();

	$url = API_URL.((substr(API_URL, -1)=='/') ? '' : '/').$url;
	
	if($method == 'get'){
		$arr = array();
		foreach($param as $k => $v){
			$arr[] = $k.'='.$v;
		}
		$objKey->getUrlParam(implode('&', $arr));
		$arr[] = 'sign='.$objKey->getSign();
		$url .= '?'.implode('&', $arr);
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_USERAGENT,'MicroMessenger');
	if($method == 'post'){
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	}
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
	$data = curl_exec($ch);

	curl_close($ch);
	if($exit){
		echo $url;
		($method == 'post') && PD($param, false);
		PD(json_decode($data, true));
	}
	return json_decode($data, true);

}

/**
 * 获取ajax请求的json格式数据
 *
 * @param integer $code 状态标识码，0失败，1成功
 * @param string $msg 提示信息
 * @param array $data 数据
 * @param integer $curPage 当前页数(列表使用)，null时不返回
 * @return string
 */
function ajaxJson($code, $msg='', $data=array(), $curPage=null, $ext=array()){
	$arr = array('msg'=>$msg, 'code'=>$code);
	$arr['data']['data'] = $data;
	$arr['data']['ifLoad'] = empty($data) ? 0 : 1;
	!is_null($curPage) && $arr['data']['pageNow'] = $curPage;
	echo json_encode($arr);
	exit();
}

/**
 * 获取头像完整地址
 *
 * @param string $avatar 头像地址
 * @return string
 */
function getFullAvatar($avater){
	global $site_image;
	!preg_match("/^http/i", $avater) && $avater = $site_image.$avater;
	return $avater;
}

/**
 * 功能：生成png类型的二维码图片
 * @param string $website 要生成二维码的数据，网址类型，例如：http://www.weixin.com/product_detail.php?id=1
 * @param string $path 保存二维码图片路径
 * @param string $picname 二维码png图片名称，例如：test.png
 * */
function get_qrcode($website,$path="../upfiles/phpqrcode/",$picname = '')
{

	include LIB_ROOT."phpqrcode/phpqrcode.php";

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
 * 将数据作urlencode处理
 *
 * @param string|array $data 数据
 * @return string|array
 */
function urlEncodeFormat($data){
	if(is_array($data)){
		foreach($data as $k => $v){
			$data[urlencode($k)] = urlEncodeFormat($v);
		}
	}else{
		$data = urlencode($data);
	}
	return $data;
}

/**
 * 将内容转为json格式
 *
 * @param string|array $data 内容
 * @return string
 */
function encodeJson($data){
	if(version_compare(PHP_VERSION, '5.4', '<')){
		return urldecode(json_encode(urlEncodeFormat($data)));
	}else{
		return json_encode($data, JSON_UNESCAPED_UNICODE);
	}
}

/**
 * 发送微信模板消息
 *
 * @param string $type 类型
 * @param array $param 参数
 * @return array
 */
function sendWXTplMsg($type, $param){
    global $site;
    $url = $site.'wx_msgtpl.php?act='.$type;
    $arr = array();
    !isset($param['openid']) && $param['openid'] = $_SESSION['openid'];
    foreach($param as $k => $v){
        $arr[] = $k.'='.$v;
    }
    $url .= '&'.implode('&', $arr);

    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
	$data = curl_exec($ch);
	curl_close($ch);
    return json_decode($data, true);
}

// =============== admin 用到的函数  ================

//获取微信端当前Menu的配置,默认返回array
function getWechatMenuData($OptionWX, $type = '') {
    $objWechat = new Wechat($OptionWX);
    $result = $objWechat->getMenu();
    foreach ($result as $menus) {
        $result = $menus;
    }
    if ($type) {
        $json = json_encode_custom($result);
        return $json;
    }
    return $result;
}

/*
 * 获取传过来的数组的开始的键值
 */
function getStartArr($array){
    $key = current(array_keys($array));
    $val = current(array_values($array));
    return array('key' => $key, 'val'=>$val);
}

/*
 * 获取传过来的数组的最后的键值
 */
function getLastArr($array){
    $val = end($array);
    $key = key($array);
    return array('key' => $key, 'val'=>$val);
}

/*
 * 创建创建查询条件部分sql语句  待完成
 * $array = array('要搜索的字段名' => '要搜索的字段的值');
 *
 */
function createConditionSql($array){
    if (!is_array($array) || empty($array)) {
        return ' ';
    }

    if (count($array)>1) {

        $start = getStartArr($array);
        $last  = getLastArr($array);
        array_shift($array);
        array_pop($array);

        $sql_condition = ' WHERE ' . $start['key'] . '=' . '"' . $start['val'] . '" AND ' ;
        foreach ($array as $k => $v) {
            $sql_condition = $sql_condition . $k . '=' . '"' .  $v . '" AND ';
        }
        $sql_condition = $sql_condition . $last['key'] . '=' . '"' .  $last['val'] . '"' ;

    } else {

        foreach ($array as $k => $v) {
            $sql_condition = ' WHERE ' . $k . '=' . '"' .  $v . '"';
        }

    }
    return $sql_condition;
}

/*
 * AJAX返回信息
 */
function ajaxReturn($status, $info, $data = array()){
    $haha = array('status'=>$status, 'info'=>$info, 'data'=>$data);
    echo json_encode($haha);
    exit();
}

/**
 * 对变量进行 JSON 编码
 * @param mixed value 待编码的 value ，除了resource 类型之外，可以为任何数据类型，该函数只能接受 UTF-8 编码的数据
 * @return string 返回 value 值的 JSON 形式
 */
function json_encode_custom($value)
{
    if (version_compare(PHP_VERSION,'5.4.0','<'))
    {
        $str = json_encode($value);
        $str = preg_replace_callback(
            "#\\\u([0-9a-f]{4})#i",
            function($matchs)
            {
                return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
            },
            $str
        );
        return $str;
    }
    else
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}

/* 将取出来的二维数组转为一维数组 */
function toOneArray($array)
{
    $arr = array();
    foreach ($array as $val){
        foreach ($val as $k=>$v) {
            if ($k == 'keyword'){
                if (strpos($v, " ")) {
                    $keyword_arr = explode(" ", $v);
                    foreach ($keyword_arr as $value) {
                        $arr[$value] = html_entity_decode($val['content']);
                    }
                } else {
                    $arr[$v] = html_entity_decode($val['content']);
                }
            }
        }
    }
    print_r($arr);
    return $arr;
}

//将取出来的数据进行重新整合
function dataToKeyMap($datas)
{
    $arr = array();
    foreach ($datas as $data) {
        foreach ($data as $k => $v) {
            if ($k == 'event') {
                switch ($v) {
                    case 'subscribe': //关注事件
                        $arr['subscribe'][trim($data['key'])] = array(
                            $data['reply_type']=>html_entity_decode($data['content'])
                        );
                        break;
                    case 'text': //文本事件
                        //判断是否存在空格分割
                        if (strpos(trim($data['key']), " ")) {
                            $key_arr = explode(" ", $data['key']);
                            foreach ($key_arr as $value) {
                                $arr['text'][$value] = array(
                                    $data['reply_type']=>html_entity_decode($data['content'])
                                );
                            }
                        } else {
                            $arr['text'][trim($data['key'])] = array(
                                $data['reply_type']=>html_entity_decode($data['content'])
                            );
                        }
                        break;
                    case 'scan': //扫码事件
                        $arr['scan'][trim($data['key'])] = array(
                            $data['reply_type']=>html_entity_decode($data['content'])
                        );
                        break;
                    case 'click': //点击事件
                        $arr['click'][trim($data['key'])] = array(
                            $data['reply_type']=>html_entity_decode($data['content'])
                        );
                        break;
                }
            }
        }
    }
    return $arr;
}

/* 检查是否有重复键值 */
function checkExistKey($array, $id = ''){
    $db = new CustomReplyDB();

    if (strpos($array['key'], " ")) {
        $keyArr = explode(" ", $array['key']); //保存的字符串数组
        foreach ($keyArr as $item) {
            if ($db->like(array('key'=>$item), $array['event'], $id)) ajaxReturn(0,'存在相同关键字 '. $item . ' ,请查正后重试');
        }
    } else {
        if ($db->like(array('key'=>$array['key']), $array['event'], $id)) ajaxReturn(0,'存在相同关键字 '. $array['key'] . ' ,请查正后重试');
    }

    return false;
}

//处理回复数据 content 字段的json数组
function replyDataHandle($array){
    foreach ($array as $k => $v) {
        $v = json_decode($v, true);
        switch ($k) {
            case 'text': //文本消息回复
                return array('type' => $k , 'content' => $v['msg']);
                break;
            case 'news': //图文回复处理
                return array('type' => $k , 'content' => $v);
                break;
            default:
                return false;
        }
    }
}

/**
 * 过滤emoji表情
 *
 * @param string $str 要过滤的字符串
 * @return string
 */
function filterEmoji($str){
    $str = preg_replace_callback('/./u', function (array $match) {
											$_str = '';
											$_str .= strlen($match[0]) >= 4 ? '' : $match[0];
											return $_str;
										}, $str);

    return $str;
}
?>