<?php  

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
 
$this->title = '平移修改推荐人';
$this->params['breadcrumbs'][] = $this->title;
?> 
<section class="larry-grid">
	<div class="larry-personal">
		<header class="larry-personal-tit">
			<span><?= Html::encode($this->title) ?></span>
			<a class="layui-btn layui-btn-small larry-log-del" href="/<?= THISID;?>/index" style="margin-top: 6px;"><i class="iconfont icon-huishouzhan1"></i>返回列表</a>
		</header><!-- /header -->
		<div class="larry-personal-body clearfix" id="section">
			<?php $form = ActiveForm::begin(['id' => 'news-form','action' => '/uprid/editpy']); ?>
				<input type="hidden" name="userid" value="00">
				<div class="layui-form-item">
					<label class="layui-form-label">用户名</label>
					<div class="layui-input-block">  
						<input type="text" name="loginname" id="loginname" autocomplete="off" class="layui-input" value="" required lay-verify="required" msg="" placeholder="" >
					</div>
				</div>  
				<div class="layui-form-item">
					<label class="layui-form-label">修改推荐人</label>
					<div class="layui-input-block">
						<input type="text" name="rid" id="rid" autocomplete="off" class="layui-input" value="" required lay-verify="required" msg="" >
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