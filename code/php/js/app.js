$(function() {
    $(document).on("pageInit", "#page-index", function(e, pageId, page) {

    	//生成左右滑动页面
    	$(".index-page>.swiper-wrapper").html('');
    	$(".index-class .swiper-wrapper>a").each(function(index, el) {
    		var type = $(el).attr("data-type");
    		var html = '<div class="swiper-slide" id="index_page_'+ (index+1) +'">';
    		switch (type){
    			case 'index':
    				html += '<section class="swiper-container index-banner" data-space-between="0">'
			             +      '<div class="swiper-wrapper"></div>'
			             +      '<div class="swiper-pagination"></div>'
			             +  '</section>'
    				     +  '<section class="index-index infinite-scroll infinite-scroll-bottom" data-distance="30">'
                         +      '<h2 class="index-pro-title"></h2>'
                         +      '<ul class="list-container"></ul>'
                         +      '<div class="infinite-scroll-preloader">'
                         +          '<div class="preloader"></div>'
                         +      '</div>'
                         +  '</section></div>';
                    break;
    			case 'class':
    				html += '<section class="index-pro infinite-scroll infinite-scroll-bottom" data-distance="30">'
                         +      '<ul class="list-container"></ul>'
                         +      '<div class="infinite-scroll-preloader">'
                         +          '<div class="preloader"></div>'
                         +      '</div>'
                         +  '</section></div>';
                    break;
    		}
    		$(".index-page>.swiper-wrapper").append(html);
    	});
	    //页面左右滑动
	    var swiperIndexPage = new Swiper('.index-page', {
	        spaceBetween: 0,
	        onSlideChangeEnd: function(e){
	        	var index = swiperIndexPage.activeIndex + 1;
	        	$(".index-class .swiper-wrapper>a").removeClass("active").eq(index-1).addClass("active");
	        	//容器发生改变,如果是js滚动，需要刷新滚动
            	$(".index-page").scroller('refresh');

            	var pageObj = $(".index-class .swiper-wrapper>a").eq(index-1);
            	var type = pageObj.attr("data-type"),
            		url = pageObj.attr("data-href");
            	$(".index-page").find('.infinite-scroll-bottom .list-container').html('');
            	getData(index, type, url);
	        }
	    });
    	//分类导航滑动
    	var swiperIndexClass = new Swiper('.index-class', {
	        spaceBetween: 20,
    		freeMode : true,
			slidesPerView : 'auto',
			onSlideChangeEnd: function(){
				var index = swiperIndexPage.activeIndex;
				swiperIndexPage.slideTo(index, 400, true);
			}
	    });
	    //点击分类导航页面左右滑动
	    $(".index-class .swiper-wrapper>a").on("click", function(){
	    	var index = $(".index-class .swiper-wrapper>a").index(this);
	    	swiperIndexPage.slideTo(index, 400, true);
	    });


        var loading = false,
        	pageCount = 2,
        	pageNow = 1;

        //预先加载20条
        getData(1, 'index', 'url');

        // 注册'infinite'事件处理函数
        $(page).on('infinite', function() {
        	var pageIndex = $(".index-class a").index($(".index-class a.active"))+1,
        		type = $(".index-class .swiper-wrapper>a.active").attr("data-type");

            // 如果正在加载，则退出
            if (loading) return;

            // 设置flag
            loading = true;

            getData(pageIndex, type, 'url');

            //容器发生改变,如果是js滚动，需要刷新滚动
            $.refreshScroller();
        });

        function getData(index_page, type, url, swiperIndexBanner){
        	// $.ajax({
            // 	url: url,
            // 	type: 'POST',
            // 	dataType: 'json',
            // 	success: function(res){

            // 	}
            // });
            var res = {
            	msg: '成功',
            	data: {
            		"banner": [
            			{
            				url: "",
            				imgSrc: "images/img/banner.jpg"
            			},
            			{
            				url: "",
            				imgSrc: "images/img/banner.jpg"
            			},
            			{
            				url: "",
            				imgSrc: "images/img/banner.jpg"
            			}
            		],
            		proList: {
            			pageNow: 1,
	            		pageCount: 10,
	            		listData: [
		            		{
		            			id: '0',
		            			name: '智库WISDOM WAREHOUSE 吸吸乐儿童',
		            			sales: 2138,
		            			num: 2,
		            			price: 29.9,
		            			oldPrice: 59,
		            			imgSrc: 'images/img/index-pro.jpg'
		            		},
		            		{
		            			id: '1',
		            			name: '智库WISDOM WAREHOUSE 吸吸乐儿童1111',
		            			sales: 2138,
		            			num: 2,
		            			price: 29.9,
		            			oldPrice: 59,
		            			imgSrc: 'images/img/index-pro.jpg'
		            		}
		            	]
            		}
            	}
            }
            switch (type){
            	case "index" :
            		var html = '';
            		for(var i=0; i<res.data.banner.length; i++){
            			html += '<a class="swiper-slide" href="'+ res.data.banner[i]["url"] +'"><img src="'+ res.data.banner[i]["imgSrc"] +'"></a>'
            		}
		    		swiperIndexBanner = new Swiper('.index-banner', {
				        spaceBetween: 0,
				        pagination: '.swiper-pagination',
				        observer: true
				    });
            		$(".index-banner .swiper-wrapper").html(html);
            		html = '';
            		for(var i=0; i<res.data.proList.listData.length; i++){
            			html += '<li><a href="'+ res.data.proList.listData[i]["id"] +'">'
				             +      '<div class="img"><img src="'+ res.data.proList.listData[i]["imgSrc"] +'" /></div>'
				             +      '<div class="info">'
				             +          '<p class="name">'+ res.data.proList.listData[i]["name"] +'</p>'
				             +          '<span class="sales">销量：'+ res.data.proList.listData[i]["sales"] +'</span>'
				             +      '</div>'
				             +      '<div class="group">'
				             +          '<span class="num">'+ res.data.proList.listData[i]["num"] +'人团</span>'
				             +          '￥<span class="now-price">'+ res.data.proList.listData[i]["price"] +'</span>'
				             +          '<span class="old-price">￥'+ res.data.proList.listData[i]["oldPrice"] +'</span>'
				             +      '</div>'
				             +  '</a></li>'
            		}
            		$("#index_page_" + index_page).find('.infinite-scroll-bottom .list-container').append(html);
            		break;
            	case 'class':
            		var html = '';
            		html = '<li>class</li>';
            		$("#index_page_" + index_page).find('.infinite-scroll-bottom .list-container').append(html);
            		break;
            }

            // 重置加载flag
            loading = false;

            if (pageNow >= pageCount) {
                // 加载完毕，则注销无限加载事件，以防不必要的加载
                $.detachInfiniteScroll($('.infinite-scroll'));
                // 删除加载提示符
                $('.infinite-scroll-preloader').remove();
                return;
            }
        }

    });



    $.init();
});
