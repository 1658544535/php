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

        <?php include_once('turntable_edit_bar_tpl.php');?>

        <div class="box-body">
            <form class="form-horizontal" action="<?php echo url('Turntable', $action);?>" method="post" id="editTypeForm">
                <input type="hidden" name="id" value="<?php echo $info['id'];?>" />
                <input type="hidden" name="hdid" value="<?php echo $hdid;?>" />
                <div class="box-body">
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">奖品名称：</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="data[name]" id="nameForRule" placeholder="名称..." type="text" value="<?php echo $info['name'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">奖品说明：</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="data[desc]" id="nameForRule" placeholder="说明..." type="text" value="<?php echo $info['desc'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">奖品数量：</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="data[num]" id="nameForRule" placeholder="数量..." type="text" value="<?php echo $info['num'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">奖品中奖率：</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="data[ratio]" id="nameForRule" placeholder="中奖率..." type="text" value="<?php echo $info['ratio'];?>" style="width:70px; display:inline;">
                            (单位：%)
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">奖品对应角度：</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="data[angle]" id="nameForRule" placeholder="角度..." type="text" value="<?php echo $info['angle'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">每天最多可派送：</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="data[per_day_num]" id="nameForRule" placeholder="不填为不限" type="text" value="<?php echo $info['per_day_num'];?>">
                        </div>
                    </div>
                    <div class="form-group" style="display:none">
                        <label for="nameForRule" class="col-sm-2 control-label">是否为得奖：</label>
                        <div class="col-sm-10">
                            <input type="radio" name="data[is_prize]" value="1" <?php if($info['is_prize'] == 1) echo 'checked';?> />是
                            <input type="radio" name="data[is_prize]" value="0" <?php if($info['is_prize'] == 0) echo 'checked';?> />否
                        </div>
                    </div>
                    <div class="form-group" style="display:none">
                        <label for="nameForRule" class="col-sm-2 control-label">是否虚拟：</label>
                        <div class="col-sm-10">
                            <input type="radio" name="data[is_virtual]" value="1" <?php if($info['is_virtual'] == 1) echo 'checked';?> />是
                            <input type="radio" name="data[is_virtual]" value="0" <?php if($info['is_virtual'] == 0) echo 'checked';?> />否
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">奖品类型：</label>
                        <div class="col-sm-10">
                            <select name="data[type]" id="" class="form-control">
                                <option value="1">红包</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">红包金额：</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="data[item_value]" id="nameForRule" placeholder="金额..." type="text" value="<?php echo $info['item_value'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nameForRule" class="col-sm-2 control-label">第几次抽奖可中：</label>
                        <div class="col-sm-10">
                            <input class="form-control" name="data[win_index]" id="nameForRule" type="text" value="<?php echo $info['win_index'];?>" style="display:inline;" />
                            (多次以英文逗号分隔)
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="button" class="btn btn-default" onclick="window.location.href='<?php echo url('Turntable', 'items', array('id'=>$hdid));?>'">返回</button>
                    <button type="submit" class="btn btn-info pull-right">保存</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include_once('common_footer_tpl.php');?>
