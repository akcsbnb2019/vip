//启用模块
layui.use(['layer'], function(){
	var layer = layui.layer;
});

$(function(){
	
/**
   * 注册表单提交函数
   */
	$('#login-form').bind('submit', function(){
		
		var UserName= $('#UserName').val(),
		PWD = $('#PWD').val();
		
		if(UserName == ''){
			layer.msg('用户名为空！', {icon: 2});
		}else if(PWD == ''){
			layer.msg('密码为空！', {icon: 2});
		}else{
			$(this).ajaxSubmit({
				type: 'post',
				url: $(this).attr('action'),
				dataType : "json",
				data: {'ajax': 1},
				success: function(d) {
		            if(d.status == 6){
		            	layer.msg(d.msg, {icon: 1});
		            	setTimeout("location.href='"+d.url+"';",1000);
		            }else{
		            	layer.msg(d.msg, {icon: 0});
		            }
		        }
			});
		}
		
	    return false;
	});
	/*退出登录*/
	$('#btnLogout').click('on',function(){
		$('#logout').submit();
	});
	$('#logout').bind('submit', function(){
		
		$(this).ajaxSubmit({
			type: 'post',
			url: $(this).attr('action'),
			dataType : "json",
			data: {'ajax': 1},
			success: function(d) {
				layer.msg(d.msg, {icon: 1});
            	setTimeout("location.href='"+d.url+"';",1000);
	        }
		});
		
	    return false;
	});
	$('#content').css({'height':($(document).height()-290)+'px'});
	
});

/*调整iframe的高度以适应所引用网页的高度*/
function iframeResize(frameId, frameName) {
    var dyniframe   = null;
    var indexwin    = null;
    if ($){
        if(!frameId) {
        	frameId = "contentFrame";
            frameName = "contentFrame";
        }
        dyniframe       = $(frameId);
        indexwin        = window;
        if (dyniframe){
			dyniframe.height = document.documentElement.clientHeight-119;
        }
    }
}