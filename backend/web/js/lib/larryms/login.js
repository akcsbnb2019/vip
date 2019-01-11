/**
 * @name 后台登录模块
 */
layui.define(['larry','larryms'],function(exports){
	"use strict";
	var $ = layui.$,
            layer = layui.layer,
            larryms = layui.larryms;
    // larryms.success('用户名：larry 密码：larry 无须输入验证码，输入正确后直接登录后台!','larryMS后台帐号登录提示',20);
    
    function supersized() {
        $.supersized({
            // 功能
            slide_interval: 3000,
            transition: 1,
            transition_speed: 1000,
            performance: 1,
            // 大小和位置
            min_width: 0,
            min_height: 0,
            vertical_center: 1,
            horizontal_center: 1,
            fit_always: 0,
            fit_portrait: 1,
            fit_landscape: 0,
            // 组件
            slide_links: 'blank',
            slides: [{
                image: '/images/login/1.jpg'
            }, {
                image: '/images/login/2.jpg'
            }, {
                image: '/images/login/3.jpg'
            }]
        });
    }
    $('#change').click('on',function(){
    	$('#codeimage').click();
    });
    larryms.plugin('jquery.supersized.min.js',supersized);
    
    /* 表单提交-一般模式 */
	$('form#zm-form').on('beforeSubmit', function (e) {
		if(Zi.isOk() === true){
			return false;
		}
        var $form = $(this);
        $.ajax({
            url: $form.attr('action'),
            type: 'post',
            data: $form.serialize(),
            success: function (d) {
                if(Zi.isNull(d.status)){
                	if(Zi.isNull(d.url)){
                		layer.msg(d.msg, {icon: d.status});
                		Zi.stoHref(d.url,1);
                	}else{
                		layer.tips(d.msg, $('#'+d.id), { tips: [3, '#FF5722']});
                	}
                }else if(Zi.isNull(d[0])){
                	layer.msg(d[0], {icon: 0});
                }else{
                	layer.msg('系统异常', {icon: 3});
                }
                Zi.sub = false;
                $('#codeimage').click();
            },
	        beforeSend:function(d){
	        	Zi.sub = true;
	        }
        });
        return false;
    }).on('submit', function (e) {
        e.preventDefault();
    });
    exports('login', {}); 
});