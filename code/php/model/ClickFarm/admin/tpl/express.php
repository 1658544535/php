    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list">
            	<i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
            	<span>导入快递单号</span>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <form action="<?php echo $site_admin; ?>express.php" method="post" id="myform" name="myform" enctype="multipart/form-data">
                	<input type="hidden" name="act" value="add_save">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th><i class="require-red">*</i>Excel文件：</th>
                                <td>
                                	<input class="common-text" name="files" size="50"  type="file" />
                                </td>
                            </tr>

                            <tr>
                                <th><i class="require-red">*</i>指定时间：</th>
                                <td>
                                	<input class="common-text" name="date" size="50" type="text" value="2016-03-" >
                                	<span style="font-size:12px;">（格式：2016-02-16）</span>
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