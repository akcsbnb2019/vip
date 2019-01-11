<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use backend\assets\AppAsset;


AppAsset::addJs($this, 'open');
AppAsset::addCss($this, 'global');
AppAsset::addCss($this, 'animate');
AppAsset::addCss($this, 'login');

$this->title = '管理员登录';
?>

<div class="layui-fluid">
	<div class="layui-row larryms-layout">
		<div class="layui-col-lg6  layui-col-md6 layui-col-sm10 layui-col-xs11 larry-main animated shake larry-delay2">
             <div class="title">管理系统</div>
             <p class="info">后台登录中心</p>
             <div class="user-info">
				<div class="avatar"><img src="/images/photo/admin.png" alt=""></div>
                <?php $form = ActiveForm::begin([
                    'id' => 'zm-form',
                    'action' => '/site/lajax',
                	'options' => ['class' => 'layui-form'],
                	'fieldConfig'=>['template'=> "{input}{error}"]
                ]); ?>
                    <div class="layui-form-item">
		 	             <label class="layui-form-label">用户名:</label>
		 	             <? echo $form->field($model, 'username')->textInput([
		 	                 'autofocus' => true,
		 	                 'autocomplete' => 'off',
		 	                 'class' => 'layui-input larry-input',
		 	                 'placeholder' => '请输入您的用户名',
		 	                 'lay-verify' => 'required',
		 	             ]) ?>
		            </div>
		            <div class="layui-form-item" id="password">
		 	             <label class="layui-form-label">密码:</label>
		 	             <? echo $form->field($model, 'password')->passwordInput([
		 	                 'required' => '',
		 	                 'autocomplete' => 'off',
		 	                 'class' => 'layui-input larry-input',
		 	                 'placeholder' => '请输入您的登录密码',
		 	                 'lay-verify' => 'required|password',
		 	             ]) ?>
		 	        </div>
		            <div class="layui-form-item larry-verfiy-code" id="larry_code">
		            	<? echo $form->field($model, 'code')->textInput([
		            	    'class' => 'layui-input larry-input',
		            	    'lay-verfy' => '',
		 	                'autocomplete' => 'off',
		            	    'placeholder' => '输入验证码',
		            	]) ?>
		            	
		            	
		 	             <div class="code">
		 	   	             <div class="arrow"></div>
		 	   	             <div class="code-img">
		 	   	             	<?php echo Captcha::widget([
                        		    'name'=>'captchaimg',
                        		    'captchaAction'=>'captchatest',
                        		    'imageOptions'=>[
                        		        'id'=>'codeimage',
                        		        'class'=>'verifyImg',
                        		        'title'=>'换一个',
                        		        'alt'=>'换一个',
                        		        'onclick'=>"javascript:this.src=this.src+'&v='+Math.random();"
                        		      ],
                        		    'template'=>'{image}'
                        		]); ?>
		 	   	             </div>
		 	   	             <a id="change" class="change" title="看不清,点击更换验证码"><i></i></a>
		 	             </div>
		            </div>
		            <div class="layui-form-item">
		 	            <button class="layui-btn larry-btn" lay-filter="submit" lay-submit>立即登录</button>
		            </div>
    			<?php ActiveForm::end(); ?>
             	<input type="hidden" value="login" id="actions">
             </div>
             <div class="copy-right">©</div>
		</div>
	</div>
</div>