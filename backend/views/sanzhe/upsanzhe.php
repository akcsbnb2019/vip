<?php
	
	/* @var $this yii\web\View */
	/* @var $form yii\bootstrap\ActiveForm */
	/* @var $model \common\models\LoginForm */
	
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	
	$this->title = '工具合集 - 修复三折';
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

            <div class="layui-form-item">
                <label class="layui-form-label">帐号</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="EUsers[user_name]" placeholder="请输入要修复的帐号" value="" >
                </div>
            </div>
            <!--<div class="layui-form-item">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-inline" style="width:390px;">
                    <input type="radio" class="layui-input" name="types" value="0" checked title="不变"/>
                    <input type="radio" class="layui-input" name="types" value="1" title="增加"/>
                    <input type="radio" class="layui-input" name="types" value="-1" title="减少"/>
                </div>
            </div>-->
            <div class="layui-form-item" id="abs_area">
                <label class="layui-form-label">积分</label>
                <div class="layui-input-inline" style="float:left;">
                    <select name="types">
                        <option value="0" selected="selected">不变</option>
                        <option value="1">增加</option>
<!--                        <option value="-1">减少</option>-->
                    </select>
                </div>
                <div class="layui-input-inline" style="float:left;">
                    <input type="text" class="layui-input" name="EUsers[jifen]" value="0">
                </div>
                <div class="layui-form-mid layui-word-aux">如不更改用户积分请选择(不变)并保持积分为(0)</div>
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