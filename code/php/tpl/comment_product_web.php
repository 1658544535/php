<div class="product_comment_warp">
	<div class="product_score">
		<p>商品满意度<span>5</span></p>
		<p class="score">
			<img src="../images/tzm_collect_s.png" /><img src="../images/tzm_collect_s.png" /><img src="../images/tzm_collect_s.png" /><img src="../images/tzm_collect_s.png" /><img src="../images/tzm_collect_s.png" />
		</p>
	</div>

	<div class="product_score_grade">
		<a data-score="all" href="?pid=<?php echo $pid ?>&act=comment_content" class="active">全部</a>
		<a data-score="3" href="?pid=<?php echo $pid ?>&act=comment_content">好评</a>
		<a data-score="2" href="?pid=<?php echo $pid ?>&act=comment_content">中评</a>
		<a data-score="1" href="?pid=<?php echo $pid ?>&act=comment_content">差评</a>
	</div>

	<div class="product_comment_list"></div>
</div>
<script>
	$(function(){
		var xhr_comment;
		getComment($(".product_score_grade a").eq(0).attr("href"),'all');
		$(".product_score_grade a").on("click",function(){
			$(".product_score_grade a").removeClass("active");
			$(this).addClass("active");

			var aUrl = $(this).attr("href"),
				aScore = $(this).attr("data-score");
			getComment(aUrl,aScore)
			return false;

		})
		function getComment(url,score){
			if(!!xhr_comment){
				xhr_comment.abort();		//取消未请求完成的ajax
			}
			xhr_comment = $.ajax({
				url: url,
				dataType: "json",
				success: function(result){
					if(result['code']>0){
						$(".product_comment_list").html("");
						var comment_num = 0;
						for(var j=0; j<result['data'].length; j++){
							var a_score_product = parseInt(result['data'][j]['score_product']),
								a_user_name = result['data'][j]['user_name'],
								a_comment = result['data'][j]['comment'],
								a_create_date = result['data'][j]['create_date'];
							if(score == 'all'){
								writeComment(a_score_product, a_user_name, a_comment, a_create_date);
								comment_num++;
							}else if(score == result['data'][j]['score']){
								writeComment(a_score_product, a_user_name, a_comment, a_create_date);
								comment_num++
							}
						}
						if(comment_num == 0){
							$(".product_comment_list").html('<div class="order_empty"><dl><dd><img src="/images/order/orderlist_icon.png"width="100"/></dd><dd>暂无评价</dd></dl></div>');
						}
					}else{
						$(".product_comment_list").html('<div class="order_empty"><dl><dd><img src="/images/order/orderlist_icon.png"width="100"/></dd><dd>暂无评价</dd></dl></div>');
					}
				}
			});
		}
		function writeComment(score_product, user_name, comment, create_date){
			var comment_html = '<dl><dt>';
			//评星
			comment_html += '<p class="score">';
			for(var i=1; i<=5; i++){
				if(i<=score_product){
					comment_html += '<img src="../images/tzm_collect_s.png" />';
				}else{
					comment_html += '<img src="../images/tzm_collect.png" />';
				}
			}
			comment_html += '</p>';

			//用户名
			comment_html += '<p>'+ user_name +'</p></dt>';

			//评论内容
			comment_html += '<dd>'+ comment +'</dd>';

			//评论时间
			comment_html += '<dd>'+ create_date +'</dd></dl>';
			$(".product_comment_list").append(comment_html);
		}
	});
</script>
