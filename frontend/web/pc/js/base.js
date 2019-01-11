var layer,form;
layui.use(['layer', 'form'], function(){
	layer = layui.layer, form = layui.form();
});

$(function(){
	$('.cents').css({'min-height':($(document).height())+'px'});
	
/**
   * 二级密码验证
   */
	$('#twopass-form').bind('submit', function(){
		
		var pass= $('#pass').val();
		
		if(pass == ''){
			layer.msg('密码为空！', {icon: 2});
		}else{
			$(this).ajaxSubmit({
				type: 'post',
				url: $(this).attr('action'),
				dataType : "json",
				data: {'ajax': 1},
				success: function(d) {
		            if(d.status == 1){
		            	layer.msg(d.msg, {icon: 1});
		            	setTimeout("location.href='"+d.url+"';",1500);
		            }else{
		            	layer.msg(d.msg, {icon: 0});
		            }
		        }
			});
		}
		
	    return false;
	});
});