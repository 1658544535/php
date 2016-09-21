    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<a class="crumb-name" href="/market/promotion_person.php">推广员列表</a><span class="crumb-step">&gt;</span>
            	<span>新增分销商</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="/market/promotion_link.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input type="hidden" name="id" value="<?php echo $promotion_id; ?>">
                	<input type="hidden" name="act" value="add_post">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>手机号：</th>
                                <td><input class="common-text" name="mobile" size="50" value="" type="text"></td>
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