var Zi = null;
$(function(){
	var Zm = (function(window) {
		var Zm = function(name) {
			return new Zm.fn.init(name);
		}
		
		Zm.fn = Zm.prototype = {
			constructor: Zm,
			init: function(name) {
				this.name = name;
				this.sub= false;
				
				/*验证为空*/
				this.isNull = function(v){
					if(v==""||v==undefined||v==null){
						return false;
					}
					return true;
				};
				/*定时跳转*/
				this.stoHref = function(u,t){
					setTimeout("location.href='"+u+"';",t*1000);
				};
				
				/* 选择跳转 */
				this.stoHrefOf = function(u,t,s,x){
					/* layer.confirm(s+'是否要查看列表？', {
					  btn: ['查看列表', '继续操作']
					}, function(index, layero){
						location.href = u;
					}, function(index){
					}); */
				
					layer.open({
						content: s+'是否要查看列表？'
						,shadeClose: true
						,btn: ['查看列表', '继续操作']
						,yes: function(index){
						  	/* 查看列表 */
							location.href = u;
						}, no: function(){
							/* 继续操作 */
							if(x){
					        	location.href = location.href;
					        }
					    }

					});
				
				
				}
				/* 指定跳转 */
				this.addHref = function(_t,u){
					var id = this.getId(_t,u);
					if(id != false){
						location.href = u+'&id='+id.val();
					}
				}
				/* 获取操作id */
				this.getId = function(_t,u){
					var id = _t.parents('tr').find('.id');
					
					if(this.isNull(id.val()) === false || this.isNull(u) === false){
						/* layer.msg('跳转失败！', {icon: 0}); */
						layer.open({
						  style: 'border:none; background-color:#fff; color:#f00;',
						  content:'跳转失败！'
						})
						return false;
					}
					return id;
				}
				/* 防重复提交 */
				this.isOk = function(){
					if(this.sub){
						/* layer.msg('已有提交在请求！', {icon: 0}); */
						layer.open({
						  style: 'border:none; background-color:#fff; color:#f00;',
						  content:'已有提交在请求！'
						})
					}
					return this.sub;
				}
				/*获取url参数*/
				this.urlVal = function(ks){
					var reg = new RegExp("(^|&)"+ks+"=([^&]*)(&|$)","i");
					var r   = window.location.search.substr(1).match(reg);
					if(r != null){
						return unescape(r[2]);
					}else{
						return null;
					}
				}
				this.toJson = function(f)
				{
				    var o = {};
				    var a = f.serializeArray();
				    $.each(a, function() {
				        if (o[this.name] !== undefined) {
				            if (!o[this.name].push) {
				                o[this.name] = [o[this.name]];
				            }
				            o[this.name].push(this.value || '');
				        } else {
				            o[this.name] = this.value || '';
				        }
				    });
				    return o;
				};
				this.resuss = function(d)
				{
					$.each(d,function (a,b){
						var _t = '#'+dbj.models+'-'+a;
						if($(_t).length > 0){
							_t = $(_t);
							var nv = _t[0].tagName;
							var nt = _t[0].type;
							if(nv == 'INPUT'){
								if(nt == 'text' || nt == 'hidden'){
									_t.val(b);
								}else if(nt == 'radio'){
									
								}
							}else if(nv == 'TEXTAREA'){
								_t.val(b);
							}else if(nv == 'SELECT'){
								_t.val(b);
								var sel = _t.next('div').find('dl');
								$.each(sel.find('dd'),function (i,j){
									var val = $(this).attr('lay-value');
									if(val == b){
										$(this).click();
									}
								});
							}else if(nv == 'DIV'){
								var inp = _t.find('input');
								$.each(inp,function (i,j){
									var int = this.type;
									if(int == 'radio' && b == this.value){
										$(this).next('div').click();
									}
								});
							}
						}
					});
					
					$('#addo').show();
					$('#listo').hide();
				}
				
			},
			makeArray: function() {
				console.log(this.name);
			}
		}
		
		Zm.fn.init.prototype = Zm.fn;
		return Zm;
	})();
   Zi = new Zm();
   
   /* 表单提交-一般模式 */
	$('form#form1').on('beforeSubmit', function (e) {
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
               		if(d.status == 6){
               			/* layer.msg(d.msg, {icon: 1}); */
						layer.open({
						  style: 'border:none; background-color:#fff; color:#40AFFE;',
						  content:d.msg
						})
               			Zi.stoHref(d.url,1);
               		}else{
               			Zi.stoHrefOf(d.url,1,d.msg,(Zi.isNull(d.sx)?true:false));
               		}
               	}else{
					/* layer.msg(d.msg, {icon: d.status}); */
               		layer.open({
					  style: 'border:none; background-color:#fff; color:#f00;',
					  content:d.msg
					})
               	}
               }else if(Zi.isNull(d[0])){
					/* layer.msg(d[0], {icon: 0}); */
					layer.open({
					  style: 'border:none; background-color:#fff; color:#40AFFE;',
					  content:d[0]
					})
               }else{
					/* layer.msg('系统异常', {icon: 3}); */
				    layer.open({
					  style: 'border:none; background-color:#fff; color:#f00;',
					  content:'系统异常'
					})
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
});