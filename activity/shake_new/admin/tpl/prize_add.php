    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<a class="crumb-name" href="<?php echo $site_admin; ?>/activity.php?act=list">活动列表</a><span class="crumb-step">&gt;</span>
            	<span>新增奖品</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="<?php echo $site_admin; ?>prize.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input type="hidden" name="act" value="add_save">
                	<input type="hidden" name="shake_id" value="<?php echo $_GET['aid'] ?>">
                    <table class="insert-tab" width="100%">
                        <tbody>
                        	<tr>
                                <th><i class="require-red">*</i>奖品类型：</th>
                                <td>
                                	<select name="prize_no" class="common-text">
                                		<option value="0">未中奖（谢谢惠顾）</option>
                                		<option value="1">微信红包</option>
                                		<option value="10">实体礼物</option>
                                	</select>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>奖品名称：</th>
                                <td><input class="common-text" name="name" size="50" value="" type="text"></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>奖品价值：</th>
                                <td>
                                	<input class="common-text" name="price" size="50" value="" type="text">
                                	<span style="font-size:12px;"></span>
                                	单位：元
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>奖品图片：</th>
                                <td>
                                	<input class="common-text" name="image" size="50" value="" type="file">
                                	<span style="color:red">(奖品图片应为正方形)</span>
                                </td>
                            </tr>
                            <th><i class="require-red">*</i>概率：</th>
                                <td>
                                	<input class="common-text" name="probability" size="50" value="" type="text">
                                	<span style="font-size:12px;"> 单位：%， 注：概率越高越容易得到 </span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>奖品数量：</th>
                                <td>
                                	<input class="common-text" name="num" size="50" value="" type="text">
                                </td>
                            </tr>
                            <th><i class="require-red">*</i>奖品简介：</th>
                                <td>
                                	<input class="common-text" name="introduce" size="50" value="" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>是否开启：</th>
                                <td>
                                	<select name="status" class="common-text">
                                		<option value="1">开启</option>
                                		<option value="0">关闭</option>
                                	</select>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                                    <input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody></table>
                </form>
            </div>
        </div>

    </div>
    <!--/main-->
</div>
</body>
</html>