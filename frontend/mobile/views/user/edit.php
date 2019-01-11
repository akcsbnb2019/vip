<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\WapAsset;
use yii\helpers\Url;

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
        <div class="page-content ov">
			<?php
			$form = ActiveForm::begin([
				'id' => 'form1',
				'action' => Url::to('/'.THISID.'/edit'),
				'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-4'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"]
			]);
			?>
        	<div class="form">
        		<div class="list no-hairlines-md list2 list4 list2_xiu2">
			        <ul>
			          <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">用户名</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'loginname')->textInput(['class'=>'disabled', 'placeholder' => '']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">邀请人</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'rid')->textInput(['class'=>'disabled', 'placeholder' => '']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">安置人</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'pid')->textInput(['class'=>'disabled', 'placeholder' => '']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">手机</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'tel')->textInput(['autofocus' => true,  'placeholder' => '']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">电子邮箱</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'qq')->textInput(['autofocus' => true,  'placeholder' => '']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">详细地址</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'address')->textInput(['autofocus' => true,  'placeholder' => '']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">邮政编码</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'pic')->textInput(['autofocus' => true,  'placeholder' => '']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">身份证号</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'identityid')->textInput(['autofocus' => true,  'placeholder' => '']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">真实姓名</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'bankname')->textInput(['autofocus' => true,  'placeholder' => '']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">开户行</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'bank')->dropDownList($bank,['prompt' => ['text'=>'请选择', 'options'=>['value'=>'0']]]); ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">银行卡号</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'bankno')->textInput(['autofocus' => true,  'placeholder' => '']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">开户地址</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'bankaddress')->textInput(['autofocus' => true,  'placeholder' => '']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label xiu4">
			            <div class="ios item-inner">
			              <div class="item-title item-label text-align-right form1">短信验证</div>
			              <div class="item-input-wrap inputx">
							<div class="row" id="span1">
								<input type="text" class="form-control col-50" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="4" id="">
								<button type="button" class="xiu1 button button-raised button-fill col-50" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>
							</div>
						  </div>
			            </div>
			          </li>
					  

			        </ul>
			    </div>
				<div class="row">
					<div class="col-10"></div>
					<?= Html::submitButton('立即提交', ['class' => 'm_t_12 col-40 button button-raised button-fill lg_dl', 'name' => 'form-button']) ?>
					<?= Html::resetButton('重置', ['class' => 'm_t_12 col-40 button button-raised button-fill lg_dl', 'name' => 'reset']) ?>
					<div class="col-10"></div>
				</div>
        	</div>
			<?php ActiveForm::end(); ?>
        </div>
    </div>
	<!-- 菜单 -->
	<?= $this->render('/layouts/head_menu.php'); ?>
	<!-- 菜单 -->
</div>
<script>
    function get_mobile_code(){
        $('#span1').html('<input type="text" class="form-control col-50" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
            '<button type="button" class="xiu1 button button-raised button-fill col-50" id="zphone">获取短信验证码</button>');
        $('#zphone').addClass("disabled");
        $('#zphone').html("正在提交请求..") ;

        $.post('/index/getsms', {mobile:"<?=$model['tel'];?>",types:0}, function(r) {
            if(r.status==1){
                RemainTime();
            }else{
                $('#span1').html('<input type="text" class="form-control col-50" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
                    '<button type="button" class="xiu1 button button-raised button-fill col-50" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>');

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
            $('#span1').html('<input type="text" class="form-control col-50" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
                '<button type="button" class="xiu1 button button-raised button-fill col-50" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>');
        }
    }
</script>