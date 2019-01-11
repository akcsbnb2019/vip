<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '编辑 - 权限菜单';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="larry-grid">
	<div class="larry-personal">
		<header class="larry-personal-tit">
			<span><?= Html::encode($this->title) ?></span>
			<a class="layui-btn layui-btn-small larry-log-del" href="/<?= THISID;?>/index?cid=<?= $model['cid'];?>" style="margin-top: 6px;"><i class="iconfont icon-huishouzhan1"></i>返回列表</a>
		</header><!-- /header -->
		<div class="larry-personal-body clearfix">
			<?php $form = ActiveForm::begin(['id' => 'menu-form']); ?>
				<input type="hidden" name="VipMenu[id]" id="id" value="<?= $data['id'];?>" >
				<div class="layui-form-item">
					<label class="layui-form-label">名称</label>
					<div class="layui-input-block">  
						<input type="text" name="VipMenu[name]" id="name" autocomplete="off"  class="layui-input" value="<?= $data['name'];?>" >
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">Url称</label>
					<div class="layui-input-block">  
						<input type="text" name="VipMenu[url_key]" id="url_key" autocomplete="off"  class="layui-input" value="<?= $data['url_key'];?>" >
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">上级菜单</label>
					<div class="layui-input-block">
						<input type="text" autocomplete="off" class="layui-input layui-disabled" value="<?= $model['cname'];?>" disabled="disabled">
						<input type="hidden" name="VipMenu[cat_id]"  autocomplete="off" value="<?= $model['cid'];?>">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">类型</label>
					<div class="layui-input-block">
						<select name="VipMenu[type]" lay-filter="aihao">
							<option value="0"></option>
							<option value="1" <?php if($data['type'] == 1) {?>selected="selected"<?php }?>>普通类型</option>
							<option value="2" <?php if($data['type'] == 2) {?>selected="selected"<?php }?>>高级类型</option>
							<option value="3" <?php if($data['type'] == 3) {?>selected="selected"<?php }?>>Url连接</option>
						</select>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">分组</label>
					<div class="layui-input-block">
						<input type="text" name="VipMenu[group_name]"  autocomplete="off" class="layui-input" value="<?= $data['group_name'];?>">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">图标名</label>
					<div class="layui-input-block">  
						<input type="text" name="VipMenu[icon]" id="icon" autocomplete="off"  class="layui-input" value="<?= $data['icon'];?>" >
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">状态</label>
					<div class="layui-input-block">
						<input type="radio" name="VipMenu[status]" value="1" title="启用" <?php if($data['status'] == 1) {?>checked=""<?php }?>><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><span>启用</span></div>
						<input type="radio" name="VipMenu[status]" value="0" title="停用" <?php if($data['status'] == 0) {?>checked=""<?php }?>><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>停用</span></div>
					</div>
				</div>
				<?php if($model['cid']){ ?>
				<div class="layui-form-item">
					<label class="layui-form-label">是否有子集</label>
					<div class="layui-input-block">
						<input type="radio" name="VipMenu[subset]" value="1" title="是" <?php if($data['subset'] == 1) {?>checked=""<?php }?>><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><span>是</span></div>
						<input type="radio" name="VipMenu[subset]" value="0" title="否" <?php if($data['subset'] == 0) {?>checked=""<?php }?>><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>否</span></div>
					</div>
				</div>
				<?php } ?>
				<div class="layui-form-item">
					<label class="layui-form-label">排序</label>
					<div class="layui-input-block">
						<input type="text" name="VipMenu[sort]"  autocomplete="off" class="layui-input" value="<?= $data['sort'];?>">
					</div>
				</div>

				<div class="layui-form-item layui-form-text">
					<label class="layui-form-label">简介</label>
					<div class="layui-input-block">
						<textarea placeholder="请输入简介内容" value="" class="layui-textarea" name="VipMenu[desc]"><?= $data['desc'];?></textarea>
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
<script type="text/javascript" src="/js/pc/gruser.js"></script>