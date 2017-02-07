<div class="box-body">
    <div class="row">
        <div class="col-xs-12 text-center">
            <a class="btn <?php echo ($curPageType == 'edit') ? 'btn-info' : 'btn-default';?>" href="<?php echo url('Turntable', 'editTurntable', array('id'=>$id));?>">活动设置</a>
            <a class="btn <?php echo ($curPageType == 'prize') ? 'btn-info' : 'btn-default';?>" href="<?php echo url('Turntable', 'prizeItems', array('id'=>$id));?>">奖品设置</a>
            <a class="btn <?php echo ($curPageType == 'join') ? 'btn-info' : 'btn-default';?>" href="<?php echo url('Turntable', 'editJoin', array('id'=>$id));?>">参与设置</a>
        </div>
    </div>
</div>