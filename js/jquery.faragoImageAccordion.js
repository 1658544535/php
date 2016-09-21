/**************************
@author: JianFeng Tan
@version: 1.0
@first_release: Nov.5, 2009
@email: arantam@163.com
*/
(function ($) {
	$.fn.imageAccordion = function (options) {
		var opts = $.extend({}, $.fn.imageAccordion.defaults, options);
		var IA_img = this.children("img");
		var IA_imgNumbers = IA_img.length;
		var IA_imgWidth = IA_img.width();
		var IA_divWidth = this.width();
		var IA_minWidth = (IA_divWidth - IA_imgWidth) / (IA_imgNumbers - 1)||opts.minWidth;
		var imageSpeed = opts.imageSpeed || "slow";
		var titleSpeed = opts.titleSpeed || "slow";
		IA_img.wrap($("<div></div>").addClass("IA_imageSlice")).after($("<span></span>"));
		IA_img.each(function (i, e) {
			var IA_currentImage = $(e).parent();
			var IA_currentTitle = $(e).next();
			IA_currentTitle.text(($(e).attr("title")) ? $(e).attr("title") : $(e).attr("src"));
			IA_currentImage.css({"z-index":i, "left":i * (IA_divWidth / IA_imgNumbers)});
			IA_currentImage.hover(function () {
				IA_img.each(function (j) {
					var IA_everyImage = $(IA_img[j]).parent();
					if (j <= i) {
						$(IA_everyImage).stop().animate({left:j * IA_minWidth}, imageSpeed);
					} else {
						$(IA_everyImage).stop().animate({left:(j - 1) * IA_minWidth + IA_imgWidth}, imageSpeed);
					}
				});
				IA_currentTitle.stop().animate({bottom:0}, titleSpeed);
			}, function () {
				IA_img.each(function (k) {
					var IA_everyImage = $(IA_img[k]).parent();
					IA_everyImage.stop().animate({left:k * (IA_divWidth / IA_imgNumbers)}, imageSpeed);
				});
				IA_currentTitle.stop().animate({bottom:-IA_currentTitle.height()}, titleSpeed);
			});
		});
	};
	$.fn.imageAccordion.defaults = {minWidth:25, imageSpeed: "slow", titleSpeed: "slow"};
})(jQuery);

