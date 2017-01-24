<?php include_once('common_header_tpl.php');?>

<section class="content-header">
    <h1>
        微信红包口令
    </h1>
</section>

<section class="content">
	<div class="box">
		<ul class="box-header">
            <h3 class="box-title">微信红包口令</h3>
        </ul>

		<div class="box-body">
			<div class="dataTables_wrapper form-inline dt-bootstrap">
				<div class="row">
					<div class="col-sm-12">
						<table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
							<thead>
                                <tr role="row">
                                    <th>口令</th>
                                    <th>金额</th>
                                    <th>剩余数量</th>
									<th>操作</th>
                                </tr>
                            </thead>
							<tbody>
								<?php foreach($list as $v){ ?>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><?php echo $v->password;?></td>
                                        <td class="sorting_1"><?php echo $v->money;?></td>
                                        <td class="sorting_1"><?php echo $v->total;?></td>
										<td>
											<a href="<?php echo url('WxHongbao', 'editPassword', array('id'=>$v->id));?>">修改</a>
										</td>
                                    </tr>
                                <?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include_once('common_footer_tpl.php');?>