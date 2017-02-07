<div class="box-body">
    <div class="row">
        <div class="col-xs-12 text-center">
            <a class="btn <?php echo ($curPageType == 'edit') ? 'btn-info' : 'btn-default';?>" href="<?php echo ($curPageType == 'edit') ? '#' : url('Turntable', 'editTurntable', array('id'=>$hdid));?>">活动设置</a>
            <a class="btn <?php echo ($curPageType == 'prize') ? 'btn-info' : 'btn-default';?>" href="<?php echo ($curPageType == 'prize') ? '#' : url('Turntable', 'items', array('id'=>$hdid));?>">奖品设置</a>
            <a class="btn <?php echo ($curPageType == 'join') ? 'btn-info' : 'btn-default';?>" href="<?php echo ($curPageType == 'join') ? '#' : url('Turntable', 'editJoin', array('id'=>$hdid));?>">参与设置</a>
        </div>
    </div>
</div>