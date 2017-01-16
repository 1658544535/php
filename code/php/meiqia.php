<?php
$mobile = isset($_GET['m']) ? trim($_GET['m']) : '';
$productId = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
$orderNo = isset($_GET['ono']) ? trim($_GET['ono']) : '';

$ctTel = $mobile;
$comment = array();
$productId && $comment[] = '商品id：'.$productId;
$orderNo && $comment[] = '订单编号：'.$orderNo;
$ctComment = empty($comment) ? '' : implode('，', $comment);
?>
<script type='text/javascript'>
    (function(m, ei, q, i, a, j, s) {
        m[i] = m[i] || function() {
            (m[i].a = m[i].a || []).push(arguments)
        };
        j = ei.createElement(q),
            s = ei.getElementsByTagName(q)[0];
        j.async = true;
        j.charset = 'UTF-8';
        j.src = '//static.meiqia.com/dist/meiqia.js';
        s.parentNode.insertBefore(j, s);
    })(window, document, 'script', '_MEIQIA');
    _MEIQIA('entId', 36305);

	var customData = {};
	<?php if($ctTel){ ?>customData["tel"] = "<?php echo $ctTel;?>";<?php } ?>
	<?php if($ctComment){ ?>customData["comment"] = "<?php echo $ctComment;?>";<?php } ?>

	// 传递顾客信息
    _MEIQIA('metadata', customData);

	// 初始化成功时的回调
    _MEIQIA('allSet', function(){
        _MEIQIA('showPanel');
    });
</script>