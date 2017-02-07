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
                                        <th>中奖概率</th>
                                        <th>每天最多派发数</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($list)){ ?>
                                        <tr>
                                            <td colspan="9">没有相关信息</td>
                                        </tr>
                                    <?php }else{ ?>
                                        <?php $time = time();?>
                                        <?php foreach($list as $v){ ?>
                                            <tr role="row" class="odd">
                                                <td><div class="form-group"><div class="checkbox"><label><input type="checkbox" value="<?php echo $v['id'];?>" rel="item_data" /></label></div></div></td>
                                                <td class="sorting_1"><?php echo $v['index'];?></td>
                                                <td class="sorting_1"><?php echo $v['name'];?></td>
                                                <td class="sorting_1"></td>
                                                <td class="sorting_1"><?php echo $v['desc'];?></td>
                                                <td class="sorting_1"><?php echo $v['num'];?></td>
                                                <td class="sorting_1"><?php echo $v['ratio'];?></td>
                                                <td class="sorting_1"><?php echo $v['per_day_num'];?></td>
                                                <td>
                                                    <a href="<?php echo url('Turntable', 'editItem', array('id'=>$v['id']));?>">编辑</a> |
                                                    <?php if($v['status'] == 0){ ?>
                                                        <a href="javascript:;" onclick="javascript:changeStatus(<?php echo $v['id'];?>, 1)">上线</a>
                                                    <?php }else{ ?>
                                                        <a href="javascript:;" onclick="javascript:changeStatus(<?php echo $v['id'];?>, 0)">下线</a>
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

<?php include_once('common_footer_tpl.php');?>
