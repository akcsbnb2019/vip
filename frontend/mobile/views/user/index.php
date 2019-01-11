<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

AppAsset::addJs($this, 'bootstrap.min');
AppAsset::addJs($this, 'content.min');
AppAsset::addJs($this, 'icheck.min','js/plugins/iCheck/');
AppAsset::addCss($this, 'custom','css/plugins/iCheck/');
AppAsset::addJs($this, 'mForm');


$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
.tt-style-score {text-align: right !important;}
</style>
<div id="app">
    <div class="page">
    <!-- 头部 -->
    <?= $this->render('/layouts/head.php'); ?>
    <!-- 头部 -->
        <div class="page-content" style="padding-right:0;padding-left:0;">
            <div class="ibox-content hiddens">
                <?php
                    $form = ActiveForm::begin([
                        'id' => 'sForm',
                        'action' => Url::to('/'.THISID.'/details'),
                        'options' => ['class' => 'form-inline',],
                    ]);
                    ?>
                    <div class="form-group">
                    <?= Html::submitButton('立即提交', ['class' => 'btn btn-primary btn-info', 'name' => 'form-button']) ?> 
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="list font_size_13">
                <div class="card">
                  
                  <div class="card-content">
                    <div class="card-content-inner">
                    <div class="row">
                        <div class="col-40 tt-style-score">用户编号：</div>
                        <div class="col-60 tt-style-score" style="text-align: left !important;"><?=$user['loginname'];?></div>
                        <div class="col-40 tt-style-score">用户级别：</div>
                        <div class="col-60 tt-style-score" style="text-align: left !important;"><?=$model['level'];?></div>
						<?php if($model['fuli']):?>
						<div class="col-40 tt-style-score">福利会员：</div>
                        <div class="col-60 tt-style-score" style="text-align: left !important;">福利会员<img src="/img/main-info.png"></div>
						<div class="col-40 tt-style-score">福利积分：</div>
                        <div class="col-60 tt-style-score" style="text-align: left !important;">￥<?=$user['yuanshigu'];?></div>
						<?php endif?>
						<?php if($model['dlName']):?>
						<div class="col-40 tt-style-score">代理级别：</div>
                        <div class="col-60 tt-style-score" style="text-align: left !important;"><?=$model['dlName'];?></div>
						<div class="col-40 tt-style-score">代理积分：</div>
                        <div class="col-60 tt-style-score" style="text-align: left !important;">￥<?=AppAsset::dec($model['dlamount'])?></div>
						<?php endif?>
						<div class="col-40 tt-style-score">电子币余额：</div>
                        <div class="col-60 tt-style-score" style="text-align: left !important;">￥<?=AppAsset::dec($user['amount']);?></div>
						
						<div class="col-40 tt-style-score">电子币历史：</div>
                        <div class="col-60 tt-style-score" style="text-align: left !important;">￥<?=AppAsset::dec($model['amountall']);?></div>
						
						<div class="col-40 tt-style-score">商城累计积分：</div>
                        <div class="col-60 tt-style-score" style="text-align: left !important;">￥<?=AppAsset::dec($user['pay_points']);?></div>
						
						<div class="col-40 tt-style-score">商城历史积分：</div>
                        <div class="col-60 tt-style-score" style="text-align: left !important;">￥<?=AppAsset::dec($user['pay_points_all']);?></div>
						
						<div class="col-40 tt-style-score">爱心基金：</div>
                        <div class="col-60 tt-style-score" style="text-align: left !important;">￥<?=AppAsset::dec($user['aixinjijin']);?></div>
	                    <?php if($model['fuli']):?>
                        <div class="col-40 tt-style-score"></div>
                        <a href="<?= Url::to('/user/stockcert'); ?>" class="col-60 tt-style-score href_" style="text-align: left !important;">查看股权证书</a>
	                    <?php endif?>



                    </div>
                    </div>
                  </div>
                </div>

            </div>

        </div>
    </div>
    <!-- 菜单 -->
    <?= $this->render('/layouts/head_menu.php'); ?>
    <!-- 菜单 -->
</div>
