<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '列表 - 新闻';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="larry-grid">
	<div class="larry-personal">
	    <div class="layui-tab">
            <blockquote class="layui-elem-quote mylog-info-tit">
                <ul class="layui-tab-title">
		    	          <li class="layui-btn layui-this" onclick="javascript:location.href='<?= Url::to('/'.THISID); ?>';"><i class="layui-icon">&#xe60a;</i>新闻列表</li>
		    	          <a class="layui-btn layui-btn-small larry-log-del" href="javascript:;" onclick="parentHref(false,'<?= Url::to('/'.THISID.'/add'); ?>','添加新闻');"><i class="iconfont icon-huishouzhan1"></i>添加新闻</a>
		            </ul>
            </blockquote>
            <div class="larry-separate"></div>
		    <div class="layui-tab-content larry-personal-body clearfix mylog-info-box">
		    <div class="demoTable" id="forms">
		    	<?php $form = ActiveForm::begin(['id' => 'menu-form']); ?>
              	搜索ID：
              	<div class="layui-inline">
                	<input class="layui-input" name="s" id="search" value="<?=(isset($_POST['s'])?$_POST['s']:'')?>">
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
                                  <th>标题</th>
                                  <th>添加时间</th>
                                  <th>状态</th>
                                  <th>操作</th>
                              </tr>
                          </thead>
                          <tbody id="tbodys">
                          <?php foreach($model as $key=>$val){?>
                              <tr>
                                <td><input type="checkbox" value="<?= $val['ArticleID']?>" class="id"></td>
                                <td><?= $val['ArticleID']?></td>
                                <td><?= $val['title']?></td>
                                <td><?= $val['UpdateTime']?></td>
                                <td>
                                <?php if($val['status']){?>
                                <button class="layui-btn layui-btn-normal layui-btn-mini" id="up1">启用</button>
                                <?php }else{?>
                                <button class="layui-btn layui-btn-primary layui-btn-mini" id="up2">停用</button>
                                <?php }?>
                                </td>
                                <td>
                                <button class="layui-btn  layui-btn-mini" id="edit" title="编辑<?= mb_substr($val['title'],0,4,'utf-8');?>...">编辑</button>
                                <button class="layui-btn layui-btn-danger layui-btn-mini" id="del">删除</button>
                                </td>
                              </tr>
                          <?php } ?>
                          </tbody>
                     </table>
                     <div class="larry-table-page clearfix">
                          <a href="javascript:;" class="layui-btn layui-btn-small" id="delall"><i class="iconfont icon-shanchu1"></i>删除</a>
				          <div id="page" class="page"></div>
			         </div>
			    </div>
		    </div>
		</div>
	</div>
</section>
<!-- 分页用 -->
<link rel="stylesheet" type="text/css" href="/layui/uio/css2/layui.css" media="all">
<script language="JavaScript" src="/js/pc/pagePost.js"></script>
<script type="text/javascript">
var Urs   = '<?= Url::to('/'.THISID.'/'); ?>';
var addU  = '<?= Url::to('/'.THISID.'/add'); ?>?d=0';
var editU = '<?= Url::to('/'.THISID.'/edit'); ?>?d=0';
var num   = '<?= $page->totalCount ?>';
var page  = '<?= ($page->page)+1 ?>';
var limit = <?= $page->defaultPageSize ?>;
</script>