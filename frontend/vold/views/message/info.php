<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cents" style="padding-top:20px;">
	<fieldset class="layui-elem-field layui-field-title" style="margin-top:0;">
		<legend style="font-size:16px;"><?=$info['title']?></legend>
	</fieldset>
	<ul class="layui-timeline" style="padding:0 0 0 30px;">
		<li class="layui-timeline-item">
			<i class="layui-icon layui-timeline-axis"></i>
			<div class="layui-timeline-content layui-text">
				<h4 class="layui-timeline-title"><?=date('Y-m-d H:i:s',$info['addtime'])?></h4>
				<p><?=$info['content']?></p>
			</div>
		</li>
		<?php foreach ($recdata as $key=>$v) {?>
		<li class="layui-timeline-item">
			<i class="layui-icon layui-timeline-axis"></i>
			<div class="layui-timeline-content layui-text" <?= $info['senduid']==$v['recuid'] ? '' : 'style="color:#f00;"'?>>
				<h4 class="layui-timeline-title"><?=date('Y-m-d H:i:s',$v['addtime'])?></h4>
				<p><?=$v['content']?></p>
			</div>
		</li>
		<?php }?>
		<?php if ($info['flag']==1) {?>
		<li class="layui-timeline-item">
			<i class="layui-icon layui-timeline-axis"></i>
			<div class="layui-timeline-content layui-text">
				<div class="layui-timeline-title"><button class="layui-btn layui-btn-disabled" lay-submit="" lay-filter="demo1" id="but">问题已关闭</button></div>
			</div>
		</li>
		<?php } else {?>
		<li class="layui-timeline-item">
			<i class="layui-icon layui-timeline-axis"></i>
			<div class="layui-timeline-content layui-text">
				<div class="layui-timeline-title">
					<?php $form = ActiveForm::begin(['id' => 'off-form','action' => '/message/infooff']); ?>
					<div class="layui-form-item" style="float: left;">
						<div class="layui-input-block" style="float: left;margin-left:0px;margin-right: 20px;">
							<input type="hidden" name="msg_id" value="<?=$info['id']?>">
							<button class="layui-btn" lay-submit="" lay-filter="demo1" id="but">关闭问题</button>
						</div>
						<div style="float: left;" class="layui-form-mid layui-word-aux" id="msg_but">如问题已经解决,请点击关闭问题按钮!</div>
					</div>
					<?php ActiveForm::end(); ?>
				</div>
			</div>
		</li>
		<?php }?>
	</ul>
    <?php if($info['flag']==0) :?>
    <?php $form = ActiveForm::begin(['id' => 'info-form','action' => '/message/infoform1']); ?>
    <div class="layui-form layui-form-pane" style="margin-top:20px;">
        <div class="layui-form-item">
            <label class="layui-form-label" name="jxtw">继续提问：</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入问题内容" name="content" id="content" lay-verify="required" class="layui-textarea"></textarea>
                <input type="hidden" name="parent_id" value="<?=$info['id']?>">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_content"></div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block" style="margin-right: 20px;">
                <button class="layui-btn" lay-submit="" id="but1" lay-filter="demo1">提交</button>
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_but1"></div>
        </div>
    </div>
    <?php ActiveForm::end();?>
    <script>
        layui.use(['form'], function(){
            //监听提交
            $('#info-form').bind('submit', function(){
                /* 提交数据 */
				$(this).ajaxSubmit({
					type: 'post',
					url: $(this).attr('action'),
					dataType : "json",
					data: {},
					success: function(d) {
						if(d.s === 1){
							layer.msg(d.m, {icon: 1});
							if(d.u != ''){
								setTimeout("window.location.reload()",2000);
							}
						}else{
							layer.msg(d.m, {icon: 0});
						}
						isSub = false;
					},
					beforeSend:function(d){
						isSub = true;
					}
				});
                return false;
            });

            //关闭问题提交
            $('#off-form').bind('submit', function(){
                $(this).ajaxSubmit({
                    type: 'post',
                    url: $(this).attr('action'),
                    dataType: "json",
                    data: {},
                    success: function (da) {
                        if(da.ok.cod==1){
                            layer.msg('已关闭',{icon: 1});
                            $("#but").addClass("layui-btn-disabled");
							setTimeout("window.location.reload()",1000);
                        }else{
                            if(da.msg_button.cod!=0){
                                //layui-btn-disabled
                                $("#but").addClass("layui-btn-disabled");
                                $("#msg_but").html("<span class='red'>"+da.msg_button.msg+"</span>");
								setTimeout("window.location.reload()",1000);
                            }
                        }
                    }
                });
                return false;
            });
        });
    </script>
    <?php endif;?>
</div>
