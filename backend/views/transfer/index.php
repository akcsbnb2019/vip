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
					<li class="layui-btn layui-this"><i class="layui-icon">&#xe60a;</i><?=$head['title']?></li>
				</ul>
            </blockquote>
            <div class="larry-separate"></div>
		    <div class="layui-tab-content larry-personal-body clearfix mylog-info-box">
		    <div class="layui-form" id="forms">
		    	<?php $form = ActiveForm::begin(['id' => 'menu-form','action'=>['transfer/index']]); ?>
				开始时间：
				<div class="layui-inline">
					<input type="text" name="begtime" id="begtime" class="layui-input" value="<?=(isset($_REQUEST['begtime'])?$_REQUEST['begtime']:'')?>" msg="开始时间">
				</div>
				结束时间：
				<div class="layui-inline">
					<input type="text" name="endtime" id="endtime" class="layui-input" value="<?=(isset($_REQUEST['endtime'])?$_REQUEST['endtime']:'')?>" msg="开始时间">
				</div>
              	转出会员：
              	<div class="layui-inline">
                	<input type="text" name="s" class="layui-input" value="<?= isset($_REQUEST['s']) ? $_REQUEST['s'] :''?>">
              	</div>
				转入会员：
              	<div class="layui-inline">
                	<input type="text" name="r" class="layui-input" value="<?= isset($_REQUEST['r']) ? $_REQUEST['r'] :''?>">
              	</div>
              	<button class="layui-btn" data-type="reload">搜索</button><input name="_csrf-backend" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
              	<?php ActiveForm::end(); ?>
            </div>
		         <!-- 菜单列表 -->
                <div class="layui-tab-item layui-field-box layui-show">
                     <table class="layui-table table-hover" lay-even="" lay-skin="nob" id="lists">
                          <thead>
                              <tr>
                                  <th width="10%">转出会员</th>
                                  <th width="10%">转入会员</th>
                                  <th width="20%">转入会员姓名</th>
                                  <th width="10%">转账金额</th>
                                  <th width="30%">备注</th>
                                  <th width="15%">时间</th>
                              </tr>
                          </thead>
                          <tbody id="tbodys">
                          <?php foreach($model as $key=>$val){?>
                              <tr>
                                <td><?= $val['send_userid']?></td>
                                <td><?= $val['to_userid']?></td>
                                <td><?= $val['truename']?></td>
                                <td><?= $val['money']?></td>
                                <td><?= $val['why_change']?></td>
                                <td><?= $val['change_time']?></td>
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
});
</script>