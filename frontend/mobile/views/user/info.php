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
                        <div class="col-30 tt-style-score">用户名：</div>
                        <div class="col-70 tt-style-score" style="text-align: left !important;"><?=$model['loginname'];?></div>
                        <div class="col-30 tt-style-score">邀请人：</div>
                        <div class="col-70 tt-style-score" style="text-align: left !important;"><?=$model['rid'];?></div>
                        <div class="col-30 tt-style-score">安置人：</div>
                        <div class="col-70 tt-style-score" style="text-align: left !important;"><?=$model['pid'];?></div>
                        <div class="col-30 tt-style-score">手  机：</div>
                        <div class="col-70 tt-style-score" style="text-align: left !important;"><?=$model['tel'];?></div>
                        <div class="col-30 tt-style-score">邮政编码：</div>
                        <div class="col-70 tt-style-score" style="text-align: left !important;"><?=$model['pic'];?></div>
                        <div class="col-30 tt-style-score">身份证号：</div>
                        <div class="col-70 tt-style-score" style="text-align: left !important;"><?=$model['identityid'];?></div>
                        <div class="col-30 tt-style-score">真实姓名：</div>
                        <div class="col-70 tt-style-score" style="text-align: left !important;"><?=$model['bankname'];?></div>
                        <div class="col-30 tt-style-score">开户行：</div>
                        <div class="col-70 tt-style-score" style="text-align: left !important;"><?=$model['bank'];?></div>
                        <div class="col-30 tt-style-score">银行卡号：</div>
                        <div class="col-70 tt-style-score" style="text-align: left !important;"><?=$model['bankno'];?></div>
                        <div class="col-30 tt-style-score">开户地址：</div>
                        <div class="col-70 tt-style-score" style="text-align: left !important;"><?=$model['bankaddress'];?></div>
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
