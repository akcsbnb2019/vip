<?php

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
            <!--<div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            <a class="btn btn-block btn-primary compose-mail" href="?type=1">通过原密码修改</a>
                            <a class="btn btn-block btn-primary compose-mail" href="?type=2">通过短信修改</a>
                            <a class="btn btn-block btn-primary compose-mail" href="?type=3">通过身份修改</a>


                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>-->
                <?php if ($type==1):?>
                    <div class="col-sm-12 animated fadeInRight">
                        <div class="ibox-content">

                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'form1',
                                'action' => Url::to('/'.THISID.'/pass?type=1'),
                                'options' => [
                                    'class' => 'form-horizontal',
                                ],
                                'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"]
                            ]);
                            ?>
                            <div class="hr-line-dashed"></div>
                            <?= $form->field($model, 'pwd1',['template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-pwd1'>请输入原密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"])->passwordInput(['autofocus' => true, 'name'=>'pwd1', 'placeholder' => '请输入原登录密码']) ?>
                            <div class="hr-line-dashed"></div>
                            <?= $form->field($model, 'pwd1',['template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-pwd2'>新登录密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"])->passwordInput(['placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成','id'=>'newpwd1']) ?>
                            <div class="hr-line-dashed"></div>
                            <?= $form->field($model, 'pwd1',[
                                'template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-pwd22'>确认新登录密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>",
                            ])->passwordInput(['name'=>'pwd2','id'=>'pwd2','placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成']) ?>
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
                <?php elseif ($type==2):?>
                    <div class="col-sm-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <?php
                                $form = ActiveForm::begin([
                                    'id' => 'form1',
                                    'action' => Url::to('/'.THISID.'/pass?type=2'),
                                    'options' => [
                                        'class' => 'form-horizontal',
                                    ],
                                    'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"]
                                ]);
                                ?>
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
                                
                                
                                <div class="hr-line-dashed"></div>
                                <?= $form->field($model, 'pwd2',['template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-pwd2'>二级密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"])->passwordInput(['placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成']) ?>
                                <div class="hr-line-dashed"></div>
                                <?= $form->field($model, 'pwd2',[
                                    'template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-pwd22'>确认二级密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>",
                                ])->passwordInput(['name'=>'pwd2','id'=>'pwd2','placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成']) ?>
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
                    <script>
					    function get_mobile_code(){
					        $('#span1').html('<input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
					            '                                        <button type="button" class="btn btn-primary" id="zphone">获取短信验证码</button>');
					        $('#zphone').addClass("disabled");
					        $('#zphone').html("正在提交请求..") ;

					        $.post('/index/getsms', {mobile:"<?=$tel;?>",types:0}, function(r) {
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
                <?php endif;?>

            </div>
        </div>
    </div>
</div>
