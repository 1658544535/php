<?php
define('HN1', true);
require_once('../global.php');


$market_admin = isset( $_SESSION['marketAdmin'] ) ? $_SESSION['marketAdmin'] : '';
$act 		  = isset( $_REQUEST['act'] ) 	? $_REQUEST['act'] : 'list';

$TmallModel = M('tmall');
$TmallInfoModel = M('tmall_info');
$ProdctModel    = M('product');

$from 		  = isset( $_REQUEST['from'] ) 	? $_REQUEST['from'] : '';


if ( $from != 'auto' )
{
	if( $market_admin != null )								// 如果用户已登录
	{
		$market_type 	 = $market_admin['type'];
		$market_name 	 = $market_admin['name'];
	}
	else													// 否则跳转到登录页面
	{
		redirect("login.php");
		return;
	}
}



switch( $act )
{
	/*********列表显示页面*********/
	case 'list':

		$pid      = !isset($_REQUEST['pid'])       || $_REQUEST['pid']=='' ? '' : $_REQUEST['pid'];
		$addtime  = !isset($_REQUEST['addtime'])   || $_REQUEST['addtime']=='' ? '' : $_REQUEST['addtime'];
		
		$page     = !isset($_REQUEST['page'])      || $_REQUEST['page']=='' ? 1 : $_REQUEST['page'];
		if($pid !=null){
			$arrWhere=array('pid'=>$pid);
		}	
		
		$tmallList = $TmallModel ->gets($arrWhere,array('id'=>'desc'),$page, $perpage = 20); 		
		$url 	   = "?act=list&addtime={$addtime}&pid={$pid}";
		
		require_once('tpl/header.php');
		require_once('tpl/tmall_list.php');		
    break;
    
    
    
    /*********添加页面*********/
    case 'add':
    	require_once('tpl/header.php');
    	require_once('tpl/tmall_add.php');
    break;
   
    /*********添加页面处理*********/
    case 'add_save':
    	$pid 		  = isset( $_REQUEST['pid'] ) 	? $_REQUEST['pid'] : '';
    	$url 		  = isset( $_REQUEST['url'] ) 	? $_REQUEST['url'] : '';
    	$price 		  = isset( $_REQUEST['price'] ) ? $_REQUEST['price'] : '';
    	
    	$rs = $TmallModel ->add($data=array('pid'=>$pid,'url'=>$url,'price'=>$price,'addtime'=>date('Y-m-d H:i:s')));    	
    	redirect('tmall_action.php?act=list','添加成功');
	break;
   	
	
	/*********修改页面*********/
   	case 'edit':
   		$id 		  = isset( $_REQUEST['id'] ) 	? $_REQUEST['id'] : '';
   		$info = $TmallModel ->get(array('id'=>$id));
   		require_once('tpl/header.php');
   		require_once('tpl/tmall_edit.php');
   	break;
   	
   	
   	/*********修改页面处理*********/
    case 'edit_save':
    	$id 		  = isset( $_REQUEST['id'] ) 	? $_REQUEST['id'] : '';
    	$pid 		  = isset( $_REQUEST['pid'] ) 	? $_REQUEST['pid'] : '';
    	$url 		  = isset( $_REQUEST['url'] ) 	? $_REQUEST['url'] : '';
    	$price 		  = isset( $_REQUEST['price'] ) ? $_REQUEST['price'] : '';
    	
    	$re = $TmallModel ->modify($data=array('pid'=>$pid,'url'=>$url,'price'=>$price,'addtime'=>date('Y-m-d H:i:s')),array('id'=>$id));
    	redirect('tmall_action.php?act=list','修改成功');
   	break;
   			
   	/*********删除处理*********/
   	case 'del':
   		$id 		  = isset( $_REQUEST['id'] ) 	? $_REQUEST['id'] : '';  		
   	    $TmallModel ->delete(array('id'=>$id));
   		require_once('tpl/header.php');
   		redirect('tmall_action.php?act=list','删除成功');
   	break;
 
   	
   	/*********访问天猫产品地址,配对价格信息**********/
   	case 'visit':
   		
   		set_time_limit(0);
   	
   		
   		
   		$id = array();
   		$id = $_REQUEST['id'];
   		
   		$visit_count = $TmallModel->getCount(array('visit'=>0));

   		if($visit_count >0){
   		 $tList = $TmallModel ->getAll(array('visit'=>0), array('id'=>'asc'), $output = OBJECT, $limit=2);
   		}else{
   			$TmallModel->modify($data=array('visit'=>0));
   			$tList = $TmallModel ->getAll(array('visit'=>0), array('id'=>'asc'), $output = OBJECT, $limit=2);
   		}
   		
//    		$tList = $TmallModel ->getAll();
   		
   		foreach ($tList as $turl)
   		{
   		$referer = $turl->url;
   		
   		$Snoopy = new Snoopy;

   		$content = $Snoopy->fetch($referer)->results;
   		$content = iconv("gb2312","utf-8",$content);
   		
   		$content=str_replace(array("\r\n","\n","\r","\t",chr(9),chr(13)),'',$content);

   		preg_match_all( '#.*"initApi":"(.*)\","initCspuExtraApi".*#',$content, $rs );
   		
   		
   		$url = 'http:' . $rs[1][0] . '&callback=setMdskip';
   		
   		if($rs[1][0] ==''){
   		
   			Log::DEBUG( "id:{$turl->id} -- url:{$url} -- msg:采集失败！ ");
   		}
   		
   		$Snoopy2 = new Snoopy;
   		$Snoopy2->referer   = $referer;
   		
   		$content = $Snoopy2->fetch($url)->results;
   		
   		$content = iconv("gb2312","utf-8",$content);
   	
   		$content=str_replace(array("\r\n","\n","\r","\t",chr(9),chr(13)),'',$content);
  
   		preg_match_all( '#setMdskip\((.*)\)#uis', $content, $rs );
       
        
        if($rs == ''){       	
        	
        	redirect('tmall_action.php?act=list','对比结束');
        
        }
        else
        {
	   		$arr = json_decode($rs[1][0],true);
	   
	   		$Price = NULL;
	   		
	   		foreach($arr['defaultModel']['itemPriceResultDO']['priceInfo'] as $arrPriceInfo)
	   		{
	   			$Price['price'][] = $arrPriceInfo['price'];		// 原价
				
	   			if ( !isset($arrPriceInfo['promotionList'] ))
	   			{
	   				$Price['discount_price'][] = $arrPriceInfo['price'];						// 价格区间
	   			}
	   			else 
	   			{
	   				$Price['discount_price'][] = $arrPriceInfo['promotionList'][0]['price'];	// 价格区间
	   			}
	   			
	   		
	   		}
	   		
	   
// 	    	$price =array_unique($Price['price']) ;
// 	    	sort($price);
	   		
	//   		$price_count = count($price);
	//    		if ( $price_count > 1 )
	//    		{
	//    			echo '原价区间:' . $price[0] . '-' . $price[$price_count-1];
	//    		}
	//    		else
	//    		{
	//    			echo '原价:' . $price[0];
	//    		}
	   		
	//    		echo '<hr>';
	   		
	 		$discount_price =array_unique($Price['discount_price']) ;
	 		
	 		sort($discount_price);
	 		$discount_price_count = count($discount_price);
	 	
	   		if ( $discount_price_count > 1 )
	   		{  			
	//    			echo  '价格区间:' . $discount_price[0] . '-' . $discount_price[$discount_price_count-1];   			
	  				if($turl->price !=  $discount_price[0] . '-' . $discount_price[$discount_price_count-1] ){
	  					$tadd = $TmallInfoModel->add($data=array('pid'=>$turl->pid,'b_price'=>$turl->price,'t_price'=>$discount_price[0] . '-' . $discount_price[$discount_price_count-1],addtime=>date('Y-m-d H:i:s'),'status'=>1));  			         
	  			         $ProdctModel ->modify($data=array('status'=>0),array('id'=>$turl->pid));
	  			         $msg = $tadd === FALSE ? '添加失败！' : '价格差异，产品已更改为下架状态！';
	  			         Log::DEBUG( "id:{$turl->id} -- prodct_id:{$turl->pid} -- msg:{$msg} ");
	  			         
	  				}
	  				else
	  				{
	   			         $TmallInfoModel->add($data=array('pid'=>$turl->pid,'b_price'=>$turl->price,'t_price'=>$discount_price[0] . '-' . $discount_price[$discount_price_count-1],addtime=>date('Y-m-d H:i:s')));    		 			
	  				
	  				}
	   		}
	   		else
	   		{
	//    	        echo  '价格:' . $discount_price[0];
	   			if($turl->price !=$discount_price[0]){
	   			   $badd = $TmallInfoModel->add($data=array('pid'=>$turl->pid,'b_price'=>$turl->price,'t_price'=>$discount_price[0],addtime=>date('Y-m-d H:i:s'),'status'=>1));
	   			   $ProdctModel ->modify($data=array('status'=>0),array('id'=>$turl->pid));
	   			    $msg = $badd === FALSE ? '添加失败！' : '价格差异，产品已更改为下架状态！';
	   			    Log::DEBUG( "id:{$turl->id} -- prodct_id:{$turl->pid} -- msg:{$msg} ");
	   			}
	   			else
	   			{
	   				$TmallInfoModel->add($data=array('pid'=>$turl->pid,'b_price'=>$turl->price,'t_price'=>$discount_price[0],addtime=>date('Y-m-d H:i:s')));
	   			}
	    	}
	    	$TmallModel->modify($data=array('visit'=>1),array('id'=>$turl->id));
        }             
}

echo 'END';	
break;
   	default:

}

?>