/*
*	通用js
*	Author: xujk.cc
*	date: 2016.07.04
*/

$(function(){});

/*
* checkbox
*/
var ifCheckAll = true;
function fn_g_checkbox(){
	if($("input.g-ckx").length<=0) return false;
	$("input.g-ckx").each(function(index, el) {
		if($(el).parents(".ckx-box").length<=0){
			if($(el).is(":checked")){
				$(el).wrap('<div class="ckx-box active"></div>');
			}else{
				$(el).wrap('<div class="ckx-box"></div>');
			}
		}
	});
	$(".g-ckx").unbind("change").bind("change", function(){
		if($(this).is(":checked")){
			$(this).parent().addClass("active");
		}else{
			$(this).parent().removeClass("active");
		}
	})
}








