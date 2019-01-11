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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="ibox-content">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'form1',
                    'action' => Url::to('/'.THISID.'/edit'),
                    'options' => [
                        'class' => 'form-horizontal',
                    ],
                    'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-4'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"]
                ]);
                ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'loginname')->textInput(['autofocus' => true, 'disabled'=>'true', 'placeholder' => '']) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'rid')->textInput(['autofocus' => true, 'disabled'=>'true', 'placeholder' => '']) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'pid')->textInput(['autofocus' => true, 'disabled'=>'true', 'placeholder' => '']) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'tel')->textInput(['autofocus' => true,  'placeholder' => '']) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'qq')->textInput(['autofocus' => true,  'placeholder' => '']) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'address')->textInput(['autofocus' => true,  'placeholder' => '']) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'pic')->textInput(['autofocus' => true,  'placeholder' => '']) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'identityid')->textInput(['autofocus' => true,  'placeholder' => '']) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'bankname')->textInput(['autofocus' => true,  'placeholder' => '']) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'bank')->dropDownList($bank,['prompt' => ['text'=>'请选择', 'options'=>['value'=>'0']]]); ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'bankno')->textInput(['autofocus' => true,  'placeholder' => '']) ?>

                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'bankaddress')->textInput(['autofocus' => true,  'placeholder' => '']) ?>
                <?php if($model['tel']!=''):?>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">短信验证</label>
                    <div class="col-sm-4">
                        <div class="input-group m-b"><span class="input-group-btn" id="span1">
                                        <input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="4" id="">
                                        <button type="button" class="btn btn-primary" id="zphone" onclick="get_mobile_code()">获取短信验证码</button> </span>
                        </div>
                    </div>
                </div>
                <?php endif;?>

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
<!--18753053539-->
<script>
    function get_mobile_code(){
        $('#span1').html('<input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
            '                                        <button type="button" class="btn btn-primary" id="zphone">获取短信验证码</button>');
        $('#zphone').addClass("disabled");
        $('#zphone').html("正在提交请求..") ;

        $.post('/index/getsms', {mobile:"<?=$model['tel'];?>",types:0}, function(r) {
            if(r.status==1){
                RemainTime();
            }else{
                $('#span1').html('<input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
                    '                                        <button type="button" class="btn btn-primary" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>');

                layer.msg(r.msg, {icon: r.status});
                $('#zphone').removeClass("disabled");
                $('#zphone').html('获取短信验证码');

            }
        });
    };
    var iTime = 59;
    var Account;
    function RemainTime(){
        $('#zphone').addClass("disabled");

        var iSecond,sSecond="",sTime="";
        if (iTime >= 0){
            iSecond = parseInt(iTime%60);
            iMinute = parseInt(iTime/60)
            if (iSecond >= 0){
                if(iMinute>0){
                    sSecond = iMinute + "分" + iSecond + "秒";
                }else{
                    sSecond = iSecond + "秒后,可再次获取..";
                }
            }
            sTime=sSecond;
            if(iTime==0){

                clearTimeout(Account);
                sTime='获取手机验证码';
                iTime = 59;
                $('#zphone').removeClass("disabled");

            }else{

                Account = setTimeout("RemainTime()",1000);
                iTime=iTime-1;
            }
        }else{
            sTime='没有倒计时';
        }
        $('#zphone').html(sTime) ;
        if(sTime=='获取手机验证码'){
            $('#span1').html('<input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
                '                                        <button type="button" class="btn btn-primary" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>');
        }
    }




</script>