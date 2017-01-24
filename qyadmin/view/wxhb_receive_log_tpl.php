<?php include_once('common_header_tpl.php');?>
<link rel="stylesheet" href="<?php echo __PLUGIN__;?>daterangepicker/daterangepicker.css">

<style type="text/css">
    .pagination a{display:inline-block; margin:0 3px; padding:3px 5px; border:1px solid #ddd; background-color:#eee;}
    .pagination a.cur_page_class_name{border-color:#337ab7; background-color:#337ab7; color:#fff;}
</style>

<section class="content-header">
    <h1>
        微信口令红包领取记录
    </h1>
</section>

<section class="content">
    <div class="box">
        <ul class="box-header">
            <h3 class="box-title">红包领取记录</h3>
        </ul>

        <form action="<?php echo url();?>" role="form" method="get">
            <input type="hidden" name="c" value="WxHongbao" />
            <input type="hidden" name="a" value="receiveLog" />
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="input-group">
                            <div class="input-group-addon">时间</div>
                            <button type="button" class="btn btn-default" id="btn-daterange">
                                <span>
                                    <?php if($param['starttime'] == ''){ ?>
                                        选择时间
                                    <?php }else{ ?>
                                        <?php echo $param['starttime'].' 至 '.$param['endtime']; ?>
                                    <?php } ?>
                                </span>
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <input type="hidden" id="starttime" name="st" value="<?php echo $param['starttime']?>" />
                            <input type="hidden" id="endtime" name="et" value="<?php echo $param['endtime'];?>" />
                        </div>
                    </div>
                    <div class="col-xs-1">
                        <input type="submit" class="btn btn-primary" value="搜索" />
                    </div>
                </div>
            </div>
        </form>

        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <?php if(empty($list)){ ?>
                            <h3 class="text-center">没有相关信息</h3>
                        <?php }else{ ?>
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                <tr role="row">
                                    <th>OPENID</th>
                                    <th>帐号</th>
                                    <th>时间</th>
									<th>口令</th>
									<th>金额</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php foreach($list as $v){ ?>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><?php echo $v->openid;?></td>
                                        <td class="sorting_1"><?php echo $v->loginname;?></td>
                                        <td class="sorting_1"><?php echo date('Y-m-d H:i:s', $v->time);?></td>
										<td class="sorting_1"><?php echo $v->password;?></td>
										<td class="sorting_1"><?php echo $v->money;?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php if(!empty($strPage)){ ?>
                <ul class="pagination">
                    <?php echo $strPage;?>
                </ul>
            <?php } ?>

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
                startDate: <?php if($param['starttime'] == ''){ ?>moment().subtract(29, 'days')<?php }else{ echo '"'.$param['starttime'].'"'; } ?>,
                endDate: <?php if($param['endtime'] == ''){ ?>moment()<?php }else{ echo '"'.$param['endtime'].'"'; } ?>
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
