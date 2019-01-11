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
	<br><br><h3>请输入短信验证码，验证后才能进行查看股权证书</h3><br><button type="button" class="btn btn-primary btn-info btno" data-toggle="modal" data-target="#myModal5" id="passk">开始验证手机验证码</button>
</div>
<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">请输入验证码</h4>
                <small class="font-bold">验证后才能进行查看股权证书</small>
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
                        <div class="col-sm-7 col-sm-offset-1">
                            <div class="input-group m-b"><span class="input-group-btn" id="span1">
                                <input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="请输入短信验证码" maxlength="4" >
                                <button type="button" class="btn btn-primary" id="zphone" onclick="get_mobile_code()">获取短信验证码</button> </span>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="col-sm-7 col-sm-offset-3">
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
<script>
    function get_mobile_code(){
        $('#span1').html('<input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
            '                                        <button type="button" class="btn btn-primary" id="zphone">获取短信验证码</button>');
        $('#zphone').addClass("disabled");
        $('#zphone').html("正在提交请求..") ;

        $.post('/index/getsms', {mobile:"<?=$model['tel'];?>",types:8}, function(r) {
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