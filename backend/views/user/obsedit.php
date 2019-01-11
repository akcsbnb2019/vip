<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '资料修改 - 会员其它';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>.layui-btn-disabled{color:#000}</style>
<section class="larry-grid">
	<div class="larry-personal">
		<header class="larry-personal-tit">
			<span><?= Html::encode($this->title) ?></span>
			<a class="layui-btn layui-btn-small larry-log-del" href="/<?= THISID;?>/index" style="margin-top: 6px;"><i class="iconfont icon-huishouzhan1"></i>返回列表</a>
		</header><!-- /header -->
		<div class="larry-personal-body clearfix" id="section">
			<?php $form = ActiveForm::begin(['id' => 'news-form']); ?>
				<input type="hidden" name="ZmPosition[users_id]" value="<?= $model['users_id'];?>">
				
				<div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-inline" style=" margin-left: 40px;">
                      	<input type="text" class="layui-input layui-btn-disabled" name="ZmPosition[uname]" value="<?= $model['uname'];?>" readonly="readonly" >
                    </div>
                    <div class="layui-form-mid"></div>
                   
				<div class="layui-form-item">
					<label class="layui-form-label">平移升级</label>
					<div class="layui-input-block">
						<input type="radio" name="ZmPosition[pan]" value="0" title="否" <?php if($model['pan']==0){ ?> checked="" <?php } ?> ><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><span><?=$model['pan']?>否</span></div>
						<input type="radio" name="ZmPosition[pan]" value="1" title="是" <?php if($model['pan']==1){ ?> checked="" <?php } ?>><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>是</span></div>
					</div>
				</div>
				<div class="layui-form-item" id="abs_area" >
					<label class="layui-form-label">左右区选择</label>
					<div class="layui-input-block" style="width: 405px;">
						<select name="ZmPosition[abs_area]" id="abs_area" lay-filter="aihao" >
                            <option value="0" <?php if($model['abs_area']==0){echo "selected";}?>>请选择</option>
                            <option value="1" <?php if($model['abs_area']==1){echo "selected";}?>>左区绝对碰</option>
                            <option value="2" <?php if($model['abs_area']==2){echo "selected";}?>>右区绝对碰</option>
						</select>
					</div>
				</div>
                <div class="layui-form-item" id="absolute" >
                    <label class="layui-form-label">绝对碰积分</label>
                    <div class="layui-input-block" style="width: 405px;">
                        <input type="text" name="ZmPosition[absolute]" id="title" autocomplete="off" class="layui-input" value="<?= $model['absolute'];?>" required lay-verify="required" msg="绝对碰积分" placeholder="请输入绝对碰积分,非绝对碰请勿修改" >
                    </div>
                </div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
				<br><br><br><br><br><br>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</section>
<script type="text/javascript" src="/js/pc/section.js"></script>
<script type="text/javascript">
$(function(){
	$('#section > form').removeClass('col-lg-5').addClass('col-lg-12');
});
</script>