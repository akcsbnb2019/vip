<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '编辑 - 管理员角色';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="larry-grid">
	<div class="larry-personal">
		<header class="larry-personal-tit">
			<span><?= Html::encode($this->title) ?></span>
			<a class="layui-btn layui-btn-small larry-log-del" href="/<?= THISID;?>/index" style="margin-top: 6px;" id="golist"><i class="iconfont icon-huishouzhan1"></i>返回列表</a>
		</header><!-- /header -->
		<div class="larry-personal-body clearfix">
			<?php $form = ActiveForm::begin(['id' => 'auth-form']); ?>
				<input type="hidden" name="UserBackend[id]" id="id" value="<?= $data['id'];?>" >
				<div class="layui-form-item">
					<label class="layui-form-label">名称</label>
					<div class="layui-input-block">  
						<input type="text" name="UserBackend[username]" id="name" autocomplete="off"  class="layui-input" value="<?= $data['username'];?>" >
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">角色</label>
					<div class="layui-input-block">  
						<input type="text" autocomplete="off"  class="layui-input layui-disabled" disabled="disabled" value="<?= $group['name'];?>" >
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">登录密码</label>
					<div class="layui-input-block">  
						<input type="text" name="UserBackend[password]" id="password" autocomplete="off"  class="layui-input" value="" >
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">真实姓名</label>
					<div class="layui-input-block">  
						<input type="text" name="UserBackend[realname]" id="realname" autocomplete="off"  class="layui-input" value="<?= $data['realname'];?>" >
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">状态</label>
					<div class="layui-input-block">
						<input type="radio" name="UserBackend[status]" value="1" title="启用" <?php if($data['status'] == 1) {?>checked=""<?php }?>>启用
						<input type="radio" name="UserBackend[status]" value="0" title="停用" <?php if($data['status'] == 0) {?>checked=""<?php }?>>停用
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">排序</label>
					<div class="layui-input-block">
						<input type="text" name="UserBackend[sort]"  autocomplete="off" class="layui-input" value="<?= $data['sort'];?>">
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
<input type="hidden" value="gruser2" id="actions">