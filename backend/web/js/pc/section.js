/* 部分共用 */
layui.use(['layer','form'],function(){
	var layer=layui.layer;
	$(function(){
		/*编辑提交*/
		$('#section > form').bind('submit', function(){
			if(isOk() === true){
				return false;
			}
			
			/*是否有详情或内容*/
			if($('#editor').length > 0){
				var ct = UE.getEditor('editor').getContent();
				if(ct==''){
					layer.msg(($('#editor').attr('msg')==undefined?'内容':$('#editor').attr('msg'))+'不能为空！', {icon: 2});
					return false;
				}
				$('#edtext').html(ct);
			}
			
			/* 提交数据 */
			$(this).ajaxSubmit({
				type: 'post',
				url: $(this).attr('action'),
				dataType : "json",
				data: {},
				success: function(d) {
					if(d.s === 1){
						if(isNull(prid)){
							var ids = ($('#ids').val())*1;
							if(isNull(ids)){
								parent.navtab.ajaxPage = ids;
							}
						}
						layer.msg(d.m, {icon: 1});
						if(d.u != ''){
							setTimeout("stoHrefOf('"+d.u+"',3);",1000);
						}
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
		});
		
		if($('#edtext') && $('#edtext').length > 0 && $('#edtext').html().length > 0){
			UE.getEditor('editor').setContent(strToHtml($('#edtext').html()), false);
		}
	});	
});

$(function(){
	$('#section > form').addClass('layui-form col-lg-5');
});

/* 文章添加编辑时间工具 */
function newsTime(){
	layui.use('laydate', function(){
		var laydate = layui.laydate;
		laydate.render({
			elem: '#uptime',
			format: 'yyyy-MM-dd'
		});
		laydate.render({
			elem: '#begtime',
			format: 'yyyy-MM-dd HH:mm:ss'
		});
		laydate.render({
			elem: '#endtime',
			format: 'yyyy-MM-dd HH:mm:ss'
		});
	});
}
