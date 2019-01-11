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
                    <div class="ibox-content iboxo">
                        <table class="table table-hover d-border" id="tables">
                            <thead>
                            <tr>
                                <th style="color: red;"></th>
                                <th style="color: red;">请勿重复点击提交操作，以免造成个人损失。</th>
                            </tr>
                            </thead>
                        </table>
                        <nav class="tpage" aria-label="Page navigation">
                            <div id="pagination"></div>
                        </nav>
                    </div>
                	<?php 
                    $form = ActiveForm::begin([
                        'id' => 'form1',
                        'action' => Url::to('/'.THISID.'/confexchange/?type='.$type),
                        'options' => [
                            'class' => 'form-horizontal',
                        ],
                        'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"]
                    ]);
                    ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">积分余额</label>
                            <div class="col-sm-3">
                                <input type="text" disabled="" value="<?=$user['amount']?>" placeholder="可用积分" class="form-control" id="amountss">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <?= $form->field($model, 'amount')->textInput(['autofocus' => true, 'placeholder' => '请填写兑换金额，每次兑换积分只能是50的倍数']) ?>
                        <div class="hr-line-dashed"></div>
                        <?= $form->field($model, 'memo')->textInput() ?>
                        <div class="hr-line-dashed"></div>
                        <?php if($type == 1){ ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">汇款银行</label>
                            <div class="col-sm-10"><p class="form-control-static"><?=$user['bank']?></p></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">银行帐号</label>
                            <div class="col-sm-10"><p class="form-control-static"><?=$user['bankno']?></p></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">开户姓名</label>
                            <div class="col-sm-10"><p class="form-control-static"><?=$user['bankname']?></p></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">申请日期</label>
                            <div class="col-sm-10"><p class="form-control-static"><?=date("Y-m-d",time())?></p></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">兑换类型</label>
                            <div class="col-sm-6">
                                <select class="form-control m-b" name="Getamount[states]">
                                <?php if($type == 1){ ?>
                                    <option value="1">提现到银行卡</option>
                                <?php }else{ ?>
                                    <option value="8">兑换到商城</option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php if($type == 1): ?>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">短信验证</label>
                            <div class="col-sm-6">
                                <div class="input-group m-b"><span class="input-group-btn" id="span1">
                                        <input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" maxlength="4" id="">
                                        <button type="button" class="btn btn-primary" id="zphone" onclick="get_mobile_code()">获取短信验证码</button> </span>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
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
<img src="" align="center" style="float: contour" width="764px">
<script>
    function get_mobile_code(){
        $('#span1').html('<input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
            '                                        <button type="button" class="btn btn-primary" id="zphone">获取短信验证码</button>');
        $('#zphone').addClass("disabled");
        $('#zphone').html("正在提交请求..") ;

        $.post('/index/getsms', {mobile:"<?=$user['tel'];?>",types:2}, function(r) {
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