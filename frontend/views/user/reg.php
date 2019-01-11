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
					<?php
						$form = ActiveForm::begin([
							'id' => 'form1',
							'action' => Url::to('/'.THISID.'/checkreg'),
							'options' => [
								'class' => 'form-horizontal',
							],
							'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>"]
						]);
						$model->pid  = $userp['loginname'];
						$model->area = $get['area'];
					?>
                    <div class="hr-line-dashed"></div>
					<?= $form->field($model, 'rid')->textInput(['autofocus' => true, 'placeholder' => '邀请人不能为空']) ?>
                    <div class="hr-line-dashed"></div>
					<?= $form->field($model, 'pid')->textInput(['placeholder' => '安置人', 'disabled' => '']) ?>
					<?= $form->field($model, 'pid',['template'=>'{input}'])->hiddenInput() ?>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">位置</label>
                        <div class="col-sm-10">
                            <div class="btn-group">
                                <button class="btn btn-white" type="button"><?= ($get['area']==1 ? '左区' : '右区'); ?></button>
								<?= $form->field($model, 'area',['template'=>'{input}'])->hiddenInput() ?>
                            </div>
                        </div>
                    </div>
                    <!--<div class="form-group">
						<label class="col-sm-2 control-label">是否选择服务中心
							<br/>
							<small class="text-navy">如不选择请去除勾选</small>
						</label>
						<div class="col-sm-10">
							<div class="checkbox tops">
								<label><input type="checkbox" class="checs" value="1" name="bd" id="bds" checked=''>选择</label>
							</div>
						</div>
					</div>-->
                    <div class="hr-line-dashed" id="bdi"></div>
                    <?= $form->field($model, 'fuwuuser')->textInput(['placeholder' => '请输入服务中心,须为同团队,若无服务中心则为空']) ?>
                    <div class="hr-line-dashed"></div>
					<?= $form->field($model, 'loginname')->textInput(['placeholder' => '请输入4~20位字符，可由英文、数字组成']) ?>
                    <div class="hr-line-dashed"></div>
					<?= $form->field($model, 'pwd1')->passwordInput(['placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成']) ?>
                    <div class="hr-line-dashed"></div>
					<?= $form->field($model, 'pwd1',[
						'template'=> "<div class='col-sm-2 labrs'><label class='control-label' for='uso-baodan'>确认密码</label></div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div>",
					])->passwordInput(['name'=>'pwd1','placeholder' => '请输入6~20位字符，可由大小写英文、数字或符号组成']) ?>
                    <div class="hr-line-dashed"></div>
	                <?= $form->field($model, 'truename')->textInput(['placeholder' => '请输入姓名']) ?>
                    <div class="hr-line-dashed"></div>
					<?= $form->field($model, 'tel')->textInput(['placeholder' => '请填写正确的手机号']) ?>
                    <div class="hr-line-dashed"></div>
                    <?= $form->field($model, 'identityid')->textInput(['placeholder' => '请填写正确的身份证号']) ?>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
							<?= Html::submitButton('立即提交', ['class' => 'btn btn-w-m btn-info btno', 'name' => 'form-button']) ?>
							<?= Html::resetButton('重置', ['class' => 'btn btn-w-m btn-warning btno', 'name' => 'reset']) ?>
                            <input type="hidden" id="isarea" class="form-control" value="<?= $get['area']; ?>">
                        </div>
                    </div>
					<?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>