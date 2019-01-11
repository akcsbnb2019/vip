<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '商城对接';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="larry-grid">
	<div class="larry-personal">
		<header class="larry-personal-tit">
			<span><?= Html::encode($this->title) ?></span>
		</header><!-- /header -->
		<div class="larry-personal-body clearfix" id="section">
			<?php $form = ActiveForm::begin(['id' => 'interface-form']); ?>
				<div class="layui-form-item">
					<label class="layui-form-label">商城地址</label>
					<div class="layui-input-block">  
						<input type="text" name="website" id="website" autocomplete="off" class="layui-input" value="<?= $website; ?>" required lay-verify="required" msg="商城地址" placeholder="请输入商城地址" >
					</div>
				</div>
				
				<div class="layui-form-item">
					<div class="layui-input-block">
						<button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</section>
<script type="text/javascript" src="/js/pc/section.js"></script>
<script type="text/javascript">
</script>