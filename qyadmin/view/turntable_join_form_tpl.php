<?php include_once('common_header_tpl.php');?>

<section class="content-header">
    <h1>
        转盘抽奖
    </h1>
</section>

<section class="content">
    <div class="box">
        <ul class="box-header">
            <h3 class="box-title">转盘抽奖编辑</h3>
        </ul>

        <?php include_once('turntable_edit_bar_tpl.php');?>

        <div class="box-body">
            <form class="form-horizontal" action="<?php echo url('Turntable', 'editJoin');?>" method="post" id="editTypeForm">
                <input type="hidden" name="id" value="<?php echo $info['id'];?>" />
                <div class="box-body">
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">每天最多参与数：</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="data[per_day_number]" id="perDayNum" type="text" value="<?php echo $info['per_day_number'];?>">
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="button" class="btn btn-default" onclick="window.location.href='<?php echo url('Turntable', 'editTurntable', array('id'=>$info['id']));?>'">返回</button>
                    <button type="submit" class="btn btn-info pull-right">保存</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include_once('common_footer_tpl.php');?>
