<?php
	
	/* @var $this yii\web\View */
	/* @var $form yii\bootstrap\ActiveForm */
	/* @var $model \common\models\LoginForm */
	
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	use frontend\assets\AppAsset;
	use yii\helpers\Url;
	use frontend\models\Region;
	use frontend\region\Region as re;
	
	AppAsset::register($this);
	
	AppAsset::addJs($this, 'bootstrap.min');
	AppAsset::addJs($this, 'content.min');
	AppAsset::addJs($this, 'icheck.min','js/plugins/iCheck/');
	AppAsset::addCss($this, 'custom','css/plugins/iCheck/');
	AppAsset::addJs($this, 'mForm');
	
	
	$this->title = '会员办公系统';
	$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    .selfr1,.selfr2,.selfr3{width: 30%; float: left; margin-right: 1%; max-width: 180px;}
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="ibox-content">
				
				<?php
					$form = ActiveForm::begin([
						'id' => 'form1',
						'action' => Url::to('/'.THISID.'/addreport'),
						'options' => [
							'class' => 'form-horizontal',
						],
						'fieldConfig'=>['template'=> "<div class='form-group'><div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-8 labrs'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div></div>"]
					]);
				?>
                <div class="hr-line-dashed"></div>
				
				<?= $form->field($model, 'district')->widget(re::className(),[
					'model'=>$model,
					'url'=> Url::toRoute(['get-region']),
					'province'=>[
						'attribute'=>'province',
						'items'=>Region::getRegion(),
						'options'=>['class'=>'form-control form-control-inline selfr1','prompt'=>'选择省份']
					],
					'city'=>[
						'attribute'=>'city',
						'items'=>[],
						'options'=>['class'=>'form-control form-control-inline selfr2','prompt'=>'选择城市']
					],
					'district'=>[
						'attribute'=>'district',
						'items'=>[],
						'options'=>['class'=>'form-control form-control-inline selfr3','prompt'=>'选择县/区']
					]
				]);
				?>
                <div class="hr-line-dashed"></div>
				<?= $form->field($model, 'tel',[
					'template'=> "<div class='form-group'><div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-4 labrs'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div></div>"
				])->textInput(['autofocus' => true, 'readonly'=>'readonly', 'value'=>$user['tel'],'placeholder' => '']) ?>
                <div class="hr-line-dashed"></div>
                <div class="form-group ">
                    <div class="form-group">
                        <div class="col-sm-2 labrs">
                            <label class="control-label">短信</label>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group m-b"><span class="input-group-btn" id="span1">
                                <input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="4" id="">
                                <button type="button" class="btn btn-primary" id="zphone" onclick="get_mobile_code()">获取短信验证码</button> </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2">
						<?= Html::submitButton('提交申请', ['class' => 'btn btn-w-m btn-info btno', 'name' => 'form-button']) ?>
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
        var tel = $("#zmreport-tel").val();

        $('#span1').html('<input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
            '                                        <button type="button" class="btn btn-primary" id="zphone">获取短信验证码</button>');
        $('#zphone').addClass("disabled");
        $('#zphone').html("正在提交请求..") ;
        $.post('/index/getsms', {mobile:<?=$user['tel']?>,types:0}, function(r) {
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