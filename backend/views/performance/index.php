<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '列表 - 管理员';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="larry-grid">
	<div class="larry-personal">
	    <div class="layui-tab">
            <blockquote class="layui-elem-quote mylog-info-tit">
                <ul class="layui-tab-title">
					  <li class="layui-btn layui-this"><i class="layui-icon">&#xe60a;</i>列表</li>
				</ul>
            </blockquote>
            <div class="larry-separate"></div>
		    <div class="layui-tab-content larry-personal-body clearfix mylog-info-box">
				<div class="layui-form" id="forms">
					<?php $form = ActiveForm::begin(['id' => 'search-form']); ?>
					搜索ID：
					<div class="layui-inline">
						<input class="layui-input" name="s" id="s" value="<?=(isset($_POST['s'])?$_POST['s']:'')?>">
					</div>
					开始时间：
					<div class="layui-inline">
						<input type="text" name="begtime" id="begtime" class="layui-input" value="<?=(isset($_POST['begtime'])?$_POST['begtime']:'')?>" msg="开始时间">
					</div>
					结束时间：
					<div class="layui-inline">
						<input type="text" name="endtime" id="endtime" class="layui-input" value="<?=(isset($_POST['endtime'])?$_POST['endtime']:'')?>" msg="开始时间">
					</div>
					<button class="layui-btn" data-type="reload">搜索</button>
					<div class="layui-inline">
					  <input type="checkbox" name="types[]" value="爱心基金" lay-skin="primary" title="爱心基金">
					  <input type="checkbox" name="types[]" value="管理积分" lay-skin="primary" title="管理积分">
					  <input type="checkbox" name="types[]" value="销售积分" lay-skin="primary" title="销售积分">
					  <input type="checkbox" name="types[]" value="股权基金" lay-skin="primary" title="股权基金">
					  <input type="checkbox" name="types[]" value="重消积分" lay-skin="primary" title="重消积分">
					  <input type="checkbox" name="types[]" value="代理费" lay-skin="primary" title="代理费">
					  <input type="checkbox" name="types[]" value="邀请积分" lay-skin="primary" title="邀请积分">
					  <input type="checkbox" name="types[]" value="绩效积分" lay-skin="primary" title="绩效积分">
					</div>
					<?php if (isset($_POST['types'])) { foreach ($_POST['types'] as $v) {?>
					<script type="text/javascript">
					$("input[type='checkbox'][value=<?=$v?>]").attr("checked","checked" );
					</script>
					<?php }}?>
					<?php ActiveForm::end(); ?>
					<style>.layui-form-checkbox {margin:12px 0 0px 0;}</style>
				</div>
				<!-- 菜单列表 -->
				<div class="layui-tab-item layui-field-box layui-show">
					 <table class="layui-table table-hover" lay-even="" lay-skin="nob" id="lists">
						  <thead>
							  <tr>
								  <th><input type="checkbox" id="selected-all"></th>
								   <th>ID</th>
								  <th>会员编号</th>
								  <th>合计</th>
							  </tr>
						  </thead>
						  <tbody id="tbodys">
						  <?php foreach($model as $key=>$val){?>
							  <tr>
								<td><input type="checkbox" value="<?= $val['id']?>" class="id"></td>
								<td><?= $val['id']?></td>
								<td><?= $val['userid']?></td>
								<td><?= $val['amount']?></td>
							  </tr>
						  <?php } ?>
						  </tbody>
					 </table>
					 <div class="larry-table-page clearfix">
						  <div id="page" class="page"></div>
					 </div>
				</div>
		    </div>
		</div>
	</div>
</section>
<script type="text/javascript">
	layui.use('laydate', function(){
		var laydate = layui.laydate;
		laydate.render({
			elem: '#begtime',
			format: 'yyyy-MM-dd'
		});
		laydate.render({
			elem: '#endtime',
			format: 'yyyy-MM-dd'
		});
	});
</script>
<link rel="stylesheet" type="text/css" href="/layui/uio/css2/layui.css" media="all">
<script language="JavaScript" src="/js/pc/pagePost.js"></script>
<script type="text/javascript">
var num   = '<?= $page->totalCount ?>';
var page  = '<?= ($page->page)+1 ?>';
var limit = <?= $page->defaultPageSize ?>;
Urs   = '<?= Url::to('/'.THISID.'/'); ?>';
layui.use(['layer','element'],function(){
    window.layer = layui.layer;
    var element = layui.element();
    $(function(){
    	$('#search-form').bind('submit', function(){
    		var s = $('#s').val();
    		var b = $('#begtime').val();
    		var e = $('#endtime').val();
    		if(isNull(s) === false && isNull(b) === false && isNull(e) === false){
    			/* layer.msg('请输入至少一个查询条件！', {icon: 2});
				return false; */
    		}
    	});
    });
});
layui.use('form', function(){
  var form = layui.form;
});
</script>