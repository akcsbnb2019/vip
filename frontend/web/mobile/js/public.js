jQuery(function($){

	/* 登出系统 */
	/* $('#logout,.logout').on('click', function () {
    	layer.confirm('你真的确定要退出系统吗？', {
		  title: '退出登陆提示',
		  btn: ['确定','取消'],
		}, function(){
			$.post("/index/logout", {}, function(r){
				location.reload();
            });
		}, function(){
		});
    }); */
	$('#logout,.logout').on('click', function () {
		layer.open({
			content: '你真的确定要退出系统吗？'
			,shadeClose: true
			,btn: ['确定', '取消']
			,yes: function(index){
				$.post("/index/logout", {}, function(r){
					location.reload();
				});
			}
		});
	});
	
	/* 跳转 */
	$('.href_').on('click', function () {
    	window.location.href = $(this).attr("href");
    });
	
	var bdin_m = '';
	$('.icon-checkbox-m').click('on',function(){
		bdin_m = bdin_m == '' ? 'hiddens' : '';
		if(bdin_m == ''){
			$('.bds_m2').removeClass('hiddens');
		}else{
			$('.bds_m2').addClass('hiddens');
		}
	});

});