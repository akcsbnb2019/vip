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

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'form1',
                        'action' => Url::to('/'.THISID.'/sendform'),
                        'options' => [
                            'class' => 'form-horizontal',
                        ],
                        'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-5'>{input}</div>\n<div class='col-sm-4'>{error}</div>"]
                    ]);
                    ?>
                    <div class="hr-line-dashed"></div>
                    <?= $form->field($model, 'title')->textInput(['placeholder' => '请输入标题']) ?>
                    <div class="hr-line-dashed"></div>
                    <?= $form->field($model, 'content')->textarea(['rows' => 5, 'placeholder' => '请输入问题内容']) ?>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-2">
                            <?= Html::submitButton('立即提交', ['class' => 'btn btn-w-m btn-info btno', 'name' => 'form-button']) ?>
                            <?= Html::resetButton('重置', ['class' => 'btn btn-w-m btn-warning btno', 'name' => 'reset']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
