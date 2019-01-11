/**
 * @name 用户控制
 */
layui.define(['form','layer'],function(exports){
  "use strict";
	var $ = layui.$;
	var layer=layui.layer;
	
	$(function(){
		/*编辑菜单提交*/
		$('form#menu-form').on('beforeSubmit', function (e) {
			
			if(isOk() === true){
				return false;
			}
			var name = $('#name').val();
			if(isNull(name) === false){
				layer.msg('名称为空！', {icon: 2});
			}else if(name.length <4 || name.length > 255){
				layer.msg('名称格式错误！', {icon: 2});
			}else if(isNull($('#url_key').val()) === false){
				layer.msg('Url名称为空！', {icon: 2});
			}else{
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
			}
			
		    return false;
		}).on('submit', function (e) {
	        e.preventDefault();
	    });
		
		/*编辑角色提交*/
		$('form#auth-form').on('beforeSubmit', function (e) {
			
			if(isOk() === true){
				return false;
			}
			var name = $('#name').val();
			if(isNull(name) === false){
				layer.msg('名称为空！', {icon: 2});
			}else if(name.length <4 || name.length > 50){
				layer.msg('名称格式错误！', {icon: 2});
			}else{
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
			}
			
		    return false;
		}).on('submit', function (e) {
	        e.preventDefault();
	    });
		//$('#menu-form,#auth-form').addClass('layui-form col-lg-5');
	});
    exports('gruser', {}); 
});