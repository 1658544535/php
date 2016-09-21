<?php

/*
 *
 * 功能：将数组进行分页
 * 参数：$arr			数组
 * 		$recordCount	数组元素总数
 * 		$page			当前页数
 * 		$pageSize		显示条数
 * 返回值：
 * 		当页数大于总页数时，返回null,否则返回数组
 *
 */
function arrSort( $arr, $recordCount, $page = 1, $pageSize = 5)
{
	$start 		= ($page - 1) * $pageSize;			//起始元素指针
	$end 		= $start + $pageSize;				//结束元素指针
	$pageCount 	= ceil($recordCount/$pageSize);		//总页数
	$row 		= array();
	if($page > $pageCount)	//当页数大于总页数时，返回null
	{
		return null;
	}

	for($i = $start; $i<$end; $i++)
	{
		if(isset($arr[$i]))
		{
			$row[]= $arr[$i];
		}
	}

	return $row;
}

/*
 * 管理员权限
 * */
function manage_permissions($var,$permissions)
{
   $tmp=explode(',',$permissions);
   return (in_array($var, $tmp)) ? true : false;
}



/*
 *  功能：计算两组经纬度坐标 之间的距离
 *
 *  参数：
 *  lng1 经度1；
 *  lat2 纬度2；
 *  lng2 经度2；
 *  len_type （1:m or 2:km);
 *  decimal： 保留小数位
 *
 *  返回：return m or km
 */
function get_distance($lng1,$lat1, $lng2, $lat2,  $len_type = 2, $decimal = 2)
{
   $radLat1 = $lat1 * 3.1415926 / 180.0;   //PI()圆周率
   $radLat2 = $lat2 * 3.1415926 / 180.0;
   $a = $radLat1 - $radLat2;
   $b = ($lng1 * 3.1415926 / 180.0) - ($lng2 * 3.1415926 / 180.0);
   $s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
   $s = $s * 6378.137;
   $s = round($s * 1000);

   if ($len_type == 2)
   {
   		$s /= 1000;
   }
   return round($s, $decimal);
}

/*
 * 功能：获取产品二维码
 * */
function get_product_qrcode($pid)
{
	global $site;
	$website=$site."product_detail.php?id=".$pid;
	include "../qrcode/phpqrcode/phpqrcode.php";
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
	$picname=$pid.".png";
	QRcode::png($data,"../qrcode/qrcode/pic/product/".$picname,$errorCorrectionLevel,$matrixPointSize);
	$filename="../qrcode/qrcode/pic/product/".$picname;
}

/**
 * set back url
 *
 */
function setBackUrl() {
	$url = $_SERVER['REQUEST_URI'];
	setSession('BackUrl', $url);
}
	function create_folders($dir)
	{
		return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));
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


