<?php
//定义抽象类
abstract class Logistics{
	abstract function getExpress($express_type,$express_number);
	/*
	 * 采集网页内容的方法
	 */
	public function getcontent($url){
		if(function_exists("file_get_contents")){
			$file_contents = file_get_contents($url);
		}else{
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);
		}
		return $file_contents;
	}
	
	/**
	 * 对象数组转为普通数组
	 *
	 * AJAX提交到后台的JSON字串经decode解码后为一个对象数组，
	 * 为此必须转为普通数组后才能进行后续处理，
	 * 此函数支持多维数组处理。
	 *
	 * @param array
	 * @return array
	 */
	public function objarray_to_array($obj) {
		$ret = array();
		foreach ($obj as $key => $value) {
			if (gettype($value) == "array" || gettype($value) == "object"){
				$ret[$key] =  $this->objarray_to_array($value);
			}else{
				$ret[$key] = $value;
			}
		}
		return $ret;
	}	
}
?>