//启用模块
var laypage;
var dataobj = {};
var wheres  = '';
layui.use(['layer','laypage','form'], function(){
	window.layer = layui.layer;
	laypage = layui.laypage;
	
	laypage.render({
	    elem: 'page'
	    ,count: num
	    ,curr: page
	    ,skin: '#1E9FFF'
		,limit: limit
		,limits:[30,35,50]
	    ,layout: ['count', 'prev', 'page', 'next', 'limit', 'skip']
		,whereid : ''
	    ,jump: hrefs
	  });
  	
});

/* 分页刷新&跳转 */
var nulls = true,isSx=1;
function hrefs(obj, first){
	if(!first){
		var urls = '?limit='+obj.limit+'&page=' + obj.curr +wheres;
		var count= obj.count;
		$('#forms > form').find('input').each(function(a,b){
			if(forms[$(this).attr('name')] != $(this).val()){
				count = 0;
				forms[$(this).attr('name')] = $(this).val();
			}
		});
		
		if(nulls && isOk() === true){
			return false;
		}
		
		if(isSub === true){
			return false;
		}
		
		$('#forms > form').ajaxSubmit({
			type: 'post',
			url: $('#forms > form').attr('action')+urls+'&count='+count,
			dataType : "json",
			data: {count:count},
			success: function(d) {
				if(d.html){
					$('#tbodys').html(d.html.replace("\\",""));
					/* 指定更新 */
				    statis_on();
				}

				if(d.page.totalCount != obj.count){
					nulls = false;
					obj.count = d.page.totalCount;
					$('#page .layui-laypage-btn').click();
				}
				if(isSx != obj.curr){
					sxPage = 0;
					isSx = obj.curr;
				}
				isSub = false;
	        },
	        beforeSend:function(d){
	        	isSub = nulls = true;
	        }
		});
	}
}

function layuiTime(){
	layui.use(['element','laydate'],function(){
        var element = layui.element(),
        laydate = layui.laydate;

        laydate.render({
			elem: '#addtime',
			format: 'yyyy-MM-dd'
		});
		laydate.render({
			elem: '#endtime',
			format: 'yyyy-MM-dd'
		});
    });
}
var forms = new Array();
$(function(){
	$('#forms > form').find('input').each(function(a,b){
		forms[$(this).attr('name')] = $(this).val();
	});
});