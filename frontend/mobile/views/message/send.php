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
			<div class="m_b_16"></div>
			<div class="m_t_12"></div>
			<?php
				$form = ActiveForm::begin([
					'id' => 'form1',
					'action' => Url::to('/'.THISID.'/sendform'),
					'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-5 inputx input inputx textarea'>{input}</div>\n<div class='col-sm-4'>{error}</div>"]
				]);
			?>
			<div class="list inline-labels no-hairlines-md liuyan_form m_b_10 jia form_xiu2 list_xiu">
			  <ul>
				<li class="item-content item-input">
				  <div class="item-inner">
					<div class="item-input-wrap">
					  <?= $form->field($model, 'title')->textInput(['placeholder' => '请输入标题']) ?>
					</div>
				  </div>
				</li>
				<li class="item-content item-input">
				  <div class="item-inner">
					<div class="item-input-wrap">
					  <?= $form->field($model, 'content')->textarea(['rows' => 5, 'placeholder' => '请输入问题内容']) ?>
					</div>
				  </div>
				</li>
			  </ul>
			</div>
			<div class="row row_xiu">
				<div class="col-5"></div>
			<?= Html::submitButton('立即提交', ['class' => 'm_t_12 col-45 button button-raised button-fill lg_dl', 'name' => 'form-button']) ?>
			<?= Html::resetButton('重置', ['class' => 'm_t_12 col-45 button button-raised button-fill lg_dl', 'name' => 'reset']) ?>
				<div class="col-5"></div>			
			</div>
			<?php ActiveForm::end(); ?>
        </div>
    </div>
	<!-- 菜单 -->
	<?= $this->render('/layouts/head_menu.php'); ?>
	<!-- 菜单 -->
</div>