    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<span>基本设置</span>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="<?php echo $site_admin; ?>setting.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input type="hidden" name="act" value="edit_save">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>用户ID范围：</th>
                                <td>
                                	<input class="common-text" name="start_id" size="50" value="<?php echo $arrData['start_id'] ?>" type="text" style="width:80px"> -
                                	<input class="common-text" name="end_id" size="50" value="<?php echo $arrData['end_id'] ?>" type="text" style="width:80px">
                                </td>
                            </tr>

                            <tr>
                                <th><i class="require-red">*</i>用户的数量：</th>
                                <td>
                                	<input class="common-text" name="user_num" size="50" value="<?php echo $arrData['user_num'] ?>" type="text">
                                	<span style="font-size:12px;"></span>
                                </td>
                            </tr>

                            <tr>
                                <th><i class="require-red">*</i>商品的数量：</th>
                                <td>
                                	<input class="common-text" name="product_num" size="50" value="<?php echo $arrData['product_num'] ?>" type="text">
                                	<span style="font-size:12px;"></span>
                                	<span style="font-size:12px;"> 销量倒数的N位 </span>
                                </td>
                            </tr>

                            <tr>
                                <th><i class="require-red">*</i>数量范围：</th>
                                <td>
                                	最高购买数量　<input class="common-text" name="count" size="50" value="<?php echo $arrData['count'] ?>" type="text" style="width:60px">　个
                                </td>
                            </tr>

                            <th><i class="require-red">*</i>定时刷单的时间：</th>
                                <td>
                                	<input class="common-text" name="time" size="50" value="<?php echo $arrData['time'] ?>" type="text">
                                	<span style="font-size:12px;"> 单位：分钟 </span>
                                </td>
                            </tr>

                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                                </td>
                            </tr>

                        </tbody>
                	</table>
                </form>
            </div>
        </div>

    </div>
    <!--/main-->
</div>
</body>
</html>