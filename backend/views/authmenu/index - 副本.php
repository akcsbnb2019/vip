<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '列表 - 权限菜单';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="layui-fluid larry-wrapper">
    <blockquote class="layui-elem-quote larry-btn">
		<div class="layui-inline">
		    <div class="layui-input-inline">
		    	<input type="text" name="search" value="" id="search_input" placeholder="请输入网站名称进行查询" class="layui-input larry-search-input">
		    </div>
		    <a class="layui-btn search_btn" data-type="getSelect">查询</a>
		</div>
		<div class="layui-inline">
			<a class="layui-btn layui-bg-pale" data-type="addLink">添加链接</a>
		</div>
		<div class="layui-inline">
			<a class="layui-btn layui-btn-danger" data-type="delLink">批量删除</a>
		</div>
		<div class="layui-inline">
			<div class="layui-form-mid layui-word-aux">因时间仓促，本页面仅为静态示例页面，无后台服务端交互场景演示</div>
		</div>
	</blockquote>
	<!-- 友链数据列表 -->
	<div class="flinkTable">
		<table class="layui-hide" id="test"></table>
 
        <script type="text/html" id="switchTpl">
  <!-- 这里的 checked 的状态只是演示 -->
  <input type="checkbox" name="子集" id="subset" value="{{d.name}}" lay-skin="switch" lay-text="有|无" lay-filter="sexDemo" {{ d.subset == 1 ? 'checked' : '' }}>
        </script>
         
        <script type="text/html" id="checkboxTpl">
  <!-- 这里的 checked 的状态只是演示 -->
  <input type="checkbox" name="状态" value="{{d.name}}" title="启用" lay-filter="lockDemo" {{ d.status == 1 ? 'checked' : '' }}>
        </script>
	</div>
	
	

</div>
 

<input type="hidden" value="table1" id="actions">
</body>
</html>