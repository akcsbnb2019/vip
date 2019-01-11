<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
?>
<div id="app">
  <div class="page">
	<div class="page-content login_bg">
		<div class="lg_logo"><img src="mobile/img/logo.png"/></div>
		<div class="lg_title">会员管理平台</div>
		<?php $form = ActiveForm::begin([
                'id' => 'form1',
                'action' => '/site/login',
				// 'options' => ['class' => 'ajax-submit'],
            	'fieldConfig'=>['template'=> "{input}{error}"]
            ]); ?>
		<div class="list-block">
		  <div class="list lg_list_n inline-labels no-hairlines-md">
		  <ul>
			<li class="item-content item-input lg_ipt">
			  <i class="f7-icons md-only">person</i>
			  <i class="f7-icons ios-only">person</i>
			  <div class="item-inner">
				<div class="item-input-wrap inp">
				<?= $form->field($model, 'username')->textInput([
				    'autofocus' => true,
				    'class' => '',
				    'placeholder' => '用户名',
				]) ?>
				</div>
			  </div>
			</li>
			<li class="item-content item-input lg_ipt">
			  <i class="f7-icons md-only">lock</i>
			  <i class="f7-icons ios-only">lock</i>
			  <div class="item-inner">
				<div class="item-input-wrap inp">
				<?= $form->field($model, 'password')->passwordInput([
					'class' => '',
					'placeholder' => '密码',
				]) ?>
				</div>
			  </div>
			</li>
			</ul>
		  </div>
		</div>
		<INPUT name="LoginForm[rememberMe]" type="hidden" value="1">
		<button class="col button button-raised button-fill lg_dl">登录</button>
		<?php ActiveForm::end(); ?>
	</div>
  </div>
</div>