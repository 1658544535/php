<?php

include_once( LIB_ROOT . 'logistic/Logistics.class.php' );

class Express{
	static function LogisticsFactory( $logistics_interface )
	{
		switch ($logistics_interface)
		{
			case 'kuaidi':
				require_once LIB_ROOT . 'logistic/KuaiDiLogistics.php';
				return new kuaidi();
			break;
		}
	}
}
?>