<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cents">
    <?php $form = ActiveForm::begin(['id' => 'send-form','action' => '/message/sendform']); ?>
    <div class="layui-form layui-form-pane" style="padding:20px 0 0 0px;">
        <div class="layui-form-item">
            <label class="layui-form-label">标题：</label>
            <div class="layui-input-inline">
                <input type="text" name="title" id="title" placeholder="请输入标题" lay-verify="required"  autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_title"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">问题内容：</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入问题内容" name="content" id="content" lay-verify="required" class="layui-textarea"></textarea>
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_content"></div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <!--</form>-->
</div>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    layui.use(['form'], function(){
        //监听提交
        $('#send-form').bind('submit', function(){
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
							setTimeout("hrefload('"+d.u+"');",2000);
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
    });
	function hrefload(url)
	{
	   window.location.href = url;
	}
</script>