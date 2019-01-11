<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                	<?php 
                    $form = ActiveForm::begin([
                        'id' => 'form1',
                        'action' => Url::to('/'.THISID.'/confexstock'),
                        'options' => [
                            'class' => 'form-horizontal',
                        ],
                        'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"]
                    ]);
                    ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">可兑换福利积分</label>
                            <div class="col-sm-3">
                                <input type="text" disabled="" value="<?=$maxysg?>" placeholder="可用积分" class="form-control" id="amountss">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">可用商城余额</label>
                            <div class="col-sm-3">
                                <input type="text" disabled="" value="<?=$max_money?>" placeholder="可用积分" class="form-control" id="amountsss">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <?= $form->field($model, 'amount')->textInput(['autofocus' => true, 'id'=>'fljf','onkeyup'=>'this.value=this.value.replace(/\D/gi,"")', 'onblur'=>'check_fljf(this.value)', 'placeholder' => '请填写兑换福利积分，每次兑换福利积分只能是6的倍数，每分10元']) ?>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">申请日期</label>
                            <div class="col-sm-10"><p class="form-control-static"><?=date("Y-m-d",time())?></p></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-2">
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
<script>
    function check_fljf(obj){
        if(obj><?=$maxysg?>){
            $("#fljf").val(<?=$maxysg?>);
        }
    }
</script>