/**
 * @name : larryMS主入口
 * @author larry
 * @QQ: 313492783
 * @site : www.larryms.com
 * @Last Modified time: 2017-12-15 09:00:00
 */
var Zi = null;
layui.extend({
   larryms: 'js/lib/larryms',
   larryMenu: 'js/lib/larryMenu',
}).define(['jquery','larryms','larryMenu','layer'],function(exports){
    "use strict";
    var $ = layui.$,
        larryms = layui.larryms,
        larryMenu = layui.larryMenu(),
        device = layui.device();       

   var Admin = function(){
            this.config = {
                icon:'larry',
                url:'//at.alicdn.com/t/font_477590_oo8mowklceuerk9.css',
                online:true
            },
            this.screen = function(){
                var width = $(window).width();
                if(width >=1200){
                    return 4;
                }else if(width >=992){
                    return 3;
                }else if(width >=768){
                    return 2;
                }else{
                    return 1;
                }
            }
    };

    var call = {
         //扩展面板larry-panel
         panel: function(){
            $('.larry-panel .tools').off('click').on('click',function(){
                if($(this).hasClass('larry-unfold1')){
                    $(this).addClass('larry-fold9').removeClass('larry-unfold1');
                    $(this).parent('.larry-panel-header').siblings('.larry-panel-body').slideToggle();
                }else{
                    $(this).addClass('larry-unfold1').removeClass('larry-fold9');
                    $(this).parent('.larry-panel-header').siblings('.larry-panel-body').slideToggle();
                }
            });
            $('.larry-panel .close').off('click').on('click',function(){
                $(this).parents('.larry-panel').parent().fadeOut();
            });
         },
         // 子页面新增tab选项卡到父级窗口
         addTab: function(data){
            // 1、判断子页面是否在iframe框架内或者是否拥有父级ajaxLoad节点：即不支持页面独立窗口打开的新增
            if(window.top !== window.self){
                console.log(top.tab);
                // console.log(top.Tabs);
                top.tab.tabAdd(data);
            }else{
                window.location.href = data.href;
            }
            
         },
         //页面右键菜单
         RightMenu: function(larryMenuData){
              larryMenu.ContentMenu(larryMenuData,{
                   name:'body'
              },$('body'));
              if(top == self){
                   $('#larry_tab_content').mouseenter(function(){
                        larryMenu.remove();
                   });
              }else{
                   $('#larry_tab_content', parent.document).mouseout(function(){
                        larryMenu.remove();
                  });
              }
         }

    };
    Admin.prototype.init = function(){
        var that =this,
            _config = that.config;
            
        larryms.fontset({
            icon: _config.icon,
            url: _config.url,
            online: _config.online
        });
        layui.config({
            base: layui.cache.base + 'js/lib/'
        });
        // 加载特定模块
        if(layui.cache.page){
             layui.cache.page = layui.cache.page.split(',');
             if($.inArray('larry',layui.cache.page) === -1){
                 var extend = {};
                 layui.cache.mods = layui.cache.mods === undefined ? 'larryms' : layui.cache.mods;
                 layui.cache.path = layui.cache.path === undefined ? (layui.cache.mods+'/') : layui.cache.path;
                 for(var i= 0; i<layui.cache.page.length;i++){
                     extend[layui.cache.page[i]] = layui.cache.path+layui.cache.page[i];
                 }
                 layui.extend(extend);
                 layui.use(layui.cache.page);
             }
        }
        //页面右键定义
        if(layui.cache.rightMenu !== false && layui.cache.rightMenu !== 'custom'){
            //默认右键菜单
            call.RightMenu([
                [{
                    text: "刷新当前页",
                    func: function() {
                        if (top == self) {
                            document.location.reload();
                        } else {
                            $('.layui-tab-content .layui-tab-item', parent.document).each(function() {
                                if ($(this).hasClass('layui-show')) {
                                    $(this).children('iframe').attr('src', $(this).children('iframe').attr('src'));
                                }
                            });
                        }
                    }
                }, {
                    text: "重载主框架",
                    func: function() {
                        top.document.location.reload();
                    }
                }, {
                    text: "设置系统主题",
                    func: function() {
                        if (top.document.getElementById('larryTheme') !== null) {
                            top.document.getElementById('larryTheme').click();
                        } else {
                            larryms.error('当前页面不支持主题设置或请登陆系统后设置系统主题', larryms.tit[0]);
                        }
                    }
                }, {
                    text: "选项卡常用操作",
                    data: [
                        [{
                            text: "定位当前选项卡",
                            func: function() {
                                if(top.document.getElementById('tabCtrD') !== null){
                                    top.document.getElementById('tabCtrD').click();
                                }else{
                                    larryms.error('请先登陆系统，此处无选项卡操作', larryms.tit[0]);
                                }
                            }
                        }, {
                            text: "关闭当前选项卡",
                            func: function() {
                                if(top.document.getElementById('tabCtrA') !== null){
                                    top.document.getElementById('tabCtrA').click();
                                }else{
                                    larryms.error('请先登陆系统，此处无选项卡操作', larryms.tit[0]);
                                }
                            }
                        }, {
                            text: "关闭其他选项卡",
                            func: function() {
                                if(top.document.getElementById('tabCtrB') !== null){
                                    top.document.getElementById('tabCtrB').click();
                                }else{
                                    larryms.error('请先登陆系统，此处无选项卡操作', larryms.tit[0]);
                                }
                            }
                        }, {
                            text: "关闭全部选项卡",
                            func: function() {
                                if(top.document.getElementById('tabCtrC') !== null){
                                    top.document.getElementById('tabCtrC').click();
                                }else{
                                    larryms.error('请先登陆系统，此处无选项卡操作', larryms.tit[0]);
                                }
                            }
                        }]
                    ]
                }, {
                    text: "清除缓存",
                    func: function() {
                        top.document.getElementById('clearCached').click();
                    }
                }],
                [{
                    text: "访问官网",
                    func: function() {
                        //top.window.open('');
                    }
                }]
            ]);
        }else if(layui.cache.rightMenu === false){
            larryMenu.remove();
            larryMenu = null;
        }
    };
    //larry-panel
    Admin.prototype.panel = function(){
         call.panel();
    };
   
   Admin.prototype.render = Admin.prototype.init;
   var larry = new Admin();
   larry.render();

   exports('larry',larry);
   
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
				this.stoHrefOf = function(u,t,s){
					layer.confirm(s+'是否要返回列表？', {
					  btn: ['返回列表', '继续操作']
					}, function(index, layero){
						$('#golist,#goupt').click();
						layer.msg('返回...', {icon: 1});
					}, function(index){
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
						layer.msg('跳转失败！', {icon: 0});
						return false;
					}
					return id;
				}
				/* 防重复提交 */
				this.isOk = function(){
					if(this.sub){
						layer.msg('已有提交在请求！', {icon: 0});
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
});
