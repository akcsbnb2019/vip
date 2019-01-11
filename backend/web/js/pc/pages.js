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
		,whereid : wheres
	    ,jump: hrefs
	  });
  	
});

/* 分页刷新&跳转 */
function hrefs(obj, first){
	if(!first){
		var urls = window.location.pathname;
		urls = urls.charAt(urls.length - 1) == '/' ? urls : urls+'/';
		if(obj.whereid!=""){
            urls +='?tab=all&page=' + obj.curr + obj.whereid + '&limit='+obj.limit;
        }else{
            urls +='?tab=all&page=' + obj.curr + '&limit='+obj.limit;
        }
		
		if($('#search') && $('#search').length > 0){
			urls += '&s='+$('#search').val();
		}
		
		location.href = urls;
	}
}