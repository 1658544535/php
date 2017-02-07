<?php include_once('common_header_tpl.php');?>

<section class="content-header">
    <h1>
        转盘抽奖
    </h1>
</section>

<section class="content">
    <div class="box">
        <ul class="box-header">
            <h3 class="box-title">奖品设置</h3>
        </ul>

        <div class="box-body">
            <div class="row">
                <div class="col-xs-6">
                    <button class="btn btn-default" id="btn-verify">审核通过</button>
                    <button class="btn btn-default" id="btn-unverify">审核不通过</button>
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
                                        <th>奖品名称</th>
                                        <th>奖品图片</th>
                                        <th>奖品说明</th>
                                        <th>奖品数量</th>
                                        <th>已抽取数量</th>
                                        <th>中奖概率</th>
                                        <th>每天最多派发数</th>
                                        <th>上/下架</th>
                                        <th>审核状态</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($list)){ ?>
                                        <tr>
                                            <td colspan="11">没有相关信息</td>
                                        </tr>
                                    <?php }else{ ?>
                                        <?php $time = time();?>
                                        <?php $statusMap = array(0=>'下架',1=>'上架');?>
                                        <?php $verifyMap = array(0=>'未审核',1=>'审核通过',2=>'审核不通过');?>
                                        <?php foreach($list as $v){ ?>
                                            <tr role="row" class="odd">
                                                <td><div class="form-group"><div class="checkbox"><label><input type="checkbox" value="<?php echo $v['id'];?>" rel="item_data" /></label></div></div></td>
                                                <td class="sorting_1"><?php echo $v['index'];?></td>
                                                <td class="sorting_1"><?php echo $v['name'];?></td>
                                                <td class="sorting_1"></td>
                                                <td class="sorting_1"><?php echo $v['desc'];?></td>
                                                <td class="sorting_1"><?php echo $v['num'];?></td>
                                                <td class="sorting_1"><?php echo $v['join_num'];?></td>
                                                <td class="sorting_1"><?php echo $v['ratio'];?>%</td>
                                                <td class="sorting_1"><?php echo $v['per_day_num'];?></td>
                                                <td class="sorting_1"><?php echo $statusMap[$v['status']];?></td>
                                                <td class="sorting_1"><?php echo $verifyMap[$v['verify']];?></td>
                                                <td>
                                                    <a href="<?php echo url('Turntable', 'editItem', array('id'=>$v['id']));?>">编辑</a> |
                                                    <?php if($v['status'] == 0){ ?>
                                                        <a href="javascript:;" onclick="javascript:changeStatus(<?php echo $v['id'];?>, 1)">上架</a>
                                                    <?php }else{ ?>
                                                        <a href="javascript:;" onclick="javascript:changeStatus(<?php echo $v['id'];?>, 0)">下架</a>
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
        </div>
    </div>
</section>

<script src="<?php echo __JS__;?>jquery.selectall.js"></script>
<script language="JavaScript">
    $(function(){
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
            $.post("<?php echo url('Turntable', 'switchItemStatus');?>", {"id":id,"status":status}, function(r){
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
            $.post("<?php echo url('Turntable', 'switchItemVerify');?>", {"id":id,"verify":verify}, function(r){
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
