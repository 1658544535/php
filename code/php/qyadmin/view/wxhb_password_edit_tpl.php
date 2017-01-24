<?php include_once('common_header_tpl.php');?>

<section class="content-header">
    <h1>
        微信红包口令
    </h1>
</section>

<section class="content">
	<div class="box">
		<ul class="box-header">
            <h3 class="box-title">微信红包口令编辑</h3>
        </ul>

		<div class="box-body">
			<form class="form-horizontal" action="<?php echo url('WxHongbao', 'editPassword');?>" method="post" id="editTypeForm">
				<input type="hidden" name="id" value="<?php echo $info['id'];?>" />
				<div class="box-body">
					<div class="form-group">
						<label for="nameForRule" class="col-sm-2 control-label">口令：</label>
						<div class="col-sm-10">
							<input class="form-control" name="data[password]" id="nameForRule" placeholder="请输入口令..." type="text" value="<?php echo $info['password'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="nameForRule" class="col-sm-2 control-label">金额：</label>
						<div class="col-sm-10">
							<input class="form-control" name="data[money]" id="nameForRule" placeholder="请输入金额..." type="text" value="<?php echo $info['money'];?>">
						</div>
					</div>
					<div class="form-group">
						<label for="nameForRule" class="col-sm-2 control-label">数量：</label>
						<div class="col-sm-10">
							<input class="form-control" name="data[total]" id="nameForRule" placeholder="请输入数量..." type="text" value="<?php echo $info['total'];?>">
						</div>
					</div>
				</div>

				<div class="box-footer">
					<button type="button" class="btn btn-default" onclick="window.location.href='<?php echo url('WxHongbao');?>'">返回</button>
					<button type="submit" class="btn btn-info pull-right">保存</button>
				</div>
			</form>
		</div>
	</div>
</section>

<?php include_once('common_footer_tpl.php');?>