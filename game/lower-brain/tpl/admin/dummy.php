<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head runat="server">
	    <title>管理后台</title>
		<link rel="/game/lower-brain/css/admin.css" />
	    <style>

	    </style>

	</head>

	<body>
	    <form id="form1" action="manage_save.php" class="data_warp" method="post">
	    	<input type="hidden" name="act" value="dummy" />

	    	<p>虚拟数据设置 (非经许可请不要随意设置)</p>

			<dl>
				<dd>
					<dt>是否启动</dt>
					<select name="enable" class="input_txt">
						<option value="1" <?php echo $selected =  ($arrData->enable  == 1 ) ? 'selected' : '' ?> >开启</option>
						<option value="0" <?php echo $selected =  ($arrData->enable  == 0 ) ? 'selected' : '' ?> >不开启</option>
					</select>
				<dd>
			</dl>

			<dl>
				<h4>淘竹马数据</h4>
				<dd>
					<dt>今日成交量</dt>
					<input class="input_txt" type="text" name="tzmBargainNum" value="<?php echo $arrData->tzmBargainNum ?>" />
				<dd>

				<dd>
					<dt>累计交易额</dt>
					<input class="input_txt" type="text" name="tzmTransactionPriceSum" value="<?php echo $arrData->tzmTransactionPriceSum ?>" />
				<dd>

				<dd>
					<dt>注册用户　</dt>
					<input class="input_txt" type="text" name="tzmAllUserNum" value="<?php echo $arrData->tzmAllUserNum ?>" />
				<dd>
			</dl>

			<dl>
				<h4>电商数据</h4>
				<dd>
					<dt>淘宝　　</dt>
					<input class="input_txt" type="text" name="ecTaobao" value="<?php echo $arrData->ecTaobao ?>" />
				<dd>

				<dd>
					<dt>宇博　　</dt>
					<input class="input_txt" type="text" name="ecYubo" value="<?php echo $arrData->ecYubo ?>" />
				<dd>

				<dd>
					<dt>阿里　　</dt>
					<input class="input_txt" type="text" name="ecAli" value="<?php echo $arrData->ecAli ?>" />
				<dd>
			</dl>

			<dl>
				<h4>玩具总汇数据</h4>
				<dd>
					<dt>入驻企业</dt>
					<input class="input_txt" type="text" name="toyCompanyCount" value="<?php echo $arrData->toyCompanyCount ?>" />
				<dd>

				<dd>
					<dt>注册用户</dt>
					<input class="input_txt" type="text" name="toyUserCount" value="<?php echo $arrData->toyUserCount ?>" />
				<dd>
			</dl>

			<dl>
				<h4>网站访问量</h4>
				<dd>
					<dt>淘竹马　</dt>
					<input class="input_txt" type="text" name="todayVisitNum" value="<?php echo $arrData->todayVisitNum ?>" />
				<dd>

				<dd>
					<dt>玩具总汇</dt>
					<input class="input_txt" type="text" name="toys_visit" value="<?php echo $arrData->toys_visit ?>" />
				<dd>

			</dl>

			<dd>
				<input type="submit" name="提交" class="btn" />
			<dd>

			</br></br>
			<a href="/tvshow/index.php">设置真实数据</a>
	    </form>

	</body>
</html>
