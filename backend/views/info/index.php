<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '列表 - 站内信';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="larry-grid">
	<div class="larry-personal">
	    <div class="layui-tab">
            <blockquote class="layui-elem-quote mylog-info-tit">
                <ul class="layui-tab-title">
					<li class="layui-btn layui-this"><i class="layui-icon">&#xe60a;</i>站内信列表</li>
				</ul>
            </blockquote>
            <div class="larry-separate"></div>
		    <div class="layui-tab-content larry-personal-body clearfix mylog-info-box">
		    <div class="layui-form" id="forms">
		    	<?php $form = ActiveForm::begin(['id' => 'menu-form']); ?>
              	搜索ID：
              	<div class="layui-inline">
                	<input class="layui-input" name="s" id="search">
              	</div>
              	<button class="layui-btn" data-type="reload">搜索</button>
              	<?php ActiveForm::end(); ?>
            </div>
		         <!-- 菜单列表 -->
                <div class="layui-tab-item layui-field-box layui-show">
                     <table class="layui-table table-hover" lay-even="" lay-skin="nob" id="lists">
                          <thead>
                              <tr>
                                  <th><input type="checkbox" id="selected-all"></th>
                                  <th>ID</th>
                                  <th>发送人</th>
                                  <th>标题</th>
                                  <th>提交时间</th>
                                  <th>状态</th>
                                  <th>操作</th>
                              </tr>
                          </thead>
                          <tbody id="tbodys">
							  <?php foreach($model as $key=>$val){?>
							  <tr>
								<td><input type="checkbox" value="<?= $val['id']?>" class="id"></td>
								<td><?= $val['id']?></td>
								<td><?= $val['loginname']?></td>
								<td><?= $val['title']?></td>
								<td><?= date('Y-m-d H:i:s',$val['addtime'])?></td>
								<td>
								<?php if($val['flag']){?>
								<button class="layui-btn layui-btn-disabled layui-btn-mini">已关闭</button>
								<?php }else{?>
								<button class="layui-btn layui-btn-danger layui-btn-mini" id="up2">关闭</button>
								<?php }?>
								</td>
								<td>
							    <button class="layui-btn  layui-btn-mini" id="edit">查看<?php if ($val['states'] == 1 || $val['states'] == 3) {?><span class="layui-badge-dot"></span><?php }?></button>
								<!-- <button class="layui-btn layui-btn-danger layui-btn-mini" id="del">删除</button> -->
								</td>
							  </tr>
							  <?php } ?>
                          </tbody>
                     </table>
                     <div class="larry-table-page clearfix">
                          <!-- <a href="javascript:;" class="layui-btn layui-btn-small" id="delall"><i class="iconfont icon-shanchu1"></i>删除</a> -->
				          <div id="page" class="page"></div>
			         </div>
			    </div>
		    </div>
		</div>
	</div>
</section>
<link rel="stylesheet" type="text/css" href="/layui/uio/css2/layui.css" media="all">
<script language="JavaScript" src="/js/pc/pagePost30.js"></script>
<script type="text/javascript">
var num   = '<?= $page->totalCount ?>';
var page  = '<?= ($page->page)+1 ?>';
var limit = <?= $page->defaultPageSize ?>;
Urs   = '<?= Url::to('/'.THISID.'/'); ?>';
layui.use(['layer','element'],function(){
    window.layer = layui.layer;
    var element = layui.element();
});
editU = '<?= Url::to('/'.THISID.'/edit'); ?>?cid=0';
delU = '<?= Url::to('/'.THISID.'/del'); ?>?cid=0';
</script>