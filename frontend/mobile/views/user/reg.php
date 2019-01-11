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
				'action' => Url::to('/'.THISID.'/checkreg'),
				'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"]
			]);
			$model->pid  = $userp['loginname'];
			$model->area = $get['area'];
			?>
        	<div class="form">
        		<div class="list no-hairlines-md list2 list4 list2_xiu2">
			        <ul>
			          <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">邀请人</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'rid')->textInput(['autofocus' => true, 'placeholder' => '邀请人不能为空' ]) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">安置人</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'pid')->textInput(['placeholder' => '安置人', 'disabled' => '']) ?>
							<?= $form->field($model, 'pid',['template'=>'{input}'])->hiddenInput() ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">位置</div>
			              <div class="item-input-wrap inputx">
			                <span><?= ($get['area']==1 ? '左区' : '右区'); ?></span>
                            <?= $form->field($model, 'area',['template'=>'{input}'])->hiddenInput() ?>
			              </div>
			            </div>
			          </li>
					  <!--<li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">是否选择代理商</div>
			              <div class="item-input-wrap inputx">
                            <?/*= $form->field($model, 'area',['template'=>'{input}'])->hiddenInput() */?>
							<label class="checkbox icon-checkbox-m">
							  <!-- checkbox input
							  <input type="checkbox" value="1" name="bd" id="bds_m" checked=''>
							  <!-- checkbox icon
							  <i class="icon-checkbox"></i>
							</label>
			              </div>
			            </div>
			          </li>-->
					  <li class="item-content item-input inline-label bds_m2">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">服务中心</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'fuwuuser')->textInput(['placeholder' =>  '请输入服务中心,须为同团队,若无服务中心则为空']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">用户名</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'loginname')->textInput(['placeholder' => '请输入4~20位字符，可由英文、数字组成']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">密码</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'pwd1')->passwordInput(['placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">确认密码</div>
			              <div class="item-input-wrap inputx">
			                <?= $form->field($model, 'pwd1',[
								'template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-baodan'>确认密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>",
							])->passwordInput(['name'=>'pwd1','placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成']) ?>
			              </div>
			            </div>
			          </li>
					  <li class="item-content item-input inline-label">
			            <div class="ios xx item-inner">
			              <div class="item-title item-label text-align-right form1">姓名</div>
			              <div class="item-input-wrap inputx">
				              <?= $form->field($model, 'truename')->textInput(['placeholder' => '请输入姓名']) ?>
			              </div>
			            </div>
			          </li>
                      <li class="item-content item-input inline-label">
                          <div class="ios xx item-inner">
                              <div class="item-title item-label text-align-right form1">手机</div>
                              <div class="item-input-wrap inputx">
	                              <?= $form->field($model, 'tel')->textInput(['placeholder' => '请填写正确的手机号']) ?>
                              </div>
                          </div>
                      </li>
                       <li class="item-content item-input inline-label">
                           <div class="ios xx item-inner">
                               <div class="item-title item-label text-align-right form1">身份证</div>
                               <div class="item-input-wrap inputx">
						        <?= $form->field($model, 'identityid')->textInput(['placeholder' => '请填写正确的身份证']) ?>
                               </div>
                           </div>
                       </li>

			        </ul>
			    </div>
				<div class="row">
					<div class="col-10"></div>
					<?= Html::submitButton('立即提交', ['class' => 'm_t_12 col-40 button button-raised button-fill lg_dl', 'name' => 'form-button']) ?>
					<?= Html::resetButton('重置', ['class' => 'm_t_12 col-40 button button-raised button-fill lg_dl', 'name' => 'reset']) ?>
					<input type="hidden" id="isarea" class="form-control" value="<?= $get['area']; ?>">
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