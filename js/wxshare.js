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

	var cfgCallbacks = {
		"shareAppMessage": {
			"success": "wxshareAppMessageSuccess",
			"cancel": "wxshareAppMessageCancel"
		},
		"shareTimeline": {
			"success": "wxshareTimelineSuccess",
			"cancel": "wxshareTimelineCancel"
		}
	};

	if((typeof(arguments[9]) != "undefined") && (arguments[9] != "null")){
		var cusCallbacks = arguments[9];
		for(var obj in cusCallbacks){
			for(var item in cusCallbacks[obj]){
				cfgCallbacks[obj][item] = cusCallbacks[obj][item];
			}
		}
	}

	  wx.ready(function () {
	    wx.onMenuShareAppMessage({
	        title: title,
	        desc: desc,
	        link: link,
	        imgUrl: imgUrl,
			success: function(){
				eval(cfgCallbacks["shareAppMessage"]["success"]+"()");
			},
			cancel: function(){
				eval(cfgCallbacks["shareAppMessage"]["cancel"]+"()");
			}
	    });

	    wx.onMenuShareTimeline({
	        title: title,
	        link: link,
	        imgUrl: imgUrl,
	        desc: desc,
			success: function(){
				eval(cfgCallbacks["shareTimeline"]["success"]+"()");
			},
			cancel: function(){
				eval(cfgCallbacks["shareTimeline"]["cancel"]+"()");
			}
	    });

	 });
}

function wxshareAppMessageSuccess(){}
function wxshareAppMessageCancel(){}
function wxshareTimelineSuccess(){}
function wxshareTimelineCancel(){}