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
AppAsset::addJs($this, 'sweetalert.min','js/plugins/sweetalert/');
AppAsset::addCss($this, 'sweetalert','css/plugins/sweetalert/');
AppAsset::addJs($this, 'mVerify');

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-center">
	<br><br><h3>请验证二级密码，验证后才能进行转账、编辑等操作</h3><br><button type="button" class="btn btn-primary btn-info btno" data-toggle="modal" data-target="#myModal5" id="passk">开始验证二级密码</button>
</div>
<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">请输入二级密码</h4>
                <small class="font-bold">验证后才能进行转账、编辑等操作</small>
            </div>
            <div class="modal-body">
                <p>
                <?php 
                $form = ActiveForm::begin([
                    'id' => 'form1',
                    'options' => [ 'class' => 'form-horizontal'],
                ]);
                ?>
                    <div class="form-group">
                        <div class="col-sm-7">
                            <input type="password" name="password" id="pass" placeholder="请输入二级密码" class="form-control">
                        </div>
                        <div class="col-sm-5">
                        	<?= Html::submitButton('立即提交', ['class' => 'btn btn-primary btn-info btno', 'name' => 'form-button']) ?>	
                        </div>
                    </div>
                    <br><br><br>
                <?php ActiveForm::end(); ?>
                </p>
            </div>
        </div>
    </div>
</div>