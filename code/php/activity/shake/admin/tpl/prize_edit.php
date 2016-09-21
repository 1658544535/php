    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<a class="crumb-name" href="<?php echo $site_admin; ?>/activity.php?act=list">活动列表</a><span class="crumb-step">&gt;</span>
            	<span>更新奖品</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="<?php echo $site_admin; ?>prize.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input type="hidden" name="act" value="edit_save">
                	<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                	<input type="hidden" name="aid" value="<?php echo $rs->shake_id ?>">
                    <table class="insert-tab" width="100%">
                        <tbody>
                        	<tr>
                                <th><i class="require-red">*</i>奖项：</th>
                                <td>
                                	<input class="common-text" name="prize_no" size="50" value="<?php echo $rs->prize_no; ?>" type="text">
                                	<span style="color:red">(0：表示未中奖)</span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>奖品名称：</th>
                                <td><input class="common-text" name="name" size="50" value="<?php echo $rs->name; ?>" type="text"></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>奖品价值：</th>
                                <td>
                                	<input class="common-text" name="price" size="50" value="<?php echo $rs->price; ?>" type="text">
                                	<span style="font-size:12px;"></span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>原奖品图片：</th>
                                <td>
                                	<img src="<?php echo $site;?>/upfiles/<?php echo $rs->image; ?>" width='120'  />
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>新奖品图片：</th>
                                <td>
                                	<input class="common-text" name="image" size="50" type="file">
                                	<span style="font-size:12px; color:red"> 注：如不更新则为空(奖品图片应为正方形) </span>
                                </td>
                            </tr>
                            <th><i class="require-red">*</i>概率：</th>
                                <td>
                                	<input class="common-text" name="probability" size="50" value="<?php echo $rs->probability; ?>" type="text">
                                	<span style="font-size:12px;"> 单位：%， 注：概率越高越容易得到 </span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>奖品数量：</th>
                                <td>
                                	<input class="common-text" name="num" size="50" value="<?php echo $rs->num; ?>" type="text">
                                </td>
                            </tr>
                            <th><i class="require-red">*</i>奖品简介：</th>
                                <td>
                                	<input class="common-text" name="introduce" size="50" value="<?php echo $rs->introduce; ?>" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>是否开启：</th>
                                <td>
                                	<input class="common-text" name="status" size="50" value="<?php echo $rs->status; ?>" type="text">
                                	<span style="font-size:12px;">　0：关闭 / 1：开启</span>
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