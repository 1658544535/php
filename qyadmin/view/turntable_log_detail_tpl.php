<?php include_once('common_header_tpl.php');?>

<section class="content-header">
    <h1>
        转盘抽奖
    </h1>
</section>

<section class="content">
    <div class="box">
        <ul class="box-header">
            <h3 class="box-title">参与记录详情</h3>
        </ul>

        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-responsive">
                        <tr>
                            <th style="width:10%;">用户</th>
                            <td><?php echo $info['loginname'];?></td>
                        </tr>
                        <tr>
                            <th>参与时间</th>
                            <td><?php echo date('Y-m-d H:i:s', $info['time']);?></td>
                        </tr>
                        <tr>
                            <th>抽奖结果</th>
                            <td><?php echo $info['item_name'];?></td>
                        </tr>
                        <tr>
                            <th>领取状态</th>
                            <td>
                                <?php echo $statusMap[$info['status']];?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <button type="button" class="btn btn-default" onclick="window.history.back()">返回</button>
            <!--<button type="submit" class="btn btn-info pull-right">保存</button>-->
        </div>
    </div>
</section>

<?php include_once('common_footer_tpl.php');?>
