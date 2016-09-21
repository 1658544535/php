    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<span>临时设置</span>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="<?php echo $site_admin; ?>setting.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input type="hidden" name="act" value="temp_edit_save">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>订单ID范围：</th>
                                <td>
                                	<input class="common-text" name="start_id" size="50" type="text" style="width:80px"> -
                                	<input class="common-text" name="end_id" size="50" type="text" style="width:80px">
                                </td>
                            </tr>

                            <tr>
                                <th><i class="require-red">*</i>指定时间：</th>
                                <td>
                                	<input class="common-text" name="time" size="50" type="text">
                                	<span style="font-size:12px;"></span>
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