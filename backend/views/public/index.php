<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '管理员登录';
?>
	<meta name="keywords" content="<?= Html::encode($this->title) ?>" />
    <meta name="description" content="<?= Html::encode($this->title) ?>" />
    <meta name="Author" content="kml" />
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link rel="Shortcut Icon" href="/favicon.ico" />
	
	<!-- load css -->
	<link rel="stylesheet" type="text/css" href="/common/layui/css/layui.css" media="all">
	<link rel="stylesheet" type="text/css" href="/pc/css/login.css" media="all">
</head>
<body>

<div class="larry-canvas" id="canvas"></div>
<div class="layui-layout layui-layout-login">
	<h1>
		 <strong>管理员登录</strong>
		 <em>用于后台管理</em>
	</h1>
	<?php $form = ActiveForm::begin(['id' => 'login-form','action' => '/public/login']); ?>
	<div class="layui-user-icon larry-login">
		 <input type="text" name="name" id="name" placeholder="账号" class="login_txtbx"/>
	</div>
	<div class="layui-pwd-icon larry-login">
		 <input type="password" name="password" id="password" placeholder="密码" class="login_txtbx"/>
	</div>
    <div class="layui-val-icon larry-login">
    	<div class="layui-code-box">
    		<input type="text" id="code" name="code" placeholder="验证码" maxlength="4" class="login_txtbx">
    		<?php echo Captcha::widget([
    		    'name'=>'captchaimg',
    		    'captchaAction'=>'captchatest',
    		    'imageOptions'=>[
    		        'id'=>'verifyImg',
    		        'class'=>'verifyImg',
    		        'title'=>'换一个',
    		        'alt'=>'换一个',
    		        'onclick'=>"javascript:this.src=this.src+'&v='+Math.random();"
    		      ],
    		    'template'=>'{image}'
    		]); ?>
    	</div>
    </div>
    <div class="layui-submit larry-login">
    	<input type="submit" value="立即登陆" class="submit_btn"/>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="layui-login-text">
    </div>
</div>
<!-- load js -->
<script type="text/javascript" src="/layui/uio/layui.js"></script>
<script type="text/javascript" src="/js/plus/jquery-1.12.4.min.js"></script>
<script src="/js/jquery.form.min.js"></script>
<script src="/js/public.js"></script>
<script type="text/javascript" src="/js/plugin/jparticle.jquery.js"></script>
<script type="text/javascript" src="/js/pc/login.js"></script>
</body>
</html>