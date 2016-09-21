	<SCRIPT language=JavaScript>
    function selectCheckBox(type){
        var checkBoxs = document.getElementsByName("id[]");
        var state = false;
        switch(type){
            case 0:
                state = false;
                break;
            case 1:
                state = true;
                break;
        }
        for(var i = 0,len = checkBoxs.length; i < len; i++){
            var item = checkBoxs[i];
            item.checked = state;
        }
    }
    function unselectAll(){
        var obj = document.fom.elements;
        for (var i=0;i<obj.length;i++){
            if (obj[i].name == "id[]"){
                if (obj[i].checked==true) obj[i].checked = false;
                else obj[i].checked = true;
            }
        }
    }
   

    function visit(){
        if(confirm("确定开始对比？"))
        {
        	myForm.method='get';
        	myForm.act.value='visit';
//             myForm.rl.value=rl;
			myForm.submit();
            return true;
        }
        return false;

    }
</SCRIPT>
	<link href="css/layer.css" rel="stylesheet" type="text/css" />

    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	信息列表
            </div>
        </div>

        <div class="result-wrap">
	       	<div class="search-wrap">
	            <div class="search-content">
	                <form action="" method="get" >
	                    <table class="search-tab">
	                        <tr>
	                        	<th width="100" >产品ID：</th>
	                        	<td colspan="3">
	                        		<input style="width:180px;"  class="common-text"  name="pid" id="pid"  placeholder="产品ID" value="<?php echo $pid; ?>" type="text">
	                        	</td>

								<td>
								  <input class="btn btn-primary btn2" name="sub" value="查询" type="submit" style="float:right;" />
								</td>
	                        </tr>
	                    </table>
	                </form>
	            </div>
	        </div>

	        <div class="list-page" style="text-align:right; margin:0px 20px;">
			    <a href="<?php echo $site_admin; ?>tmall_action.php?act=add">添加信息</a>
			    <!--   <a href="<?php echo $site_admin; ?>tmall_action.php?act=visit">开始对比</a>-->
			</div>
           <form action="tmall_action.php" method="post" name="myForm" >
            
            <input type="hidden" name="act" value="">           
            <div class="result-content">
                <table class="result-tab" width="100%">
                	<tr>
                		<!--  <th>序号</th>-->
                		<th>商品ID</th>
                		<th>商品链接地址</th>
                		<th>产品价格</th>
                		<th>添加时间</th>
                		<th>操作</th>
                	</tr>

                    <?php if ( is_array($tmallList['DataSet']) ){ ?>
                    	
                    	<?php 
                    	$i = 0;
                    	foreach( $tmallList['DataSet'] as $arr ){ 
                    		$i++;
                    		?>
                       
                        <tr>                       	
                        	<!--  <td width="35px"><label><input name="id[]" type="checkbox" class="STYLE2" value="<?php echo $arr->id ?>" /> <?php echo $arr->id; ?></label></td>-->
                        	<td><?php echo $arr->pid; ?></td>
                            <td><?php echo $arr->url; ?></td>
                            <th>￥<?php echo $arr->price; ?></th>
                            <td><?php echo $arr->addtime; ?></td>
                            <td>	
                            	<a href="tmall_action.php?act=edit&id=<?php echo $arr->id; ?>">编辑</a>
                                <a href="tmall_action.php?act=del&id=<?php echo $arr->id; ?>" onclick="javascript:return window.confirm('确定删除？');">删除</a>
                               <!--   <a href="tmall_action.php?act=visit&id=<?php echo $arr->id; ?>">开始匹对</a>-->
                            </td>
                        </tr>
                    <?php }}else{ ?>
                    	<tr>
                    		<td colspan='10'>您查找的记录为空！</td>
                    	</tr>
                    <?php } ?>
                </table>
            
            </div>
</form>
        <div id="tablenav" style="width:300px;">
            <div>
                <a href="javascript://" onclick="return visit()" >开始对比</a>
            </div>

        </div>

			<?php if ( is_array($tmallList['DataSet']) ){ ?>
	           <div style="float:left; width:800px; margin:20px 0 10px;">
	            	<p>
	            		共 <?php echo $tmallList['RecordCount']; ?> 条纪录，
	            		当前第<?php echo $tmallList['CurrentPage']; ?>/<?php echo $tmallList['PageCount']; ?>页，
	            		每页<?php echo $tmallList['PageSize']; ?>条纪录
	            		<a href="<?php echo $url . '&page=' . $tmallList['First']; ?>">[第一页]</a>
	            		<a href="<?php echo $url . '&page=' . $tmallList['Prev']; ?>">[上一页]</a>
	            		<a href="<?php echo $url . '&page=' . $tmallList['Next']; ?>">[下一页]</a>
	            		<a href="<?php echo $url . '&page=' . $tmallList['Last']; ?>">[最后一页]</a>
	            	</p>
	           </div>
		 <?php } ?>
        </div>
    </div>
    <!--/main-->
</div>

<script src="js/layer.js" type="text/javascript"></script>

<script>
	function showRule(oid)
	{
		$('html,body').css('overflow','hidden');
		$.ajax({
			url:'?act=getQrCode&order_id=' +  oid + '&temp=' +  Math.random(),
			success:function(data){
				layer.open({
				    content: data,
				    btn: ['关闭'],
				    end:function(elem){
						$('html,body').css('overflow','inherit');
				    }
				});
			}
		})

	}
</script>

</body>
</html>
