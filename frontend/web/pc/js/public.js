/* 定时跳转 */
function stoHref(url,time){
	setTimeout("location.href='"+url+"';",time*1000);
}

/* 选择跳转 */
function stoHrefOf(url,time){     
	layer.confirm('是否要返回列表？', {
	  btn: ['返回列表', '继续操作']
	}, function(index, layero){
		location.href = url;
	}, function(index){
	});
}

/* 指定跳转 */
function addHref(_this,url){
	var id = _this.parents('tr').find('.id').val();

	if(isNull(id) === false || isNull(url) === false){
		layer.msg('跳转失败！', {icon: 0});
	}
	
	location.href = url+'&id='+id;
}

/* 防重复提交 */
var isSub = false;
function isOk(){
	if(isSub){
		layer.msg('已有提交在请求！', {icon: 0});
	}
	return isSub;
}

/* 是否为空 */
function isNull(val){
	if(val==""||val==undefined||val==null){
		return false;
	}
	return true;
}

/* 变更状态 */
function upStatus(ids,status,url){
	if(isNull(ids) === false){
		layer.msg('没有可操作项！', {icon: 0});
	}
	
	/* 确定Url */
	if(isNull(url) === false){
		if(isNull(window.location.pathname) === false){
			layer.msg('操作异常！', {icon: 0});
		}
		var urlarr = window.location.pathname.split('/');
		url = '/'+urlarr[1]+'/upstatus'
	}
	
	if(isOk() === true){
		return false;
	}
	
	$.ajax({
		type: 'post',
		url: url,
		dataType : "json",
		data: {'_csrf-backend':$("#forms input[name='_csrf-backend']").val(),'ids': ids,'status':status},
		success: function(d) {
			if(d.s === 1){
				layer.msg(d.m, {icon: 1});
				isSub = false;
				$('#page .layui-laypage-btn').click();
			}else{
				layer.msg(d.m, {icon: 0});
				isSub = false;
			}
        },
        beforeSend:function(d){
        	isSub = true;
        }
	});
}

function deldata(ids,url){
	if(isNull(ids) === false){
		layer.msg('没有可操作项！', {icon: 0});
	}
	/* 确定Url */
	if(isNull(url) === false){
		if(isNull(window.location.pathname) === false){
			layer.msg('操作异常！', {icon: 0});
		}
		var urlarr = window.location.pathname.split('/');
		url = '/'+urlarr[1]+'/del'
	}
	if(isOk() === true){
		return false;
	}
	$.ajax({
		type: 'post',
		url: url,
		dataType : "json",
		data: {'_csrf-backend':$("#forms input[name='_csrf-backend']").val(),'ids': ids},
		success: function(d) {
			if(d.s === 1){
				layer.msg(d.m, {icon: 1});
				isSub = false;
				$('#page .layui-laypage-btn').click();
			}else{
				layer.msg(d.m, {icon: 0});
				isSub = false;
			}
        },
        beforeSend:function(d){
        	isSub = true;
        }
	});
}

var Urs = '',addU = '',editU = '',delU = '';
$(function(){
	/* 初始化事件 */
	statis_on();
});

function statis_on(){
	
    $('#lists #add').click('on',function(){
    	addHref($(this),addU);
    });
    $('#lists #edit').click('on',function(){
    	addHref($(this),editU);
    });
    /* 全选 反选 */
    $('#selected-all').click('on',function(){
        if(this.checked){
        	$("#lists :checkbox").prop("checked", true);
        }else{
        	$("#lists :checkbox").prop("checked", false);
        }
    });
    $("#lists .id:checkbox").click('on',function(){
        var istr = true;
    	$("#lists .id:checkbox").each(function(a,b){
    		if(!this.checked){
    			istr = false;
            }
  	  	});
    	$('#selected-all').prop("checked", istr);
    });
    /* 删除多个 */
    $('#delall').click('on',function(){
        var ids = '';
    	$("#lists .id:checkbox").each(function(a,b){
    		if(this.checked){
    			ids += (ids != '' ? ',' : '')+$(this).val();
            }
  	  	});
    	upStatus(ids,'-1',null);
    });
    /* 指定更新 */
    $('#lists #up1,#lists #up2').click('on',function(){
		var id = $(this).parents('tr').find('.id').val();
		
		if(isNull(id) === false){
			layer.msg('更新失败！', {icon: 0});
		}
		var s = 0;
		if($(this).attr('id') == 'up1'){
			s = -1;
		}else if($(this).attr('id') == 'up2'){
			s = 1;
		}
		upStatus(id,s,null);
    });
    /* 删除 */
    $('#lists #del').click('on',function(){
		var id = $(this).parents('tr').find('.id').val();
		if(isNull(id) === false){
			layer.msg('删除失败！', {icon: 0});
		}
		deldata(id,null);
    });
}

/*.用正则表达式实现html解码*/
function strToHtml(str){  
    var s = "";
    if(str.length == 0) return "";
    s = str.replace(/&amp;/g,"&");
    s = s.replace(/&lt;/g,"<");
    s = s.replace(/&gt;/g,">");
    s = s.replace(/&nbsp;/g," ");
    s = s.replace(/&#39;/g,"\'");
    s = s.replace(/&quot;/g,"\"");
    return s;  
}
/*.用正则表达式实现html转码*/
function htmlToStr(str){  
    var s = "";
    if(str.length == 0) return "";
    s = str.replace(/&/g,"&amp;");
    s = s.replace(/</g,"&lt;");
    s = s.replace(/>/g,"&gt;");
    s = s.replace(/ /g,"&nbsp;");
    s = s.replace(/\'/g,"&#39;");
    s = s.replace(/\"/g,"&quot;");
    return s;  
}