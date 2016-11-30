requirejs(['../config'], function(config){

	requirejs(['jquery', 'baiduTP'], function($, baidu){

		$(function(){

	        /* 跳转到修改页 */
	        $(".js-edit").on('click',function () {
	            var id  = $(this).data('id');
	            var url = 'wx_reply.php?act=edit&id=' + id;
	            window.location.href = url;
	        });

	        /* 删除操作 */
	        $(".js-delete").on('click',function () {
	            if(confirm('确定删除回复?')) {
	                $(this).html('<div class="loading"></div>');
	                var id  = $(this).data('id');
	                var url = 'wx_reply.php?act=delete&id=' + id;
	                var p = $(this).parent().parent();
	                $.getJSON(url,function (data) {
	                    if (data.status) {
	                        p.remove();
	                    } else {
	                        alert(data.info);
	                        $(this).html('删除');
	                    }
	                });
	            }
	            
	        });

	        // 处理回复内容的数据
	        (function() {
	            var bt = baidu.template;
	            var otr = $(".reply-list .table tr");
	            if(otr.length > 1){
	                $(".reply-list .table tr:gt(0)").each(function(index, el) {
	                    var content = $(el).find("td:eq(3)");
	                    try {
	                        // 如果回复内容为json格式的字符串,将字符串转化为指定格式的json
	                        var json = eval("("+content.html()+")");
	                        var data = {},
	                            contentArr = [];
	                        for(var item in json) {
	                            if (json[item] instanceof Object) {
	                                // for(var item2 in json[item]) {
	                                //     var titleArr = [],
	                                //         contentItem = [];
	                                //     for(var itme3 in json[item][item2]) {
	                                //         titleArr.push(itme3);
	                                //         contentItem.push(json[item][item2][itme3]);
	                                //     };
	                                //     contentArr.push(contentItem);
	                                // }
	                                var titleArr = [],
	                                    contentItem = [];
	                                for(var itme3 in json[item]) {
	                                    titleArr.push(itme3);
	                                    contentItem.push(json[item][itme3]);
	                                };
	                                contentArr.push(contentItem);
	                            }else{
	                                titleArr = ['msg'];
	                                contentArr = [[json[item]]]
	                            }
	                            data["title"] = titleArr;
	                            data["content"] = contentArr;
	                        };

	                        //插入表格
	                        var html = bt('t:reply_content', data);
	                        content.html(html);
	                    }catch(e) {
	                        // 如果回复内容为不是json格式的字符串, 不做处理
	                    }
	                    
	                });
	            }
	        })();

	    })
	    
	});

})
