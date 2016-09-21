<?php
/*
 * 	快递信息获取类
 * */
class Express {

	private $expressname =array(); //封装了快递名称

	function __construct(){
		$this->expressname = $this->expressname();
	}

	/*
	 * 采集网页内容的方法
	 */
	private function getcontent($url){
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
	/*
	 * 获取对应名称和对应传值的方法
	 */
	private function expressname(){
		$result = $this->getcontent("http://www.kuaidi100.com/");
		preg_match_all("/data\-code\=\"(?P<name>\w+)\"\>\<span\>(?P<title>.*)\<\/span>/iU",$result,$data);
		$name = array();
		foreach($data['title'] as $k=>$v){
			$name[$v] =$data['name'][$k];
		}
		return $name;
	}

	/*
	 * 解析object成数组的方法
	 * @param $json 输入的object数组
	 * return $data 数组
	 */
	private function json_array($json){
		if($json){
			foreach ((array)$json as $k=>$v){
				$data[$k] = !is_string($v)?$this->json_array($v):$v;
			}
			return $data;
		}
	}

	/*
	 * 返回$data array      快递数组
	 * @param $name         快递名称
	 * 支持输入的快递名称如下
	 * (申通-EMS-顺丰-圆通-中通-如风达-韵达-天天-汇通-全峰-德邦-宅急送-安信达-包裹平邮-邦送物流
	 * DHL快递-大田物流-德邦物流-EMS国内-EMS国际-E邮宝-凡客配送-国通快递-挂号信-共速达-国际小包
	 * 汇通快递-华宇物流-汇强快递-佳吉快运-佳怡物流-加拿大邮政-快捷速递-龙邦速递-联邦快递-联昊通
	 * 能达速递-如风达-瑞典邮政-全一快递-全峰快递-全日通-申通快递-顺丰快递-速尔快递-TNT快递-天天快递
	 * 天地华宇-UPS快递-新邦物流-新蛋物流-香港邮政-圆通快递-韵达快递-邮政包裹-优速快递-中通快递)
	 * 中铁快运-宅急送-中邮物流
	 * @param $order        快递的单号
	 * $data['ischeck'] ==1   已经签收
	 * $data['data']        快递实时查询的状态 array
	 */
	public  function getorder($name,$order){
		//$keywords = $this->expressname[$name];
		$result = $this->getcontent("http://www.kuaidi100.com/query?type={$name}&postid={$order}");
		$result = json_decode($result);
		$data = $this->json_array($result);
		return $data;
	}

	/*
	 * 功能：获取快递单当前的状态
	 * 参数：$status：状态
	 * 返回：订单状态描述
	 * */
	public function get_ship_info($status)
	{
		$status_info = array(
			0=>'货物处于运输过程中；',
			1=>'货物已由快递公司揽收并且产生了第一条跟踪信息；',
			2=>'货物寄送过程出了问题；',
			3=>'收件人已签收；',
			4=>'货物由于用户拒签、超区等原因退回，而且发件人已经签收；',
			5=>'快递正在进行同城派件；',
			6=>'货物正处于退回发件人的途中；'
		);

		return ( ! isset( $status_info[$status] ) ) ? '无法获取该物流状态' : $status_info[$status];

	}
}
?>