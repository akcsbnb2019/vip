<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;

AppAsset::register($this);

AppAsset::addJs($this, 'bootstrap.min');
AppAsset::addJs($this, 'content.min');
AppAsset::addJs($this, 'icheck.min','js/plugins/iCheck/');
AppAsset::addCss($this, 'custom','css/plugins/iCheck/');
AppAsset::addJs($this, 'main');

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="wrapper wrapper-content  animated fadeInRight article">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox">
                <div class="ibox-content iboxo">
                    <div class="pull-right">
                    	<button type="button" class="btn btn-outline btn-primary righo" id="funin">返回</button>
                    </div>
                    <div class="text-center article-title">
                        <h1><?= $model['title']; ?></h1>
                    </div>
                    <?= $model['content']; ?>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>