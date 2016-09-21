<?php
	define('HN1', true);
	require_once('../global.php');

	$comPerPage = 20;//正常每页数量
	$page 		= $_REQUEST['page'] = null ? '0' : intval($_REQUEST['page']);
	$perpage 	= isset($_GET['per']) ? intval($_GET['per']) : $comPerPage;
	$repage 	= isset($_GET['rep']) ? intval($_GET['rep']) : 0;
	$act 		= isset($_GET['act']) ? $_GET['act'] : '';
	switch($act)
	{
		case 'dapai':
			require_once LOGIC_ROOT . 'product_activityBean.php';
			$objProActi = new product_activityBean();
			$objProActi->db = $db;
			$productList = $objProActi->search(array('type' => 3), $page, $perpage);
			break;

		default:
			require_once LOGIC_ROOT.'comBean.php';
			require_once LOGIC_ROOT.'productBean.php';

			$type 			 = !isset($_REQUEST['category_id']) ? -1 	: intval($_REQUEST['category_id']);
			$types 			 = !isset($_GET['pid']) 			? -1 	: intval($_GET['pid']);
			$is_new 		 = !isset($_GET['is_new']) 			? 0 	: intval($_GET['is_new']);
			$sell 			 = !isset($_GET['sell']) 			? 0 	: intval($_GET['sell']);
			$is_introduce 	 = !isset($_GET['is_introduce']) 	? 0 	: intval($_GET['is_introduce']);
			$key 			 = !isset($_REQUEST['key']) 		? '' 	: $_REQUEST['key'];

			$ib 			 = new productBean();
			$objProType 	 = new comBean($db, 'product_type');
			$_proTypes 		 =  $types > 0 ?  $objProType->get_list(array('pid'=>$types),array('id')) : -1;
			$proTypes 		 = array($types);

			if ( $key == "" )
			{
				if ( $_proTypes == -1   )
				{
					$proTypes = -1;
				}

				if ( $_proTypes == null )
				{
					$proTypes = $types;
				}

				if ( is_array($_proTypes) )
				{
					foreach($_proTypes as $v){
						$proTypes[] = $v->id;
					}
				}

				$perpage 		= 20;
				$productList = $ib->search_list($db,$page,$perpage,$type,$proTypes,$is_new,$sell,$is_introduce,$key);
			}
			else
			{
				$productList = $ib->get_search_list($db,$page,20,$key);
			}
			break;
	}

	$user 		= $_SESSION['userinfo'];
	$user_type  = $user->type;

	$__page = $page;
	$__index = 1;

?>

<?php
	if ( $productList['DataSet'] != null ){
		foreach($productList['DataSet'] as $product){
?>
		<li>
            <div class="product_block_main">
            	<a class="p_img_warp" href="/product_detail?product_id=<?php echo $product->id;?>">
                    <img src="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" alt="" />
                    <p><?php echo $product->product_name; ?></p>
                </a>

                <div class="p_desc_warp">
                   <span>￥<?php echo number_format($product->distribution_price,1);?></span>
                   <a href="product_detail?product_id=<?php echo $product->id;?>">立即购买</a>
                </div>
            </div>
      	</li>
      	
			<!-- <a href="/product_detail?product_id=<?php echo $product->id;?>" pitem="<?php echo $product->id;?>" onclick="preShow(this)" curpage="<?php echo $__page;?>">
				<dd>
					<div class="p_img_warp">
						<img src="<?php echo $site_image?>/product/small/<?php echo $product->image;?>" alt=""/>
					</div>

					<div class="p_desc_warp">
						<p>
							<?php
								$v=&$product->product_name;  //以$v代表‘长描述’
								mb_internal_encoding('utf8');//以utf8编码的页面为例
								echo (mb_strlen($v)>10) ? mb_substr($v,0,10).'...' : $v;
							?>
						</p>

						<p>￥<?php echo number_format($product->distribution_price,1);?></p>
					</div>
				</dd>
			</a> -->
		<?php
		if($repage){
			if($__index < $comPerPage){
				$__index++;
			}else{
				$__page++;
				$__index = 1;
			}
		}
		?>
<?php }} ?>