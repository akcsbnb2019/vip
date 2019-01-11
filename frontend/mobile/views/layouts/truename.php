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

        <div class="page-content">
          <div class="lg_title color_000">请完善昵称后操作</div>
          <?php 
            $form = ActiveForm::begin([
                'id' => 'form1',
                'options' => [ 'class' => 'form-horizontal'],
            ]);
            ?>
          <div class="searchbar row hytp_searchbar no-gutter">
            <div class="search-input col-80">
              <label class="icon icon-search" for="search"></label>
              <input type="text" name="truename" id="truename" placeholder="请输入昵称" class="form-control">
            </div>
            <?= Html::submitButton('提交', ['class' => 'button button-fill button-primary col-20 ht_40', 'name' => 'form-button']) ?> 
          </div>
          <?php ActiveForm::end(); ?>

        </div>
    </div>
    <!-- 菜单 -->
    <?= $this->render('/layouts/head_menu.php'); ?>
    <!-- 菜单 -->
</div>