<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '添加 - 新闻';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
#uel .layui-input-block{height:610px;}
#editor{width:100%;height:500px;}
@media only screen and (min-width: 1200px) {
  #editor{width:920px;}
}
@media only screen and (min-width: 1320px) {
  #editor{width:1024px;}
}
#uel textarea{ display:none}
</style>
<section class="larry-grid">
	<div class="larry-personal">
		<header class="larry-personal-tit">
			<span><?= Html::encode($this->title) ?></span>
			<a class="layui-btn layui-btn-small larry-log-del" href="javascript:;" alt="/<?= THISID;?>/index" style="margin-top: 6px;" id="golist"><i class="iconfont icon-huishouzhan1"></i>返回列表</a>
		</header><!-- /header -->
		<div class="larry-personal-body clearfix" id="section">
			<?php $form = ActiveForm::begin(['id' => 'news-form']); ?>
				<input type="hidden" name="News[pic]" value="00">
				<div class="layui-form-item">
					<label class="layui-form-label">标题</label>
					<div class="layui-input-block">  
						<input type="text" name="News[title]" id="title" autocomplete="off" class="layui-input" value="" required lay-verify="required" msg="标题" placeholder="请输入标题" >
					</div>
				</div>

				<div class="layui-form-item layui-form-text" id="uel">
					<label class="layui-form-label">详情</label>
					<div class="layui-input-block">
						<textarea class="layui-textarea" name="News[content]" id="edtext"></textarea>
						<div id="editor" type="text/plain" msg="详情"></div>
					</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">类型</label>
					<div class="layui-input-block">
						<select name="News[types]" lay-filter="aihao">
							<option value="0"></option>
							<option value="4" selected="selected">普通类型</option>
						</select>
					</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">状态</label>
					<div class="layui-input-block">
						<input type="radio" name="News[status]" value="1" title="启用" checked=""><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><span>启用</span></div>
						<input type="radio" name="News[status]" value="0" title="停用"><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>停用</span></div>
					</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">排序(未启用)</label>
					<div class="layui-input-block">
						<input type="text" autocomplete="off" class="layui-input" value="99"> <!-- name="News[sort]"-->
					</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">录入时间</label>
					<div class="layui-input-block">
						<input type="text" name="News[UpdateTime]" id="uptime" autocomplete="off" class="layui-input" value="<?= $uptime; ?>" required lay-verify="required" msg="录入时间" >
					</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">开始时间</label>
					<div class="layui-input-block">
						<input type="text" name="News[BegindateTime]" id="begtime" autocomplete="off" class="layui-input" value="<?= $uptime; ?> 00:00:00"  required lay-verify="required" msg="开始时间">
					</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">结束时间</label>
					<div class="layui-input-block">
						<input type="text" name="News[EnddateTime]" id="endtime" autocomplete="off" class="layui-input" value="2030-12-31 23:59:59"  required lay-verify="required" msg="结束时间">
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
<script type="text/javascript" charset="utf-8" src="/ue/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/ue/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/ue/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
newsTime();
/* 实例化编辑器 */
var ue = UE.getEditor('editor');
</script>