<?php

	/**
	 *	功能：设置密匙
	 */
	class SetKey
	{
		private $PublicKey = 'taozhumapintuan@corp.com';
		private $data;
		private $arrUrlParam;


		/**
		 * 	作用：获取url参数
		 */
		public function getUrlParam( $strParam )
		{
			$this->arrUrlParam = explode( '&', $strParam );
		}

		/**
		 * 	作用：获取重组后data
		 */
		public function getData()
		{
			$this->setData();
			return $this->data;
		}

		/**
		 * 	作用：获取sign值
		 */
		public function getSign()
		{
			$this->setData();								// 获取data的值
			$newUrl = $this->formatBizQueryParaMap();		// 去除sign后重新组成url参数
			$str 	= $newUrl . $this->PublicKey;			// 添加公共key值
			$sign 	= $this->getStrMd5( $str );				// MD5加密
			$sign   = strtoupper($sign);                    // MD5第一次加密转大写
			$sign 	= $this->getStrMd5( $sign );			// 再次 MD5加密
			$sign   = strtoupper($sign);                    // 再次加密转大写
			return $sign;
		}


		/**
		 * 	作用：设置data
		 */
		private function setData()
		{
			foreach( $this->arrUrlParam as $val )
			{
				$arrParam = preg_split('/=/', $val );
				$this->data[$arrParam[0]] = $arrParam[1];
			}

			ksort($this->data);
			$this->checkSign();
		}

		/**
		 * 	作用：检查sign 并且去除
		 */
		private function checkSign()
		{
			$tmpData = $this->data;
			unset($tmpData['sign']);
			$this->data = $tmpData;
		}

		/**
		 * 	作用：格式化参数，签名过程需要使用
		 */
		private function formatBizQueryParaMap()
		{
			$buff = "";
			foreach ( $this->data as $k => $v)
			{
				$buff .= $k . "=" . $v . "&";
			}

			if (strlen($buff) > 0)
			{
				$reqPar = substr($buff, 0, strlen($buff)-1);
			}
			return $reqPar;
		}

		/**
		 * 	作用：参数设置为大写
		 */
		private function getStrToUpper( $str )
		{
			return strtoupper($str);
		}

		/**
		 * 	作用：获取Md5加密后的字符串
		 */
		private function getStrMd5( $str )
		{
			return  strtoupper(MD5($str));
		}

	}
?>
