<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="app">
	<div class="page">
	<!-- 头部 -->
	<?= $this->render('/layouts/head.php'); ?>
	<!-- 头部 -->
		
        <div class="page-content">
		  <div class="lg_title color_000">请验证短信验证码，验证后才能进行查看股权操作</div>
		  <?php
			$form = ActiveForm::begin([
				'id' => 'form1',
                    'options' => [ 'class' => 'form-horizontal'],
			]);
		  ?>
		  <div class="hytp_searchbar no-gutter" style="background:#fff;border-radius: 2px;
    margin: 8px;
    width: auto;
    -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, .12), 0 1px 2px rgba(0, 0, 0, .24);
    box-shadow: 0 1px 3px rgba(0, 0, 0, .12), 0 1px 2px rgba(0, 0, 0, .24);">
              <div class="row" id="span1" style="margin-bottom: 15px;">
                  <input type="text" style="height:40px;" class="form-control col-60" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="4" id="">
                  <button type="button" class="xiu1 button button-raised button-fill col-40" id="zphone" onclick="get_mobile_code()">获取验证码</button>
              </div>
			<!--<div class="search-input col-80">
			  <label class="icon icon-search" for="search"></label>
                <input type="text" class="form-control col-30" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="4" id="">
                <button type="button" class="xiu1 button button-raised button-fill col-50" id="zphone" onclick="get_mobile_code()">获取</button>
			</div>-->
			<?= Html::submitButton('验证', ['class' => 'button button-fill button-primary col-100 ht_40', 'name' => 'form-button']) ?>
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
        $('#span1').html('<input type="text" style="height:40px;" class="form-control col-60" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
            '<button type="button" class="xiu1 button button-raised button-fill col-40" id="zphone">获取短信验证码</button>');
        $('#zphone').addClass("disabled");
        $('#zphone').html("正在提交请求..") ;

        $.post('/index/getsms', {mobile:"<?=$model['tel'];?>",types:0}, function(r) {
            if(r.status==1){
                RemainTime();
            }else{
                $('#span1').html('<input type="text" style="height:40px;" class="form-control col-60" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
                    '<button type="button" class="xiu1 button button-raised button-fill col-40" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>');

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
            $('#span1').html('<input type="text" style="height:40px;" class="form-control col-60" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
                '<button type="button" class="xiu1 button button-raised button-fill col-40" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>');
        }
    }
</script>