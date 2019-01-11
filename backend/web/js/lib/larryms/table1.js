/**
 * @name 列表
 */
var cid = new Array(),cis=0,dbj=null;
layui.define(['form','table'],function(exports){
  "use strict";
  var table = layui.table
  ,form = layui.form;
  dbj = ondan();
  if("undefined" == typeof dbj){
	  dbj = {};
  }
  table.render(dbj);
  
  /*监听锁定操作*/
  form.on('checkbox(lockDemo)', function(obj){
	  layer.tips(this.value + ' ' + this.name + '：'+ (obj.elem.checked?'启用':'停用'), obj.othis);
	  var vid = $(this).attr('lay-val');
	  var vsa = obj.elem.checked?1:0;
	  if(Zi.isNull(vid)){
		  upStatus(vid,vsa,null);
	  }
  });
  
  /*监听工具条*/
  table.on('tool(demo)', function(obj){
    var data = obj.data;
    if(obj.event === 'detail'){
      layer.msg('ID：'+ data.id + ' 的查看操作');
    } else if(obj.event === 'del'){
      layer.confirm('真的删除行么', function(index){
        obj.del();
        layer.close(index);
      });
    } else if(obj.event === 'edit'){
    	reset();
    	$.ajax({
            url: dbj.contr + 'edit',
            type: 'post',
            data: data,
            success: gosuss
        });
    } else if(obj.event === 'lname'){
    	cid[data.id] = data.cat_id;
    	goReload(data.id);
    }else if(obj.event === 'addv'){
    	reset();
    	gadd(data);
    }
  });
  
  var $ = layui.$, active = {
		  reload: function(){
		      table.reload('idTest', {
		        page: { curr: 1 }
		        ,where: Zi.toJson($('#sForm'))
		      });
		  }
  };
  /* 搜索 */
  $('form#sForm').on('beforeSubmit', function (e) {
	  var type = $('#sForm .layui-btn').data('type');
	  active[type] ? active[type].call(this) : '';
      return false;
  }).on('submit', function (e) {
      e.preventDefault();
  });
  /* 编辑&列表切换*/
  $('#adds').click('on',function(){
	  reset();
	  gadd(cis);
  });
  $('#goupt').click('on',function(){
	  $('#listo').show();
	  $('#addo').hide();
  });
  
  /*多级分类试重置列表*/
  $('#goup').click('on',function(){
	  goReload(cid[cis]);
  });
  function goReload(ci){
		var surl = dbj.url.split('?');
		var $froms = $('#sForm');
		cis = ci;
		$froms.get(0).reset();
		if(ci > 0){
			$('#goup').show();
		}else{
			$('#goup').hide();
		}
		table.reload('idTest', {
			url: surl[0] + '?cid=' + ci
	        ,page: { curr: 1 }
	    	,where: Zi.toJson($froms)
	    });
  }
  /*重置*/
  function reset(){
	  if($('#reset').length > 0){
		  $('#reset').click();
	  }
  }
  /*重置*/
  function gadd(d){
	  goadds(d);
	  $('#addo').show();
	  $('#listo').hide();
  }
  /* 表单提交-一般模式 */
  $('form#eForm').on('beforeSubmit', function (e) {
	if(Zi.isOk() === true){
		return false;
	}
    var $form = $(this);
    $.ajax({
        url: $form.attr('action'),
        type: 'post',
        data: $form.serialize(),
        success: function (d) {
            if(Zi.isNull(d.status)){
            	if(Zi.isNull(d.url)){
            		Zi.stoHrefOf(d.url,1,d.msg);
            	}else{
            		layer.msg(d.msg, {icon: d.status});
            	}
            }else if(Zi.isNull(d[0])){
            	layer.msg(d[0], {icon: 0});
            }else{
            	layer.msg('系统异常', {icon: 3});
            }
            Zi.sub = false;
        },
        beforeSend:function(d){
        	Zi.sub = true;
        }
    });
    return false;
  }).on('submit', function (e) {
    e.preventDefault();
  });
	
  exports('table1', {}); 
});
/*检查编辑方法是否存在*/
if(typeof gosuss !== 'function'){
  function gosuss(d){
	  Zi.resuss(d.data);
  }
}
/*检查添加初始化方法是否存在*/
if(typeof goadds != 'function'){
  function goadds(d){
	  return false;
  }
}