<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
    if(window.top!==window.self){window.top.location=window.location};
</script>
<style>
.help-block{height: 10px;}
.field-loginform-password .help-block{margin:0;}
#loginform-password{margin-bottom:5px}
body.signin .layui-layer{color:#676a6c;}
</style>
<div class="signinpanel">
    <div class="row">
        <div class="col-sm-7">
            <div class="signin-info">
                <div class="logopanel m-b">
                    <h1>欢迎到登录</h1>
                </div>
                <div class="m-b"></div>
                <!-- <h4>欢迎使用 <strong>H+ 后台主题UI框架</strong></h4>
                <ul class="m-b">
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势一</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势二</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势三</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势四</li>
                    <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 优势五</li>
                </ul>
                <strong>还没有账号？ <a href="#">立即注册&raquo;</a></strong> -->
            </div>
        </div>
        <div class="col-sm-5">
            <?php $form = ActiveForm::begin([
                'id' => 'form1',
                'action' => '/site/login',
            	'fieldConfig'=>['template'=> "{input}{error}"]
            ]); ?>
                <h4 class="no-margins">登录系统</h4>
                <!-- <p class="m-t-md">登录到H+后台主题UI框架</p> -->
                <?= $form->field($model, 'username')->textInput([
		 	                 'autofocus' => true,
		 	                 'class' => 'form-control uname',
		 	                 'placeholder' => '用户名',
		 	             ]) ?>
		 	    <?= $form->field($model, 'password')->passwordInput([
		 	                 'class' => 'form-control pword m-b',
		 	                 'placeholder' => '密码',
		 	             ]) ?>
              <INPUT name="LoginForm[rememberMe]" type="hidden" value="1">
                <button class="btn btn-success btn-block">登录</button>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="signup-footer">
        <div class="pull-left">
            &copy; 2015 All Rights Reserved. Yhr
        </div>
    </div>
</div>