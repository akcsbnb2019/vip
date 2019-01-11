<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="app">
	<div class="page">
	<!-- 头部 -->
	<?= $this->render('/layouts/head.php'); ?>
	<!-- 头部 -->
		
        <div class="page-content">
		  <div class="lg_title color_000">请验证二级密码，验证后才能进行转账、编辑等操作</div>
		  <?php
			$form = ActiveForm::begin([
				'id' => 'form1',
                    'options' => [ 'class' => 'form-horizontal'],
			]);
		  ?>
		  <div class="searchbar row hytp_searchbar no-gutter">
			<div class="search-input col-80">
			  <label class="icon icon-search" for="search"></label>
			  <input type="password" name="password" id="pass" placeholder="请输入二级密码" class="form-control">
			</div>
			<?= Html::submitButton('验证', ['class' => 'button button-fill button-primary col-20 ht_40', 'name' => 'form-button']) ?>	
		  </div>
		  <?php ActiveForm::end(); ?>

        </div>
    </div>
	<!-- 菜单 -->
	<?= $this->render('/layouts/head_menu.php'); ?>
	<!-- 菜单 -->
</div>