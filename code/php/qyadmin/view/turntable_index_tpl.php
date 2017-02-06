<?php include_once('common_header_tpl.php');?>
<link rel="stylesheet" href="<?php echo __PLUGIN__;?>daterangepicker/daterangepicker.css">

<style type="text/css">
    .pagination a{display:inline-block; margin:0 3px; padding:3px 5px; border:1px solid #ddd; background-color:#eee;}
    .pagination a.cur_page_class_name{border-color:#337ab7; background-color:#337ab7; color:#fff;}
</style>

<section class="content-header">
    <h1>
        转盘抽奖
    </h1>
</section>

<section class="content">
    <div class="box">
        <ul class="box-header">
            <h3 class="box-title">转盘抽奖活动列表</h3>
        </ul>

        <form action="<?php echo url();?>" role="form" method="get">
            <input type="hidden" name="c" value="Turntable" />
            <input type="hidden" name="a" value="index" />
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-2">
                        <div class="input-group">
                            <div class="input-group-addon">活动名称</div>
                            <input type="text" name="n" value="<?php echo $param['name'];?>" class="form-control" />
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="input-group">
                            <div class="input-group-addon">活动时间</div>
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
                    <div class="col-xs-2">
                        <div class="input-group">
                            <div class="input-group-addon">活动状态</div>
                            <select class="form-control" name="s">
                                <option value="">不限</option>
                                <option value="1" <?php if($param['status'] == 1) echo 'selected';?>>已开始</option>
                                <option value="2" <?php if($param['status'] == 2) echo 'selected';?>>已结束</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-1">
                        <input type="submit" class="btn btn-primary" value="搜索" />
                    </div>
                </div>
            </div>
        </form>

        <div class="box-body">
            <div class="row">
                <div class="col-xs-6">
                    <button class="btn btn-default" id="btn-verify">审核通过</button>
                    <button class="btn btn-default" id="btn-unverify">审核不通过</button>
                    <button class="btn btn-default" id="btn-offline">下线</button>
                </div>
            </div>
        </div>

        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <form role="form">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                <tr role="row">
                                    <th><div class="form-group"><div class="checkbox"><input type="checkbox" id="select_all" /></div></div></th>
                                    <th>序号</th>
                                    <th>活动名称</th>
                                    <th>活动时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(empty($list)){ ?>
                                    <tr>
                                        <td colspan="6">没有相关信息</td>
                                    </tr>
                                <?php }else{ ?>
                                    <?php $time = time();?>
                                    <?php foreach($list as $v){ ?>
                                        <tr role="row" class="odd">
                                            <td><div class="form-group"><div class="checkbox"><label><input type="checkbox" value="<?php echo $v->id;?>" rel="item_data" /></label></div></div></td>
                                            <td class="sorting_1"><?php echo $v->index;?></td>
                                            <td class="sorting_1"><?php echo $v->name;?></td>
                                            <td class="sorting_1"><?php echo date('Y-m-d H:i:s', $v->start_time);?> 至 <?php echo date('Y-m-d H:i:s', $v->end_time);?></td>
                                            <td class="sorting_1">
                                                <?php
                                                if($v->status == 0){
                                                    echo '下线';
                                                }elseif($v->start_time > $time){
                                                    echo '未开始';
                                                }elseif($v->end_time < $time){
                                                    echo '已结束';
                                                }else{
                                                    echo '进行中';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo url('Turntable', 'editTurntable', array('id'=>$v->id));?>">编辑</a> |
                                                <?php if($v->status == 0){ ?>
                                                    <a href="javascript:;" onclick="javascript:changeStatus(<?php echo $v->id;?>, 1)">上线</a>
                                                <?php }else{ ?>
                                                    <a href="javascript:;" onclick="javascript:changeStatus(<?php echo $v->id;?>, 0)">下线</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </form>
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
<script src="<?php echo __JS__;?>jquery.selectall.js"></script>

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

        $.selectAll({"allId":"select_all", "itemRel":"item_data"});

        $("#btn-verify").on("click", function(){
            var ids = getSelIds();
            if(!ids) return;
            changeVerify(ids, 1);
        });

        $("#btn-unverify").on("click", function(){
            var ids = getSelIds();
            if(!ids) return;
            changeVerify(ids, 0);
        });

        $("#btn-offline").on("click", function(){
            var ids = getSelIds();
            if(!ids) return;
            changeStatus(ids, 0);
        });
    });

    function getSelIds(){
        var ids = [], _this;
        $(":checkbox[rel='item_data']").each(function(){
            _this = $(this);
            if(_this.is(":checked")){
                ids.push(_this.val());
            }
        });
        if(ids.length == 0){
            alert("请选择要操作的数据");
            return false;
        }
        return ids.join(",");
    }

    function changeStatus(id, status){
        if(window.confirm("确定要更改状态吗？")){
            $.post("<?php echo url('Turntable', 'switchTurntableStatus');?>", {"id":id,"status":status}, function(r){
                if(r.state == 1){
                    location.reload();
                }else{
                    alert('操作失败');
                }
            }, "json");
        }
    }

    function changeVerify(id, verify){
        if(window.confirm("确定要更改状态吗？")){
            $.post("<?php echo url('Turntable', 'switchTurntableVerify');?>", {"id":id,"verify":verify}, function(r){
                if(r.state == 1){
                    location.reload();
                }else{
                    alert('操作失败');
                }
            }, "json");
        }
    }
</script>

<?php include_once('common_footer_tpl.php');?>