function upload_multi2($photo) {

	$dade=date("Ymd");
	  $dir="../upfiles/original/".$dade;
		$dir1="../upfiles/large/".$dade;
		$dir2="../upfiles/small/".$dade;

		if(!file_exists($dir)){

			create_folders($dir);
			create_folders($dir1);
			create_folders($dir2);

		}
	$return = '';
	$uptypes = array (
		'image/jpg',
		'image/jpeg',
		'image/png',
		'image/pjpeg',
		'image/gif',
		'image/bmp',
		'image/x-png'
	);
	$time = date('YmdHis');
	$rand = rand(100, 999);


		$path="../upfiles/original/".$dade."/";
	if (is_uploaded_file($photo['tmp_name'])) {
		if (in_array($photo['type'], $uptypes)) {

			$filename = $photo['tmp_name'];

			$pinfo = pathinfo($photo['name']);
			$dest = $path . $time . $rand . '.' . $pinfo['extension'];
			//			echo $dest;
			if (move_uploaded_file($filename, $dest)) {
				if (!file_exists($dest)) {
					return 0;
				} else {
					$pinfo = pathinfo($dest);
					$return = $pinfo['basename'];
					return $return;
				}
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}
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
			$dest = $path . $time . rand(1000,9999) . '.' . $pinfo['extension'];
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


function ResizeImage_app($up_folder, $up_mixfolder, $name, $newwidth) {
	$res = explode(".", $name);
	$num = count($res);
	// 	echo $res[1];
	if ($res[$num -1] == "pjpeg" || $res[$num -1] == "PJPEG" || $res[$num -1] == "jpg" || $res[$num -1] == "JPG" || $res[$num -1] == "jpeg" || $res[$num -1] == "JPEG") {
		$im = imagecreatefromjpeg($up_folder . $name);
	} else
		if ($res[$num -1] == "x-png" || $res[$num -1] == "X-PNG" || $res[$num -1] == "png" || $res[$num -1] == "PNG") {
			$im = imagecreatefrompng($up_folder . $name);
		} else
			if ($res[$num -1] == "gif" || $res[$num -1] == "GIF") {
				$im = imagecreatefromgif($up_folder . $name);
			}

	if ($im) {
		//取得当前图片大小
		$width = imagesx($im);
		$height = imagesy($im);
		//        $newwidth=250;
		$newheight = $height * $newwidth / $width;
		//生成缩略图的大小
		if ($width > $newwidth) {
			if (function_exists("imagecopyresampled")) {
				$newim = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			} else {
				$newim = imagecreate($newwidth, $newheight);
				imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			}
			ImageJpeg($newim, $up_mixfolder . $name);
			ImageDestroy($newim);
		} else {
			ImageJpeg($im, $up_mixfolder . $name);
		}
		@ ImageDestroy($newim);
		@ ImageDestroy($im);
	}
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

	function get_access_token($CODE) {//feng add
    	global $app_info;
		$url  = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$app_info['appid']."&secret=".$app_info['secret']."&code=".$CODE."&grant_type=authorization_code";
		list($return_code, $return_content) = http_post_data($url,'');
		$return_content= json_decode($return_content, true);
        return $return_content;
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

    function create_meun($data,$token)
    {
		$url  = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
		list($return_code, $return_content) = http_post_data($url,$data);
		print_R($return_code);
		print_R($return_content);
		$return_content= json_decode($return_content, true);

	    if($return_content['errcode']==0)
	    {
	    	return true;
	    }
	    else
	    {
	       return false;
	    }
    }


	function get_qrcode_img($card_id,$type)
	{
		include "../qrcode/phpqrcode/phpqrcode.php";

		$errorCorrectionLevel="L";
		$matrixPointSize="8";
      	$picname="{$card_id}.png";

		$path = dirname(dirname(__FILE__))."/qrcode_img/{$type}";

		if(!file_exists($path))
		{
			mkdir($path, 0777);
		}

		QRcode::png(  $card_id, $path . "/{$picname}", $errorCorrectionLevel, $matrixPointSize);
	}

	/*
	 * 功能：api输出格式
	 * */
	function get_api_data( $data, $code, $msg )
	{
		$arr = array(
			'data' => $data,
			'code' => $code,
			'msg'  => $msg
		);

		return json_encode( $arr );
	}


	/*
	 * 功能：用于抽奖获取用户得到的奖品
	 *
	 * 参数：
	 * @param array $proArr 奖品信息  array( '奖品ID' => '获奖概率' );
	 *
	 * 返回值：
	 * @return int 奖品ID
	 * */
	function get_rand( $proArr )
	{
	    $result = '';
	    $nSum = array_sum( $proArr );				// 计算概率的总和

	    //概率数组循环
	    foreach ( $proArr as $key => $proCur )
	    {
	        $randNum = mt_rand( 1, $nSum );
	        if ($randNum <= $proCur)
	        {
	            $result = $key;
	            break;
	        }
	        else
	        {
	            $nSum -= $proCur;
	        }
	    }
	    unset ($proArr);
	    return $result;
	}

	// 打印log
	function  log_result($file,$word)
	{
	    $fp = fopen($file,"a");
	    flock($fp, LOCK_EX) ;
	    fwrite($fp,"执行日期：".date("Y-m-d H：i:s")."\n".$word."\n\n");
	    flock($fp, LOCK_UN);
	    fclose($fp);
	}

?>