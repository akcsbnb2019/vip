<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '列表 - 管理员角色';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="larry-grid">
	<div class="larry-personal">
	    <div class="layui-tab">
            <blockquote class="layui-elem-quote mylog-info-tit">
                <ul class="layui-tab-title">
		    	          <li class="layui-btn layui-this"><i class="layui-icon">&#xe60a;</i>角色列表</li>
		    	          <a class="layui-btn layui-btn-small larry-log-del" href="<?= Url::to('/'.THISID.'/add'); ?>"><i class="iconfont icon-huishouzhan1"></i>添加角色</a>
		            </ul>
            </blockquote>
            <div class="larry-separate"></div>
		    <div class="layui-tab-content larry-personal-body clearfix mylog-info-box">
		    <div class="demoTable" id="forms">
		    	<?php $form = ActiveForm::begin(['id' => 'menu-form']); ?>
              	搜索ID：
              	<div class="layui-inline">
                	<input class="layui-input" name="s" id="search">
              	</div>
              	<button class="layui-btn" data-type="reload">搜索</button><input name="_csrf-backend" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
              	<?php ActiveForm::end(); ?>
            </div>
		         <!-- 菜单列表 -->
                <div class="layui-tab-item layui-field-box layui-show">
                     <table class="layui-table table-hover" lay-even="" lay-skin="nob" id="lists">
                          <thead>
                              <tr>
                                  <th><input type="checkbox" id="selected-all"></th>
                                  <th>ID</th>
                                  <th>名称</th>
                                  <th>类型</th>
                                  <th>时间</th>
                                  <th>排序</th>
                                  <th>状态</th>
                                  <th>操作</th>
                              </tr>
                          </thead>
                          <tbody>
                          <?php foreach($model as $key=>$val){?>
                              <tr>
                                <td><input type="checkbox" value="<?= $val['id']?>" class="id"></td>
                                <td><?= $val['id']?></td>
                                <td><a href="<?= Url::to('/'.THISID.'/index?cid='.$val['id']); ?>" ><?= $val['name']?></a></td>
                                <td>
                                <?php if($val['type'] == 1){?>普通类型
                                <?php }else{?>高级类型
                                <?php }?>
                                </td>
                                <td><?= date('Y.m.d H:i',$val['add_time'])?></td>
                                <td><?= $val['sort']?></td>
                                <td>
                                <?php if($val['status']){?>
                                <button class="layui-btn layui-btn-normal layui-btn-mini" id="up1">启用</button>
                                <?php }else{?>
                                <button class="layui-btn layui-btn-primary layui-btn-mini" id="up2">停用</button>
                                <?php }?>
                                </td>
                                <td>
                                <button class="layui-btn layui-btn-warm layui-btn-mini" id="group">权限</button>
                                <button class="layui-btn  layui-btn-mini" id="edit">编辑</button>
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
<script type="text/javascript">
var thisIa = "<?= Url::to('/'.THISID.'/add'); ?>";
var thisIe = "<?= Url::to('/'.THISID.'/edit'); ?>";
var thisIg = "<?= Url::to('/'.THISID.'/upgroup'); ?>";
var addU  = thisIa+'?cid=0',editU = thisIe+'?d=i';
</script>
<input type="hidden" value="group" id="actions">