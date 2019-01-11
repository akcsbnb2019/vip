/**
 * @name 后台主框架
 */
layui.define(['jquery','form','larryTab','larry'],function(exports){
    var $ = layui.$,
        form = layui.form,
        larryTab = layui.larryTab({
        	tab_elem:'#larry_tab',
            tabMax:30
        }),
        layer = layui.layer,
        larry = layui.larry,
        larryms = layui.larryms;
    //菜单初始化
    larryTab.menuSet({
        type:'GET',
        url:layui.cache.menusUrl,
        left_menu:'#larryms_left_menu',
        leftFilter:'LarrySide'
    });
    larryTab.menu();
    
    if(larryTab.config.tabSession){
        larryTab.session(function(session){
             if(session.getItem('tabMenu')){
                 $('#larry_tab_title li.layui-this').trigger('click');
             }
        });
    }
    
    // 菜单折叠
    $('#menufold').on('click',function(){
         if($('#larry_layout').hasClass('larryms-fold')){
             $('#larry_layout').addClass('larryms-unfold').removeClass('larryms-fold');
             $(this).children('i').addClass('larry-fold7').removeClass('larry-unfold');
         }else{
             $('#larry_layout').addClass('larryms-fold').removeClass('larryms-unfold');
             $(this).children('i').addClass('larry-unfold').removeClass('larry-fold7');
         }
    });
    // 主题设置
    $('#larryTheme').on('click',function(){
          var index = layer.open({
          	   type:1,
          	   id:'larry_theme_R',
          	   title:false,
          	   anim: -1,
          	   offset: 'r',
          	   closeBtn:false,
          	   shade:0.2,
          	   shadeClose: true,
          	   skin:'layui-anim layui-anim-rl larryms-layer-right',
          	   area: '320px',
          	   success:function(){

          	   },
          });
    });
    
 // 登出系统
    $('#logout').on('click', function () {
    	layer.confirm('你真的确定要退出系统吗？', {
		  title: '退出登陆提示',
		  btn: ['确定','取消'],
		}, function(){
			$.get("/site/logouts", function(r){
				location.reload();
            });
		}, function(){
		});
    })

    // 浏览器宽高变化 临时 后续版本中完善
    $(window).on('resize', function() {
      var width = $(window).width();
      if(width>=1200){
        $('#larry_layout').removeClass('larryms-mobile-layout');
        $('#larry_layout').addClass('larryms-unfold').removeClass('larryms-fold');
                $('#menufold').children('i.larry-icon').addClass('larry-fold7').removeClass('larry-unfold');
      }else if (width > 767 && width <1200) {
        $('#larry_layout').removeClass('larryms-mobile-layout');
        $('#larry_layout').addClass('larryms-fold').removeClass('larryms-unfold');
        $('#menufold').children('i.larry-icon').addClass('larry-unfold').removeClass('larry-fold7');
      } else if (width <= 767 && width > 319) {
        $('#larry_layout').removeClass('larryms-fold');
        $('#larry_layout').removeClass('larryms-unfold');
      } else if (width <= 319) {
        larryms.error('你丫的别拖了，没有屏幕宽度小于320的，布局会乱的！', larryms.tit[1]);
      }
      // 移动端屏幕下iframe高度随子页面内容只适应滚动，但min-height填充空白区域，移动端下关闭tab选项卡
    }).resize();
    exports('index',{});
});