jQuery(function($){

    $.supersized({

        // Functionality
        slide_interval     : 10000,    // Length between transitions
        transition         : 1,    // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
        transition_speed   : 3000,    // Speed of transition
        performance        : 1,    // 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)

        // Size & Position
        min_width          : 0,    // Min width allowed (in pixels)
        min_height         : 0,    // Min height allowed (in pixels)
        vertical_center    : 1,    // Vertically center background
        horizontal_center  : 1,    // Horizontally center background
        fit_always         : 0,    // Image will never exceed browser width or height (Ignores min. dimensions)
        fit_portrait       : 1,    // Portrait images will not exceed browser height
        fit_landscape      : 0,    // Landscape images will not exceed browser width

        // Components
        slide_links        : 'blank',    // Individual links for each slide (Options: false, 'num', 'name', 'blank')
        slides             : [    // Slideshow Images
                                 {image : '/img/s1.jpg'},
                                 {image : '/img/s2.jpg'},
                                 {image : '/img/s3.jpg'}
                             ]

    });
	
	$('#side-menu .nav a').click('on',function(){
		$('#side-menu .nav a').removeClass('actives');
		$(this).addClass('actives');
	});
	var defurl = '';
	$('#side-menu a').click('on',function(){
		var _this = $(this);
		var _url  = _this.attr('href');
		if(_url != null &&_url != '' && _url != 'javascript:;'){
			var allea = $('#content-main .J_iframe');
			$.each(allea,function(a,b){
				if((a+1 != allea.length || defurl == allea.length) && _url == $(this).attr('src')){
					$(this).attr('src',$(this).attr('src'));
				}
			});
			defurl = allea.length;
		}
	});
	
	/* 登出系统 */
	$('#logout').on('click', function () {
    	layer.confirm('你真的确定要退出系统吗？', {
		  title: '退出登陆提示',
		  btn: ['确定','取消'],
		}, function(){
			$.post("/index/logout", {}, function(r){
				location.reload();
            });
		}, function(){
		});
    });

});
