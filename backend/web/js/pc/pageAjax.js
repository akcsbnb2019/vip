//启用模块
var laypage;
var dataobj = {};
var wheres  = '';
layui.use(['laypage'], function(){
	laypage = layui.laypage;
	
	laypage.render({
	    elem: 'page'
	    ,count: num
	    ,curr: page
	    ,skin: '#1E9FFF'
		,limit: limit
		,limits:[10,20,30]
	    ,layout: ['count', 'prev', 'page', 'next', 'limit', 'skip']
		,whereid : ''
	    ,jump: hrefs
	  });
  	
});

/* 分页刷新&跳转 */
function hrefs(obj, first){
	var urls = '';
	if(!first){
		urls = Urs+'?temp=1&page=' + obj.curr + '&limit='+obj.limit+wheres;
		
		if($('#search') && $('#search').length > 0){
			urls += '&s='+$('#search').val();
		}
		if(isSub === true){
			return false;
		}
		
		$.ajax({
			type: 'get',
			url: urls,
			dataType : "json",
			data: {},
			success: function(d) {
				if(d.html){
					$('#tbodys').html(d.html.replace("\\",""));
					/* 指定更新 */
				    statis_on();
				}

				if(d.page.totalCount != obj.count){
					obj.count = d.page.totalCount;
					$('#page .layui-laypage-btn').click();
				}
				isSub = false;
	        },
	        beforeSend:function(d){
	        	isSub = true;
	        }
		});
	}
}