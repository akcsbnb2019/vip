<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '编辑 - 留言';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="larry-grid">
	<div class="larry-personal">
		<header class="larry-personal-tit">
			<span><?= Html::encode($this->title) ?></span>
			<a class="layui-btn layui-btn-small larry-log-del" id="golist" alt="/<?= THISID;?>/index" href="/<?= THISID;?>/index" style="margin-top: 6px;"><i class="iconfont icon-huishouzhan1"></i>返回列表</a>
		</header>
		<div class="layui-form" id="forms">
	    	<?php $form = ActiveForm::begin(['id' => 'menu-form']); ?><?php ActiveForm::end(); ?>
        </div>
		<div class="larry-personal-body clearfix" id="section">
			<fieldset class="layui-elem-field layui-field-title">
				<legend style="font-size:16px;width:auto;border-bottom:0;"><?=$data['title']?></legend>
			</fieldset>
			<ul class="layui-timeline">
				<li class="layui-timeline-item">
					<i class="layui-icon layui-timeline-axis"></i>
					<div class="layui-timeline-content layui-text">
						<h4 class="layui-timeline-title"><?=date('Y-m-d H:i:s',$data['addtime'])?></h4>
						<p><?=$data['content']?></p>
					</div>
				</li>
				<?php foreach ($recdata as $key=>$v) {?>
				<li class="layui-timeline-item">
					<i class="layui-icon layui-timeline-axis"></i>
					<div class="layui-timeline-content layui-text" <?= $data['senduid']==$v['senduid'] ? '' : 'style="color:#f00;"'?>>
						<h4 class="layui-timeline-title">
							<?= $data['senduid']==$v['senduid'] ? '用户' : '管理员'?>-<?=date('Y-m-d H:i:s',$v['addtime'])?>
							<?= $data['senduid']==$v['senduid'] ? '' : '<button class="layui-btn layui-btn-danger layui-btn-mini del" ids='.$v['id'].'>删除</button>'?></h4>
						<p><?=$v['content']?></p>
					</div>
				</li>
				<?php }?>
				<?php if ($data['flag']==1) {?>
				<li class="layui-timeline-item">
					<i class="layui-icon layui-timeline-axis"></i>
					<div class="layui-timeline-content layui-text">
						<div class="layui-timeline-title">问题已关闭</div>
					</div>
				</li>
				<?php }?>
			</ul>
			<?php if ($data['flag']==0) {?>
			<?php $form = ActiveForm::begin(['id' => 'info-form']); ?>
				<input type="hidden" name="id" value="<?= $data['id'];?>">
				<div class="layui-form-item">
					<label class="layui-form-label">回复</label>
					<div class="layui-input-block">
						<textarea placeholder="请输入回复内容" name="content" id="content" lay-verify="required" class="layui-textarea"></textarea>
						<input type="hidden" name="parent_id" value="<?=$data['id']?>">
						<input type="hidden" name="senduid" value="<?=$data['senduid']?>">
					</div>
					<div class="layui-form-mid layui-word-aux" id="msg_content"></div>
				</div>
				<div class="layui-form-item">
					<div class="layui-input-block">
						<button class="layui-btn" lay-submit="" lay-filter="demo1">立即回复</button>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
			<?php ActiveForm::end(); ?>
			<?php }?>
		</div>
	</div>
</section>
<script type="text/javascript" src="/js/pc/section.js"></script>
<link rel="stylesheet" type="text/css" href="/layui/uio/css2/layui.css" media="all">
<script>
$('.del').click('on',function(){
		var id = $(this).attr("ids");

		if(isNull(id) === false){
			layer.msg('更新失败！', {icon: 0});
		}
		var s = -1;
		
		upStatus(id,s,null);
    });

function upStatus(ids,status,url){
	if(isNull(ids) === false){
		layer.msg('没有可操作项！', {icon: 0});
	}
	
	/* 确定Url */
	if(isNull(url) === false){
		if(isNull(window.location.pathname) === false){
			layer.msg('操作异常！', {icon: 0});
		}
		var urlarr = window.location.pathname.split('/');
		url = '/'+urlarr[1]+'/upstatus'
	}
	
	if(isOk() === true){
		return false;
	}
	
	$.ajax({
		type: 'post',
		url: url,
		dataType : "json",
		data: {'_csrf-backend':$("#forms input[name='_csrf-backend']").val(),'ids': ids,'status':status},
		success: function(d) {
			if(d.s === 1){
				layer.msg(d.m, {icon: 1});
				if(typeof(num) == 'undefined'){
					stoHref(location.href,1);
				}else{
					isSub = false;
					$('#page .layui-laypage-btn').click();
				}
			}else{
				layer.msg(d.m, {icon: 0});
				isSub = false;
			}
        },
        beforeSend:function(d){
        	isSub = true;
        }
	});
}
</script>