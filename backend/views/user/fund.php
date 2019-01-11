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
				<input type="hidden" name="ZmIncome[id]" value="<?= $model['id'];?>">
				
				<div class="layui-form-item">
                    <label class="layui-form-label">当前会员</label>
                    <div class="layui-input-inline">
                      	<input type="text" class="layui-input layui-btn-disabled" name="ZmIncome[loginname]" value="<?= $model['loginname'];?>" readonly="readonly" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">说明</label>
                    <div class="layui-input-inline" style="width:390px;">
                      	<input type="text" class="layui-input" name="ZmIncome[remark]" value=""/>
                    </div>
                </div>
				<div class="layui-form-item" id="abs_area">
					<label class="layui-form-label">电子币</label>
					<div class="layui-input-inline" style="float:left;">
						<select name="ZmIncome[add_sub_amount]">
                            <option value="20" selected="selected">增加</option>
                            <option value="21">扣除</option>
                            <option value="22">冻结</option>
                            <option value="23">取消冻结</option>
						</select>
					</div>
					<div class="layui-input-inline" style="float:left;">
                  		<input type="text" class="layui-input" name="ZmIncome[amount]" value="0">
                	</div>
					<div class="layui-form-mid layui-word-aux">当前值：￥<?= $model['amount'];?> 冻结值：￥<?= $model['djamount'];?></div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label"></label>
					<div class="layui-input-inline">
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