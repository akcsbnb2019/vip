<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

use frontend\assets\WapAsset;

WapAsset::register($this);

WapAsset::WapJs($this, 'icheck.min','mobile/js/iCheck/');
WapAsset::WapCss($this, 'custom','mobile/css/iCheck/');
WapAsset::WapJs($this, 'mForm');

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="app">
	<div class="page">
	<!-- 头部 -->
	<?= $this->render('/layouts/head.php'); ?>
	<!-- 头部 -->
        <div class="page-content">
			<div class="m_b_16"></div>
			<div class="m_t_12"></div>
			<?php if ($type==1):?>
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
			<div class="list inline-labels no-hairlines-md liuyan_form m_b_10 jia form_xiu2 list_xiu">
			  <ul>
				<li class="item-content item-input">
				  <div class="item-inner">
					<div class="item-input-wrap">
					  <?= $form->field($model, 'pwd1',['template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-pwd1'>请输入原密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"])->passwordInput(['autofocus' => true, 'name'=>'pwd1', 'placeholder' => '请输入原登录密码']) ?>
					</div>
				  </div>
				</li>
				<li class="item-content item-input">
				  <div class="item-inner">
					<div class="item-input-wrap">
					  <?= $form->field($model, 'pwd1',['template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-pwd2'>新登录密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"])->passwordInput(['placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成','id'=>'newpwd1']) ?>
					</div>
				  </div>
				</li>
				<li class="item-content item-input">
				  <div class="item-inner">
					<div class="item-input-wrap">
					  <?= $form->field($model, 'pwd1',[
							'template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-pwd22'>确认新登录密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>",
						])->passwordInput(['name'=>'pwd2','id'=>'pwd2','placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成']) ?>
					</div>
				  </div>
				</li>
			  </ul>
			</div>
			<?php elseif ($type==2):?>
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
			<div class="list inline-labels no-hairlines-md liuyan_form m_b_10 jia form_xiu2 list_xiu">
			  <ul>

				<li class="item-content item-input">
				  <div class="item-inner">
					<div class="item-input-wrap">
					  <?= $form->field($model, 'pwd2',['template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-pwd2'>二级密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"])->passwordInput(['placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成']) ?>
					</div>
				  </div>
				</li>
				<li class="item-content item-input">
				  <div class="item-inner">
					<div class="item-input-wrap">
					  <?= $form->field($model, 'pwd2',[
                            'template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-pwd22'>确认二级密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>",
                        ])->passwordInput(['name'=>'pwd2','id'=>'pwd2','placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成']) ?>
					</div>
				  </div>
				</li>
				<li class="item-content item-input">
				  <div class="item-inner">
					<div class="item-input-wrap">
					  <div class='col-sm-2 labrs'><label class='control-label' for='uso-pwd22'>短信验证</label></div>
					  <div class='col-sm-6'>
							<div class="row">
							<input type="text" class="form-control col-50" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="4" id="">
							<button type="button" class="button button-raised button-fill col-50" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>
						</div>
					  </div>
					</div>
				  </div>
				</li>

			  </ul>
			</div>
			<?php endif;?>
			<div class="row row_xiu">
				<div class="col-5"></div>
			<?= Html::submitButton('立即提交', ['class' => 'm_t_12 col-45 button button-raised button-fill lg_dl', 'name' => 'form-button']) ?>
			<?= Html::resetButton('重置', ['class' => 'm_t_12 col-45 button button-raised button-fill lg_dl', 'name' => 'reset']) ?>
				<div class="col-5"></div>			
			</div>
			<?php ActiveForm::end(); ?>

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
			                    '<button type="button" class="btn btn-primary" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>');
                            layer.open({
                                style: 'border:none; background-color:#fff; color:red;',
                                content:r.msg,
                                time:2
                            });
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
			                '<button type="button" class="btn btn-primary" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>');
			        }
			    }

			</script>


        </div>
    </div>
	<!-- 菜单 -->
	<?= $this->render('/layouts/head_menu.php'); ?>
	<!-- 菜单 -->
</div>