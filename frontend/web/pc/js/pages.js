//启用模块
var laypage;
layui.use(['laypage'], function(){
	laypage = layui.laypage;
  	laypage({
		cont: 'demo2',
		pages: num,
		curr: page,
		skin: '#1E9FFF',
		whereid : whereid,
		jump: hrefs
	});
  	
});

/* 分页跳转 */
function hrefs(obj, first){
	if(!first){
		if(obj.whereid!=""){
            location.href = '?tab=all&page=' + obj.curr + '&id='+obj.whereid;
        }else{
            location.href = '?tab=all&page=' + obj.curr;

        }
	}
}