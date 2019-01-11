/**
 * @Title: LarryMS tree扩展 基于layui tree基础上进行
 * @Date: 2017-12-15
 * @Site: www.larrycms.com
 * @Author: Larry 在（贤心的基础上扩展的tree插件）
 * @QQ号：313492783
 * @QQ群号码：290354531
 * @Version:larryMS2.08
 * @Last Modified time: 2017-12-15 09:00:00
 */
layui.define(['jquery'],function(exports){
    "use strict";
	var $ = layui.$,
	    hint = layui.hint();
    
    var Tree = function(options){
       this.options = options;
       this.data = 'larryms';
    },
       enterSkin = 'larry-tree-enter';
    // 常用图标
    var icon = {
        arrow: ['larry-icon-up','larry-icon-up1'],//折叠箭头
        checkbox: ['larry-fuxuankuang','larry-fuxuankuang1'],//复选框
        radio:['larry-radio','larry-danxuankuangxuanzhong-copy'],//单选框
        branch:[],//父节点
        leaf:[]//叶节点
    };
    // 初始化
    Tree.prototype.init = function(elem){
         var that = this;
         elem.addClass('larry-box larry-tree');
         if(that.options.skin){
         	elem.addClass('larry-tree-skin-'+that.options.skin);
         }
         that.tree(elem);
         // that.on(elem);
    };
    Tree.prototype.handling = function(targetData){
    	var that = this;
    	if(targetData !== undefined && typeof(targetData) === 'string'){
    		$.ajax({
    			type:'POST',
    			url:targetData,
    			async:false,
    			dataType:'json',
    			success:function(result,status,xhr){
                      that.data = result;
    			},error:function(xhr,status,error){
                   	  hint.error('数据源读取出错');
                }
    		});
    	}else if(targetData !== undefined && typeof(targetData) === 'object'){
    		 that.data = targetData;
    	}else{
    		return 'error';
    	}
    };
    // 树节点解析
    Tree.prototype.tree = function(elem,children){
        var that = this,
            options = that.options,
            data = children || options.url || options.data;
        if(that.handling(data) !== 'error'){
        	var nodes = that.data;
        }
        //是否显示顶部层级
        var top = $([function(){
                   return options.top ? '<li class="larry-this" data-top="top">'+options.top+'</li>' : '';
                }()].join(''));
            elem.append(top);
        layui.each(nodes,function(index,item){
            var hasChild = item.children && item.children.length > 0;
            var li = $(['<li '+ (item.spread ? 'data-spread="'+ item.spread +'"' : '') +'>',
            	// 展开箭头
            	function(){
                    return hasChild ? '<i class="larry-icon '+(
                        item.spread ? icon.arrow[1] : icon.arrow[0]
                    ) +' larry-tree-spread"></i>' : '|--';
            	}(),
            	//复选框/单选框
            	function(){
                  return options.check ? (
                    '<i class="larry-icon '+ (
                      options.check === 'checkbox' ? icon.checkbox[0] : (
                        options.check === 'radio' ? icon.radio[0] : ''
                      )
                    ) +' larry-tree-check"></i>'
                  ) : '';
                }(), 
                // 节点
                function(){
                   return ''+
                   '<i class="larry-icon '+item.icon+'"></i>'+        
                   ('<cite>'+(item.title || '未命名')+'</cite>')
                }(),'</li>'].join(''));


              console.log(item);
             
            elem.append(li);
        });
        
    };
 
    exports('larryTree',function(options){
         var larryTree =  new Tree(options = options || {}),
             elem = $(options.elem);
         if(!elem[0]){
         	 return hint.error('larryTree 没有找到'+options.elem+'元素');
         }
         larryTree.init(elem);
    });
});