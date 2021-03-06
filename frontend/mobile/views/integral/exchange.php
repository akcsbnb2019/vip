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
        <div class="page-content ov">
        	<div class="top1">
				<span>积分余额</span>
				<p><?=$user['amount']?></p>
				<!--<a href="#">转账明细 ></a>-->
			</div>
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
				'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"]
			]);
			?>
        	<div class="form form_xiu">
        		<div class="list no-hairlines-md list2 list4 list2_xiu">
			        <ul>
			          <li class="item-content item-input inline-label xiu2">
			            <div class="ios item-inner item-inner-dh">
			              <div class="item-title item-label text-align-right form1" style="padding-top:20px;">兑换积分</div>
			              <div class="item-input-wrap inputx inputx_p">
			                <?= $form->field($model, 'amount')->textInput(['autofocus' => true, 'placeholder' => '每次兑换积分只能是50的倍数']) ?>
			              </div>
			            </div>
			          </li>
			          <li class="item-content item-input inline-label xiu2">
			            <div class="ios item-inner">
			              <div class="item-title item-label text-align-right form1">备注说明</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'memo')->textInput() ?>
			              </div>
			            </div>
			          </li>
					  <?php if($type == 1){ ?>
					  <li class="item-content item-input inline-label xiu2 ">
			            <div class="ios item-inner">
			              <div class="item-title item-label text-align-right form1">汇款银行</div>
			              <div class="item-input-wrap inputx">
			                <?=$user['bank']?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label xiu2">
			            <div class="ios item-inner">
			              <div class="item-title item-label text-align-right form1">银行帐号</div>
			              <div class="item-input-wrap inputx">
			                <?=$user['bankno']?>
			              </div>
			            </div>
			          </li><li class="item-content item-input inline-label xiu2">
			            <div class="ios item-inner">
			              <div class="item-title item-label text-align-right form1">开户姓名</div>
			              <div class="item-input-wrap inputx">
			                <?=$user['bankname']?>
			              </div>
			            </div>
			          </li>
					  <?php } ?>
			          <li class="item-content item-input inline-label xiu2">
			            <div class="ios item-inner">
			              <div class="item-title item-label text-align-right form1">申请日期</div>
			              <div class="item-input-wrap inputx">
			                <?=date("Y-m-d",time())?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label xiu2 xiu5">
			            <div class="ios item-inner">
			              <div class="item-title item-label text-align-right form1">兑换类型</div>
			              <div class="item-input-wrap inputx">
			              	<select class="form-control m-b" name="Getamount[states]">
                                <?php if($type == 1){ ?>
                                    <option value="1">提现到银行卡</option>
                                <?php }else{ ?>
                                    <option value="8">兑换到商城</option>
                                <?php } ?>
                                </select>
                            </div>
			              
			            </div>
			          </li>
					  <?php if($type == 1): ?>
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
					  <?php endif;?>
			        </ul>
			    </div>
				<div class="row row_xiu">
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

        $.post('/index/getsms', {mobile:"<?=$user['tel'];?>",types:2}, function(r) {
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