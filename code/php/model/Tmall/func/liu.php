<?php
set_time_limit(0);
date_default_timezone_set("Asia/shanghai");
//自定义抓取图片地址
$url = 'http://detail.tmall.com/item.htm?spm=a220m.1000858.1000725.19.VhK2kI&id=27450304248&areaId=&user_id=230988517&is_b=1&cat_id=2&q=iphone+5&rn=ad04038a8821d017f0a878c5cf9f448a';

$ip_arr = get_ips();
$ip = trim(get_rand_ip($ip_arr)); //随机ip
$content = get_content_by_url($url, $ip);


var_dump($content);
exit;

//获取标题
preg_match("/<h3 data-spm=\"1000983\">[\s]*(.*)[\s]*<\/h3>/i", $content, $match_title);
if(isset($match_title[1]) && $match_title[1]){
	$title = $match_title[1];
	echo mb_convert_encoding('标题为：', 'GBK', 'UTF-8') . $title . '<br />';
}else{
	preg_match("/<h3 data-spm=\"1000983\">[\s]*<a target=\"_blank\" href=\"(.*?)\">(.*)<\/a>/i", $content, $match_title);
	if(isset($match_title[2]) && $match_title[2]){
		$title = $match_title[2];
		echo mb_convert_encoding('标题为：', 'GBK', 'UTF-8') . $title . '<br />';
	}else{
		echo mb_convert_encoding('没有获取到标题，程序终止：', 'GBK', 'UTF-8');
		exit;
	}
	 
}
//获取价格
if($price = get_price($url)){
	echo mb_convert_encoding('价格为：', 'GBK', 'UTF-8') . $price . '<br />';
}else{
	echo mb_convert_encoding('没有获取到价格，程序终止：', 'GBK', 'UTF-8') . '<br />';
}
//获取图片
preg_match("/<img id=\"J_ImgBooth\" src=\"(.*?)\"/i", $content, $match_img);
if(isset($match_img[1]) && $match_img[1]){
	$img_url = $match_img[1];
	echo mb_convert_encoding('图片地址为：', 'GBK', 'UTF-8') . $img_url . '<br />';
	echo "<img src='$img_url' width=300, height=300>";
}else{
	echo mb_convert_encoding('没有获取图片地址，程序终止：', 'GBK', 'UTF-8');
	exit;
}



function get_rand_ip($ip_arr){
	if(empty($ip_arr)){
		return false;
	}
	$ip_count = count($ip_arr);
	$rand_num = rand(0, $ip_count-1);
	return trim($ip_arr[$rand_num]);
}

function get_ips(){
	$fp = fopen('ip.txt', 'r+');
	$ip_arr = array();
	while($line=fgets($fp)){
		array_push($ip_arr, $line);
	}
	fclose($fp);
	return $ip_arr;
}

function get_content_by_url($url, $ip = '127.0.0.1'){
	if(empty($url)){
		return;
	}
	 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_REFERER, $url);
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (compatible; MSIE 6.0; Windows NT 5.0)');
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	if(!empty($ip)){
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip));  //构造IP
	}
	 
	$content = curl_exec($ch);
	return $content;
}

function get_price($url){
	if(empty($url)){
		return;
	}
	 
	preg_match("/id=(\d+)/i", $url, $id_arr);
	if(!empty($id_arr)){
		$id = $id_arr[1];
	}else{
		return;
	}
	$item_url='http://mdskip.taobao.com/core/initItemDetail.htm?itemId=' . $id;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $item_url);
	//设置来源链接，这里是商品详情页链接
	curl_setopt($ch,CURLOPT_REFERER, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/0 (Windows; U; Windows NT 0; zh-CN; rv:3)");
	curl_setopt($ch,CURLOPT_HEADER,0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_POST,1);
	$result = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
	//去除回车、空格等
	$result=str_replace(array("\r\n","\n","\r","\t",chr(9),chr(13)),'',$result);
	//将json数据中，以纯数字为key的字段加上双引号，例如28523678201:{"areaSold":1}转为："28523678201":{"areaSold":1}，否则json_decode会出现错误
	$mode="#([0-9]+)\:#m";
	preg_match_all($mode,$result,$s);
	$s=$s[1];
	if(count($s)>0){
		foreach($s as $v){
			$result=str_replace($v.':','"'.$v.'":',$result);
		}
	}
	//将字符编码转为utf-8，并且将中文转译，否则json_decode会出现错误
	$result=iconv('gb2312','utf-8',$result);
	$str=array();
	$mode='/([\x80-\xff]*)/i';
	if(preg_match_all($mode,$result,$s)){
		foreach($s[0] as $v){
			if(!empty($v)){
				$str[base64_encode($v)]=$v;
				$result=str_replace('"'.$v.'"','"'.base64_encode($v).'"',$result);
			}
		}
	}
	$result=json_decode($result,true);
	//这里得到的数据中，中文数据被转译，下面将中文数据解析
	$result=arr_foreach($result,$str);
	foreach($result['defaultModel']['itemPriceResultDO']['priceInfo'] as $result_price){
		if(isset($result_price['promotionList'])){
			$price = $result_price['promotionList'][0]['price'];
		}else{
			$price = $result_price['price'];
		}
		break;
	}
	return $price;
}

function arr_foreach ($arr,$str)
{
	if (!is_array ($arr))
	{
		return false;
	}
	 
	foreach ($arr as $key => $val )
	{
		if (is_array ($val))
		{
			$arr[$key]=arr_foreach($val,$str);
		}
		else
		{
			if(!empty($val)){
				if($str[$val]){
					$arr[$key]=$str[$val];
				}
			}
		}
	}
	return $arr;
}
?>