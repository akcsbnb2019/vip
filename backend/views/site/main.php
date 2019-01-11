<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'main';
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" type="text/css" href="/layui/uio/css2/layui.css" media="all">

<script type="text/javascript">
layui.use(['layer','laypage','form'], function(){
	window.layer = layui.layer;
	$(function(){
		<?php if($type == 2){ ?>
		layer.confirm('您无权访问或长时间没操作!', {
			  btn: ['重新登录', '返回首页']
			}, function(index, layero){
				stoHref('/site/login');
			}, function(index){
				stoHref('/index');
			});
		<?php }else{ ?>
		layer.msg('无权访问！', {icon: 0,time:60000});
		<?php }?>
	});
});
</script>


