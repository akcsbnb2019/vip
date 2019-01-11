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
          <div class="lg_title color_000">请完善代理商后操作</div>
          <?php 
			$form = ActiveForm::begin([
				'id' => 'form1',
				'options' => [ 'class' => 'form-horizontal'],
			]);
		  ?>
          <div class="searchbar row hytp_searchbar no-gutter">
            <div class="search-input col-80">
              <label class="icon icon-search" for="search"></label>
              <input type="text" name="baodan" id="baodan" placeholder="请输入代理商" class="form-control">
              <input type="hidden" name="types" id="types" value="0" class="form-control">
            </div>
            <?= Html::submitButton('提交', ['class' => 'button button-fill button-primary col-20 ht_40', 'name' => 'form-button']) ?> 
          </div>
          <?php ActiveForm::end(); ?>
		  <div class="lg_title" style="color: red; float:right;">如转账通过通团队服务中心,请点击此处<a href="?type=1" class="href_">完善服务中心</a></div>
        </div>
    </div>
    <!-- 菜单 -->
    <?= $this->render('/layouts/head_menu.php'); ?>
    <!-- 菜单 -->
</div>