<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;
use frontend\assets\WapAsset;
use yii\helpers\Url;

WapAsset::register($this);

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="app">
  <div class="page">
	<!-- 头部 -->
	<?= $this->render('/layouts/head.php'); ?>
	<!-- 头部 -->
	<iframe name="iframe0" width="100%" height="100%" src="<?= Url::to('/index/main'); ?>" frameborder="0" data-id="<?= Url::to('/index/main'); ?>" seamless></iframe>
  </div>
  <!-- 菜单 -->
  <?= $this->render('/layouts/head_menu.php'); ?>
  <!-- 菜单 -->
</div>