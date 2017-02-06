<?php include_once('common_header_tpl.php');?>
<link rel="stylesheet" href="<?php echo __PLUGIN__;?>daterangepicker/daterangepicker.css">

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

        <div class="box-body">
            <form class="form-horizontal" action="<?php echo url('Turntable', $action);?>" method="post" id="editTypeForm">
                <input type="hidden" name="id" value="<?php echo $info['id'];?>" />
                <div class="box-body">
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">名称：</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="data[name]" id="nameForRule" placeholder="名称..." type="text" value="<?php echo $info['name'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">时间：</label>
                        <div class="col-sm-10">
                            <button type="button" class="btn btn-default" id="btn-daterange">
                                <span>
                                    <?php if($info['start_time'] == ''){ ?>
                                        选择时间
                                    <?php }else{ ?>
                                        <?php echo date('Y-m-d H:i:s', $info['start_time']).' 至 '.date('Y-m-d H:i:s', $info['end_time']); ?>
                                    <?php } ?>
                                </span>
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <input type="hidden" id="starttime" name="data[st]" value="<?php echo date('Y-m-d H:i:s', $info['start_time']);?>" />
                            <input type="hidden" id="endtime" name="data[et]" value="<?php echo date('Y-m-d H:i:s', $info['end_time']);?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">活动规则：</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="data[desc]"><?php echo $info['desc'];?></textarea>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="button" class="btn btn-default" onclick="window.location.href='<?php echo url('Turntable');?>'">返回</button>
                    <button type="submit" class="btn btn-info pull-right">保存</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="<?php echo __PLUGIN__;?>daterangepicker/moment.min.js"></script>
<script src="<?php echo __PLUGIN__;?>daterangepicker/moment_zh-cn.js"></script>
<script src="<?php echo __PLUGIN__;?>daterangepicker/daterangepicker.js"></script>
<script language="JavaScript">
    $(function(){
        $('#btn-daterange').daterangepicker(
            {
                locale: {
                    format: 'YYYY-MM-DD HH:mm',
                    applyLabel: '确定',
                    cancelLabel: '取消'
                },
                timePicker: true,
                timePicker24Hour: true,
                startDate: <?php if(empty($info['start_time'])){ ?>moment().subtract(29, 'days')<?php }else{ echo '"'.date('Y-m-d H:i:s', $info['start_time']).'"'; } ?>,
                endDate: <?php if(empty($info['end_time'])){ ?>moment()<?php }else{ echo '"'.date('Y-m-d H:i:s', $info['end_time']).'"'; } ?>
            },
            function (start, end) {
                var _start = start.format('YYYY-MM-DD HH:mm');
                var _end = end.format('YYYY-MM-DD HH:mm');
                $('#btn-daterange span').html(_start + ' 至 ' + _end);
                $("#starttime").val(_start);
                $("#endtime").val(_end);
            }
        );
    });
</script>

<?php include_once('common_footer_tpl.php');?>