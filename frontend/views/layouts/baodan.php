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
	<br><br><h3>请完善服务中心后操作</h3><br><button type="button" class="btn btn-primary btn-info btno" data-toggle="modal" data-target="#myModal5" id="passk">开始验证服务中心</button>
</div>
<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">完善服务中心</h4>
                <small class="font-bold"></small>
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
                            <input type="text" name="baodan" id="baodan" placeholder="请输入服务中心" class="form-control">
                            <input type="hidden" name="types" id="types" value="1" class="form-control">
                        </div>
                        <div class="col-sm-5">
                        	<?= Html::submitButton('立即提交', ['class' => 'btn btn-primary btn-info btno', 'name' => 'form-button']) ?>	
                        </div>
                    </div>
                    <br><br><div style="color: red; float:right;">如转账通过同团队代理商,请点击此处<a href="?type=1">完善代理商</a></div><br>
                <?php ActiveForm::end(); ?>
                </p>
            </div>
        </div>
    </div>
</div>