    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<a href="tmall_action.php?act=list">信息列表</a><span class="crumb-step">&gt;</span>
            	<span>修改信息</span>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="<?php echo $site_admin; ?>tmall_action.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input type="hidden" name="act" value="edit_save">
                	<input type="hidden" name="id" value="<?php echo $info->id ;?>">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>产品ID：</th>
                                <td>
                                	<input class="common-text" name="pid" size="50" value="<?php echo $info->pid ;?>" type="text" style="width:80px">
                                </td>
                            </tr>

                            <tr>
                                <th><i class="require-red">*</i>URL：</th>
                                <td>
                                	<input class="common-text" name="url" size="50" value="<?php echo $info->url ;?>" type="text">
                                	<span style="font-size:12px;"></span>
                                </td>
                            </tr>

                            <tr>
                                <th><i class="require-red">*</i>产品价格：</th>
                                <td>
                                	￥<input class="common-text" name="price" size="50" value="<?php echo $info->price ;?>" type="text" style="width:80px">
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