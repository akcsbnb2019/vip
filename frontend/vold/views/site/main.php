<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--Logo区域开始-->
<div id="header">
    <img src="/pc/images/logo.png" alt="logo" class="left" />
</div>
<!--Logo区域结束-->
<!--导航区域开始-->
<div class="navi">
    <div class="menu">
        <div class="menu_nav">
        	<a href="/news/index" target="content"><img src="/pc/images/index.png"></a>
        </div>
        <div class="menu_nav">
        	<a href="/user/index" target="content"><img src="/pc/images/user.png"></a>
        </div>
        <div class="menu_nav">
        	<a href="/news/index" target="content"><img src="/pc/images/gonggao.png"></a>
        </div>
        <div class="menu_nav2">
            <a href="javascript:;"><img src="/pc/images/xinxi.png"></a>
            <div class="submenu1" style="left:-50px;width:<?=$news['width']?>px;">
                <ul class="submenu" style="left:0px;width:<?=$news['width']?>px;">
                    <li><a href="/user/edit" target="content">资料修改</a></li>
                    <?php if($news['exchange']==1):?>
                        <li><a href="/weltare/exchange" target="content">福利积分兑换</a></li>
                    <?php endif;?>

                    <li><a href="/weltare/list" target="content">福利兑换记录</a></li>
                    <?php if($news['stock']>0):?>
                        <li><a href="/weltare/stockslog" target="content">分红记录</a></li>
                    <?php endif;?>
                    <?php if($news['checkdl']==1):?>
                        <li><a href="/weltare/checkdl" target="content">申请代理商</a></li>
                    <?php endif;?>
                </ul>
        	</div>
        </div>
        <div class="menu_nav2">
        	<a href="javascript:;"><img src="/pc/images/tupu.png"></a>
            <div class="submenu2">
                <ul class="submenu">
                <li><a href="/atlas/invite" target="content">邀请图谱</a></li>
                <li><a href="/atlas/user" target="content">会员图谱</a></li>
                </ul>
            </div>
        </div>
        <div class="menu_nav2">
            <a href="javascript:;"><img src="/pc/images/jifen.png"></a>
            <div class="submenu3">
                <ul class="submenu">
                <li><a href="/integral/record" target="content">积分记录</a></li>
                <li><a href="/integral/details" target="content">积分明细</a></li>
                <li><a href="/funds/lovefund" target="content">爱心基金</a></li>
                <li><a href="/funds/transfer" target="content">会员转账</a></li>
                <li><a href="/funds/record" target="content">转账记录</a></li>
                <li><a href="/integral/extract" target="content">积分提现</a></li>
                <li><a href="/integral/exchange" target="content">积分兑换</a></li>
                <li><a href="/integral/exlist?t=0" target="content">未完成兑换记录</a></li>
                <li><a href="/integral/exlist?t=1" target="content">已完成兑换记录</a></li>
                <li><a href="/integral/exlist?t=8" target="content">兑换到商城记录</a></li>
                </ul>
            </div>
        </div>
        <div class="menu_nav2">
            <a href="javascript:;"><img src="/pc/images/liuyan.png"></a>
            <div class="submenu4">
                <ul class="submenu">
                <li><a href="/message/list" target="content">问题列表</a></li>
<!--                <li><a href="/message/sent" target="content">已解决问题</a></li>-->
                <li><a href="/message/send" target="content">发送问题</a></li>
                </ul>
            </div>
        </div>
        <div class="menu_nav">
        	<?= Html::beginForm(['/user/logout'], 'post',['id' => 'logout']).Html::endForm() ?>
        	<a id="btnLogout" href="javascript:;" target="_top" hidefocus="true"><img src="/pc/images/exit.png"></a>
        </div>
	</div>
</div>
<div class="clearfix"></div>

<!--导航区域结束-->
<!--主要区域开始-->
<div id="main">
	<table cellpadding="0" cellspacing="0" >
    	<tr>
    		<td id="title" height="40" align="center">欢迎登录<span class="red"><?= Yii::$app->session->get('loginname');?></span>，您的姓名：<span class="red"><?= Yii::$app->session->get('uip');?></span>，编号：<span class="red"><?= Yii::$app->session->get('__id');?></span>&nbsp;</td>
    	</tr>
        <tr>
            <td>
            <table cellpadding="0" cellspacing="0">
                <tr height="50" align="center">
            
                <td width="174" align="right"><a href="/user/edit" target="content"><img src="/pc/images/edit.png"></img></a></td>
                <td width="113" align="left" class="blue bold"><a href="/user/edit" target="content">资料修改</a></td>
                <td width="61" align="right"><a href="/integral/details" target="content"><img src="/pc/images/detail.png"></img></a></td>
                <td width="134" align="left" class="blue bold"><a href="/integral/details" target="content">积分明细</a></td>
                <td width="40" align="right"><a href="/atlas/user" target="content"><img src="/pc/images/map.png"></img></a></td>
                <td width="108"align="left" class="blue bold"><a href="/atlas/user" target="content">会员图谱</a></td>
                <td width="53" align="right"><a href="/integral/exchange" target="content"><img src="/pc/images/change.png"></img></a></td>
                <td width="225" align="left" class="blue bold"><a href="/integral/exchange" target="content">积分兑换</a></td>
                </tr>
                </table>
            </td>
        </tr>
    </table>
    <iframe src="/news/index" frameborder="0" scrolling="auto" width="100%" height="600" id="content" name="content"></iframe>
</div>
<!--主要区域结束-->
<div class="clearfix"></div>
<script  language="JavaScript" src="/pc/js/init.js"></script>
<script>
iframeResize("content","content");
</script>