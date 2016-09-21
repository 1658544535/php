    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<a class="crumb-name" href="<?php echo $site_admin; ?>/activity.php?act=list">活动列表</a><span class="crumb-step">&gt;</span>
            	<span>新增活动</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="<?php echo $site_admin; ?>activity.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input type="hidden" name="act" value="edit_save">
                	<input type="hidden" name="id" value="<?php echo $rs->id; ?>">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>活动标题：</th>
                                <td><input class="common-text" name="title" size="50" value="<?php echo $rs->title; ?>" type="text"></td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>开始时间：</th>
                                <td>
                                	<input class="common-text" name="starttime" size="50" value="<?php echo date('Y-m-d H:i:s', $rs->starttime); ?>" type="text">
                                	<span style="font-size:12px;">（2015-11-11 00:00:00）</span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>结束时间：</th>
                                <td>
                                	<input class="common-text" name="endtime" size="50" value="<?php echo date('Y-m-d H:i:s', $rs->endtime); ?>" type="text">
                                	<span style="font-size:12px;">（2015-11-11 23:59:59）</span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="require-red">*</i>允许参与的次数：</th>
                                <td><input class="common-text" name="playnum" size="50" value="<?php echo $rs->play_num; ?>" type="text"></td>
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