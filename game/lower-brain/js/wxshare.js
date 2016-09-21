function wxshare( debug, appId, timestamp, nonceStr, signature, imgUrl, link, title, desc )
{
	  wx.config({
	    debug: debug,
	    appId: appId,
	    timestamp: timestamp,
	    nonceStr: nonceStr,
	    signature: signature,
	    jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage']
	  });

	  wx.ready(function () {
	    wx.onMenuShareAppMessage({
	        title: title,
	        desc: desc,
	        link: link,
	        imgUrl: imgUrl + '&from=singlemessage'
	    });

	    wx.onMenuShareTimeline({
	        title: title,
	        link: link,
	        imgUrl: imgUrl + '&from=timeline',
	        desc: desc
	    });

	 });
}