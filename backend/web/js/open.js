var parentId='',prid=null,sxPage=0,sxTime=0;
var Urs = Urs || '';
var addU = addU || '';
var editU = editU || '';
$(function(){
	layui.cache.page = 'demo';
	if($('#actions').length > 0){
		var action = $('#actions').val();
		if(action == 'login' && window != top){
	        sessionStorage.clear();
	        top.location.href = location.href;
		}
		if(action == 'index'){
			layui.cache.menusUrl = '/index/menudatas';
		}
		layui.cache.page = action;
	}
	
    layui.config({
       version:"2.0.7",
       base:'/'  //实际使用时，建议改成绝对路径
    }).extend({
        larry:'js/base'
    }).use('larry');
    
    
    if(isParent === true && typeof(parent.navtab) != 'undefined'){
		parentId = parent.navtab.getCurrentTabId();
		prid = urlVal('prid');
	}
});

/* 定时跳转 */
function stoHref(url,time){
	setTimeout("location.href='"+url+"';",time*1000);
}

/* 选择跳转 */
function stoHrefOf(url,time){     
	layer.confirm('是否要返回列表？', {
	  btn: ['返回列表', '继续操作']
	}, function(index, layero){
		$('#golist').click();
		if(isNull(url) !== false){
			location.href = url;
		}
	}, function(index){
	});
}

/* 指定跳转 */
function addHref(_this,url){
	var id = getId(_this,url);
	if(id != false){
		location.href = url+'&id='+id.val();
	}
}

/* 操作父页面打开新页面 */
var isParent = true;
function parentHref(_this,url,title){
	var val= '';
	if(_this !== false){
		var id = getId(_this,url);
		if(id === false){
			return false;
		}
		var val= '&id='+id.val();
	}
	try{
		if(isParent === false || typeof(parent.navtab) == 'undefined'){
			location.href = url+val;
		}else{
			if(isNull(title) === false){
				title = '编辑 - '+url+val;
			}
			var urls = url+val;
			urls += (urls.indexOf('?') > 0 ?'&':'?')+'prid='+parentId;
			parent.navtab.tabAdd({'title':title,'href':urls,'icon':'larry-fabu2'});
		}
		return true;
	}catch(e){}
}

/* 打开弹窗 */
function layOpen(_this,url){
	var id = getId(_this,url);
	if(id != false){
		layer.open({
	        type: 2,
	        title: 'title',
	        shadeClose: true,
	        shade: false,
	        maxmin: true,
	        area: ['1200px', '600px'],
	        content: url+'&id='+id.val(),
	        success: function(layero, index){
	        }
	    });
	}
}

/* 获取操作id */
function getId(_this,url){
	var id = _this.parents('tr').find('.id');
	
	if(isNull(id.val()) === false || isNull(url) === false){
		layer.msg('跳转失败！', {icon: 0});
		return false;
	}
	return id;
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
	if(status == 2){/*删除会员显示遮罩层*/
		var loading = layer.load(1, {
			content: '执行中...',
			shade: [0.4, '#393D49'],
			success: function(layero) {
			layero.css('padding-left', '30px');
			layero.find('.layui-layer-content').css({
			'padding-top': '40px',
			'width': '70px',
			'background-position-x': '16px'
			});}
		});
	}
	
	$.ajax({
		type: 'post',
		url: url,
		dataType : "json",
		data: {'_csrf-backend':$("#forms input[name='_csrf-backend']").val(),'ids': ids,'status':status},
		success: function(d) {
			if(status == 2){
				layer.close(loading);
			}
			var msgs = Zi.isNull(d.msg)?d.msg:d.m;
			var stas = Zi.isNull(d.status)?d.status:d.s;
			if(Zi.isNull(d.status)){
				layer.msg(msgs, {icon: 1});
				isSub = false;
			}else if(stas === 1){
				layer.msg(msgs, {icon: 1});
				if(typeof(num) == 'undefined'){
					stoHref(location.href,1);
				}else{
					isSub = false;
					$('#page .layui-laypage-btn').click();
				}
			}else{
				layer.msg(msgs, {icon: 0});
				isSub = false;
			}
        },
        beforeSend:function(d){
        	isSub = true;
        }
	});
}
/*导出*/
function importdata()
{
	var url=window.location.host;
	if(url.indexOf("http://")==-1){	
		url="http://"+url;
	}
	url+='//withdraw/importdata?';
	url+='s='+$("#forms input[name='s']").val();
	url+='&s1='+$("#forms select[name='s1']").val();
	url+='&begtime='+$("#forms input[name='begtime']").val();
	url+='&endtime='+$("#forms input[name='endtime']").val(); 
	
	window.open(url, '_blank');  
}
function inifun(){
	
    $('#lists #add').click('on',function(){
    	addHref($(this),addU);
    });
    $('#lists #edit').click('on',function(){
    	if(typeof(laypage) == 'undefined' ){
    		addHref($(this),editU);
    	}else{
    		parentHref($(this),editU,$(this).attr('title'));
        	if(isParent){
        		sxPage += 1;
            	if(sxTime == 0){
            		sxTime = 50;
            		setTimeout("sxList();",5000);
            	}
        	}
    	}
    });
    $('#golist').click('on',function(){
    	if(parentId != '' && prid != null){
    		parent.navtab.setCurrentTabId(prid);
    		parent.navtab.deleteTab(parentId);
    	}else{
    		stoHref($(this).attr('alt'),0.3);
    	}
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
    $('#lists #del,#lists #up1,#lists #deluser,#lists #up2').click('on',function(){
		var id = $(this).parents('tr').find('.id').val();
		
		if(isNull(id) === false){
			layer.msg('更新失败！', {icon: 0});
		}
		var s = 0;
		if($(this).attr('id') == 'del'){
			s = -1;
		}else if($(this).attr('id') == 'up2'){
			s = 1;
		}else if($(this).attr('id') == 'deluser' ){
			s = 2;/*删除会员用*/
		}
		upStatus(id,s,null);
    });
    /*导出*/
    $("#import").click('on',function(){
    	importdata();
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
/*获取url参数*/
function urlVal(ks){
	var reg = new RegExp("(^|&)"+ks+"=([^&]*)(&|$)","i");
	var r   = window.location.search.substr(1).match(reg);
	if(r != null) return unescape(r[2]);return null;
}
/*编辑内容时定时刷新是否需要更新列表*/
function sxList(){
	
	if(parent.navtab.ajaxPage > 0){
		if(sxPage > 0){
			$("#lists .id").each(function(a,b){
	    		if(b.value == parent.navtab.ajaxPage){
	    			$('#page .layui-laypage-btn').click();
	            }
	  	  	});
		}
		parent.navtab.ajaxPage = 0;
	}
	if(sxTime > 0){
		--sxTime;
		setTimeout("sxList();",3000);
	}
}