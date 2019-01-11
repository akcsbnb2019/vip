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
		    	          <li class="layui-btn layui-this" onclick="javascript:location.href='<?= Url::to('/'.THISID); ?>';"><i class="layui-icon">&#xe60a;</i>报单中心申请列表</li>
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
                                  <th></th>

                                  <th>用户名</th>
                                  <th>申请时间</th>
                                  <th>申请地区</th>
                                  <th>手机号</th>
                                  <th>状态</th>
                                  <th>操作</th>
                              </tr>
                          </thead>
                          <tbody id="tbodys">
                          <?php foreach($model as $key=>$val){?>
                              <tr>
                                  <td><input type="checkbox" value="<?= $val['id']?>" class="id"></td>

                                  <td><?= $val['userid']?></td>
                                <td><?= $val['adddate']?></td>
                                <td><?= $val['province']."-".$val['city']."-".$val['district']?></td>
                                <td><?= $val['tel']?></td>
                                <td>
                                <?php if($val['status']){?>
                                通过
                                <?php }else{?>
                                未通过
                                <?php }?>
                                </td>
                                  <td>
                                  <?php if($val['status']){?>
                                  <?php }else{?>
                                      <button class="layui-btn layui-btn-primary layui-btn-mini" id="up2">允许</button>
                                  <?php }?>
                                  </td>
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