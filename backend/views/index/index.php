<?php

/* @var $this yii\web\View */

$co = yii::$app->params['co'];

$this->title = $co['sysName'];
?>
<div class="layui-layout layui-layout-admin layui-fluid larryms-layout" id="larry_layout">
	<!-- 顶部导航 -->
	<div class="layui-header larryms-header" id="larry_head">
        <div class="larryms-topbar-left" id="topbarL">
        	<span class="mini-logo"><img src="/images/logo_mini.png" alt=""></span>
         	<a class="layui-logo larryms-logo"><?= $co['name']; ?></a>
         	<span class="larryms-switch larryms-icon-fold" id="menufold"><i class="larry-icon larry-fold7"></i></span>
         	<div class="larryms-mobile-menu" id="larrymsMobileMenu"><i class="larry-icon larry-caidan1"></i></div>
        </div>
        <div class="larryms-extend">
         	<div class="larryms-topbar-menu larryms-hide-xs clearfix">
         	    <ul class="larryms-nav clearfix fl" id="larryms_top_menu" lay-filter='TopMenu'>
         	    	 <!-- 若开启顶部菜单，此处动态生成 -->
         	    </ul>
         	    <div class="dropdown extend-show" id="larryms_topSubMenu">
         	    	 <i class="submenubtn larry-icon larry-sandianshu" id="subMenuButton"></i>
         	    	 <ul class="dropdown-menu larryms-nav" id="dropdown">
         	    	 	
         	    	 </ul>
         	    </div>
            </div>
            <!-- 右侧常用菜单 -->
            <div class="larryms-topbar-right" id="topbarR">
            	<ul class="layui-nav clearfix">
                    <!-- <li class="layui-nav-item" lay-unselect>
                        <a id="lock"><i class="larry-icon larry-diannao1"></i><cite>锁屏</cite></a>
                    </li> -->
                    <li class="layui-nav-item" lay-unselect>
                        <a id="clearCached"><i class="larry-icon larry-qingchuhuancun1"></i><cite>缓存</cite></a>
                    </li>
                    <!-- <li class="layui-nav-item" lay-unselect>
                        <a id="larryTheme"><i class="larry-icon larry-zhutishezhi-"></i><cite>主题</cite></a>
                    </li> -->
            		<li class="layui-nav-item exit" lay-unselect>
                        <a id="logout"><i class="larry-icon larry-exit"></i><cite>退出</cite></a>
                    </li>
            	</ul>
            </div>
        </div>
	</div>
	<!-- 内容主体 -->
	<div class="larryms-body" id="larryms_body">
		<!-- 左侧导航区域 -->
		<div class="layui-side pos-a larryms-left layui-bg-black" id="larry_left">
			<div class="layui-side-scroll">
                <!-- 管理员信息      -->
                <div class="user-info">
                    <div class="photo">
                        <img src="/images/user.jpg" alt="">
                    </div>
                    <p><?= Yii::$app->session->get('uname'); ?></p>
                </div>
                <!-- 系统菜单 -->
                <div class="sys-menu-box" >
                    <ul class="larryms-nav larryms-nav-tree" id="larryms_left_menu" lay-filter="LarrySide" data-group='0'>
                        <!-- 此次动态生成 -->
                    </ul>
                </div>    
			</div> 
		</div>
		<!-- 右侧框架内容区域 -->
		<div class="layui-body pos-a larryms-right" id="larry_right">
			<div class="layui-tab larryms-tab" id="larry_tab" lay-filter="larryTab">
                <div class="larryms-title-box clearfix" id="larryms_title">
                    <div class="larryms-btn-default larryms-press larryms-pull-left hide" id="goLeft"><i class="larry-icon larry-top-left-jt"></i></div> 
                    <ul class="layui-tab-title larryms-tab-title" lay-allowclose='false' id="larry_tab_title" lay-filter='larrymsTabTitle'>
                        <li class="layui-this" id="larryms_home" lay-id="0" data-group="0" data-id="larryms-home" fresh="1" data-url="html/main1.html">
                            <i class="larry-icon larry-shouye2" data-icon="larry-shouye2" data-font="larry-icon"></i><cite>后台首页</cite>
                        </li>
                    </ul>
                    <div class="larryms-btn-group clearfix">
                        <div class="larryms-btn-default larryms-press larryms-pull-right hide" id="goRight"><i class="larry-icon larry-gongyongshuangjiantouyou"></i></div>
                        <div class="refresh larryms-press" id="larryms_refresh">
                            <i class="larry-icon larry-shuaxin"></i>
                            <cite>刷新</cite>
                        </div>
                        <div class="larryms-press often" lay-filter="larryOperate" id="buttonRCtrl">
                            <ul class="larryms-nav">
                                <li class="larryms-nav-item">
                                    <a class="top"><i class="larry-icon larry-caozuo"></i><cite>常用操作</cite><span class="larryms-nav-more"></span></a>
                                    <dl class="larryms-nav-child layui-anim layui-anim-upbit">
                                        <dd id="tabCtrD">
                                            <a data-ename="positionCurrent"><i class="larry-icon larry-qianjin1"></i><cite>定位当前选项卡</cite></a>
                                        </dd>
                                        <dd id="tabCtrA">
                                            <a data-ename="closeCurrent"><i class="larry-icon larry-guanbidangqianye"></i><cite>关闭当前选项卡</cite></a>
                                        </dd>
                                        <dd id="tabCtrB">
                                            <a data-ename="closeOther"><i class="larry-icon larry-guanbiqita"></i><cite>关闭其他选项卡</cite></a>
                                        </dd>
                                        <dd id="tabCtrC">
                                            <a data-ename="closeAll"><i class="larry-icon larry-close-all"></i><cite>关闭全部选项卡</cite></a>
                                        </dd>
                                        <dd>
                                            <a data-ename="refreshAdmin"><i class="larry-icon larry-kuangjia_daohang_shuaxin"></i><cite>刷新最外层框架</cite></a>
                                        </dd>
                                    </dl>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> 
                <!-- tab title end -->
                <div class="layui-tab-content larryms-tab-content" id="larry_tab_content">
                    <div class="layui-tab-item layui-show">
                        <iframe class="larry-iframe" data-id='0' name="ifr_0" id='ifr0'  src="/index/default" frameborder="no" border="0"></iframe>
                    </div>
                </div>
                <!-- tab content end -->
            </div>
		</div>
		<!-- 移动端支持 -->
		<div class="larryms-mobile-shade" id="larrymsMobileShade"></div>
	</div>
	<!-- 底部固定区域 -->
	<div class="layui-footer larryms-footer" id="larry_footer">
		 <div class="copyright inline-block pos-al">Author larry © <a href="http://<?= $co['www']; ?>" target="_blank"><?= $co['www']; ?></a></div>
         <div class="larryms-info inline-block pos-ar">版本：<span id="larryms_version"><?= $co['ver']; ?></span></div>
	</div>
</div>
<input type="hidden" value="index" id="actions">