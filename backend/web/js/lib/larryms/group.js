/**
 * @name 角色控制
 */
layui.define(['form','layer'],function(exports){
  "use strict";
	var $ = layui.$;
	var layer=layui.layer;
	
	$(function(){
		/* 编辑角色提交 */
		$('form#group-form').on('beforeSubmit', function (e) {
			if(isOk() === true){
				return false;
			}
			$(this).ajaxSubmit({
				type: 'post',
				url: $(this).attr('action'),
				dataType : "json",
				data: {},
				success: function(d) {
					if(d.s === 1){
						layer.msg(d.m, {icon: 1});
						stoHrefOf(d.u,3);
					}else{
						layer.msg(d.m, {icon: 0});
					}
					isSub = false;
		        },
		        beforeSend:function(d){
		        	isSub = true;
		        }
			});
			
		    return false;
	    }).on('submit', function (e) {
	        e.preventDefault();
	    });
		
		$('#auth-form').addClass('layui-form col-lg-5');
		
		inifun();
		$('#lists #group').click('on',function(){
	    	addHref($(this),thisIg+'?d=i');
	    });
	});
    exports('group', {}); 
});