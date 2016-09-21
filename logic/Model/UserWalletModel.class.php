<?php
/**
 * 专场收藏模型
 */
class UserWalletModel extends Model
{
	private $arrParam;
	private $isOrderOperation;

	public function __construct($db, $table='')
	{
        $table = 'user_wallet';
        parent::__construct($db, $table);
    }

    /**
     *	功能：设置参数
     *	注意：
     *		必填参数
     *		user_id:	用户ID
     *		type：		0正1负
     *		trade_amt：	交易金额
     *		remarks：	备注
     *		source:		来源
     *		isOrderOperation： 是否为订单操作
     *		（如果 isOrderOperation == TRUE  order_id：订单ID out_trade_no：对外订单号 ）
     *
     */
    public function WalletBuilder($arrParam)
    {
    	$this->arrParam = $arrParam;

    	if ( ! isset( $this->arrParam['isOrderOperation'] ) )
    	{
    		$this->arrParam['isOrderOperation'] = FALSE;
    	}
    }

	/**
	 *	功能：钱包金额操作
	 */
	public function changeUserWallet()
	{
		// 获取当前用户的钱包信息
		$objUserWalletInfo = $this->get( array( 'user_id'=>$this->arrParam['user_id'] ), array('balance','total_balance') );

		// 如果为添加金额
		if ( $this->arrParam['type'] == 0 )
		{
			$arrParam['total_balance'] 	= $objUserWalletInfo->total_balance + $this->arrParam['trade_amt'];
			$arrParam['balance'] 		= $objUserWalletInfo->balance + $this->arrParam['trade_amt'];
		}
		else
		{
			$arrParam['balance'] 		= $objUserWalletInfo->balance - ($this->arrParam['trade_amt']);
		}

		// 更新钱包的金额数值
		$rs = $this->modify( $arrParam, array( 'user_id'=>$this->arrParam['user_id'] ) );

		if ( $rs < 1  )
		{
			return FALSE;
		}

		$this->arrParam['cur_bal'] 		= $objUserWalletInfo->balance;

		// 添加钱包记录
		$rs = $this->addLog();

		if ( $rs < 1  )
		{
			return FALSE;
		}

		return TRUE;
	}


	/**
	 *	获取邀请列表信息
	 */
	public function getUserInviterList()
	{
		global $user;
		$strSQL = "
					SELECT
						uwl.*,
						sl.`loginname`
					FROM
						`user_wallet_log` as uwl
					LEFT JOIN
						`sys_login`	as sl
					ON
						uwl.`source`=sl.`id`
					WHERE
						uwl.`user_id`={$user->id}
					AND
						uwl.`type`=0
				";
		$rs = $this->query( $strSQL );
		if ( $rs == NULL )
		{
			return NULL;
		}

		$allPrice = 0;
		foreach( $rs as $arrInfo )
		{
			$allPrice += $arrInfo->trade_amt;
			$arr['info'][] 		= $arrInfo;
			$arr['allPrice']   	= sprintf('%.1f',$allPrice);
		}

		return $arr;
	}


	/**
	 *	功能:添加日志
	 */
	private function addLog( )
	{
		$arrParam = array(
			'user_id'		=> $this->arrParam['user_id'],
			'cur_bal'		=> $this->arrParam['cur_bal'],
			'type'			=> $this->arrParam['type'],
			'trade_amt'		=> $this->arrParam['trade_amt'],
			'source'		=> $this->arrParam['source'],
			'create_by'		=> $this->arrParam['user_id'],
			'create_date'	=> date('Y-m-d H:i:s'),
			'remarks'		=> $this->arrParam['remarks'],
		);

		if ( $this->arrParam['isOrderOperation'] )
		{
			$arrParam['order_id'] 		= $this->arrParam['order_id'];
			$arrParam['out_trade_no']	= $this->arrParam['out_trade_no'];
		}

		return $this->add( $arrParam,'user_wallet_log' );
	}

}
?>