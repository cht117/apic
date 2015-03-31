(function($) {
    $(function() {
        var interval = null;
        $(".sxyjy_nav li").hover(function() {
            $(".sxyjy_tc", this).slideDown("slow");
            $(">a", this).addClass("on");
        }, function() {
            $(".sxyjy_tc", this).slideUp("slow");
			if(!$(">a", this).hasClass('cur_on')){
				$(">a", this).removeClass("on");
			}            
        });
        function start() {
            interval = setInterval(function() {
                var curimg = $(".scroll_on");
                var toimg = curimg.next(".top_img");
                if (toimg.length == 0) {
                    toimg = curimg.siblings(":first");
                }
                imgScroll(curimg, toimg, true);
            }, 4000);
        }
        start();

        $(".sxyjy_btnlb a").hover(function() {
            clearInterval(interval);
        }, function() {
            start();
        }).click(function() {
            var index = $(this).index();
            var curimg = $(".scroll_on");
            var toimg = $(".top_img:eq(" + index + ")");
            imgScroll(curimg, toimg);
        });
    });

    function imgScroll(curimg, toimg, flag) {
        var t = -curimg.width();
        var index = toimg.index();
        $(".sxyjy_btnlb .on").removeClass("on");
        $(".sxyjy_btnlb a:eq(" + index + ")").addClass("on");
        if ( !! flag || curimg.index() < toimg.index()) {
            toimg.css({
                "margin-left": curimg.width(),
                "z-index": 10
            });
        } else {
            toimg.css({
                "margin-left": -curimg.width(),
                "z-index": 10
            });
            t = curimg.width();
        }

        curimg.animate({
            "margin-left": t
        }, {
            duration: 'easein',
            step: function(now, fx) {
                toimg.css("margin-left", -t + now);
            },
            complete: function() {
                curimg.css("z-index", "0");
                curimg.removeClass("scroll_on");
                toimg.addClass("scroll_on");
            }
        });
    }
}(jQuery))

function s(k,p){
	if(k=='请输入关键词'||k==''){alert('请输入关键词'); return false};
	window.location.href='/Search/index?keyword='+k;
}
function enterIn(evt,fun){
	  var evt=evt?evt:(window.event?window.event:null);//兼容IE和FF
	  if (evt.keyCode==13){
		  eval(fun);
	}
}