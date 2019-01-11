/**
 * 启用模块
 */
layui.use(['jquery','layer'],function(){
   'use strict';
	var $ = layui.jquery
	   ,layer=layui.layer;
    
    $(window).on('resize',function(){
        var w = $(window).width();
        var h = $(window).height();
        $('.larry-canvas').width(w).height(h);
    }).resize();
    $(function(){
        $("#canvas").jParticle({
            background: "#141414",
            color: "#E5E5E5"
        });

    	/*注册表单提交函数*/
    	$('#login-form').bind('submit', function(){
    		
    		if(isOk() === true){
    			return false;
    		}
    		var name = $('#name').val(),code = $('#code').val();
    		if(isNull(name) === false){
    			layer.msg('用户名为空！', {icon: 2});
    		}else if(name.length <4 || name.length > 10){
    			layer.msg('用户名格式错误！', {icon: 2});
    		}else if(isNull($('#password').val()) === false){
    			layer.msg('密码为空！', {icon: 2});
    		}else if(isNull(code) === false){
    			layer.msg('请输入验证码！', {icon: 2});
    		}else if(code.length != 4){
    			layer.msg('验证码格式错误！', {icon: 2});
    		}else{
    			$(this).ajaxSubmit({
    				type: 'post',
    				url: $(this).attr('action'),
    				dataType : "json",
    				data: {'ajax': 1},
    				success: function(d) {
    					if(d.s === 1){
    						layer.msg(d.m, {icon: 1});
    						stoHref(d.u,1);
    					}else{
    						layer.msg(d.m, {icon: 0});
    						isSub = false;
    					}
    					$('#verifyImg').click();
    		        },
    		        beforeSend:function(d){
    		        	isSub = true;
    		        }
    			});
    		}
    		
    	    return false;
    	});
    });

});