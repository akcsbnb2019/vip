<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '提示 - 会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>


<script language="JavaScript" >
var msg  = '<?=$msg ;?>';//提示字符串
var icon = '<?=(isset($model["icon"])?$model["icon"]:'') ;?>';//提示类型
var url  = '<?=(isset($model["url"])?$model["url"]:'') ;?>';//跳转链接



if(icon == ''){
	/* layer.msg(msg); */
	layer.open({
	  style: 'border:none; background-color:#fff; color:#40AFFE;',
	  content:msg
	})
}else{
	layer.open({
	  style: 'border:none; background-color:#fff; color:#f00;',
	  content:msg
	})
}
//延时跳转
if(url != ''){
	setTimeout("location.href='"+url+"';",1000);
}else{
	
}
</script>