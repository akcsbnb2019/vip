<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<meta name="keywords" content="<?= Html::encode($this->title) ?>" />
    <meta name="description" content="<?= Html::encode($this->title) ?>" />
    <meta name="Author" content="kml" />
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link rel="Shortcut Icon" href="/favicon.ico" />
	
	<!-- load css -->
	<link rel="stylesheet" type="text/css" href="/layui/uio/css2/layui.css" media="all">
	<link rel="stylesheet" type="text/css" href="/css/boot/bootstrap.min.css" media="all">
  	<link rel="stylesheet" type="text/css" href="/css/global2.css" media="all">
  	<link rel="stylesheet" type="text/css" href="/css/pc/common.css" media="all">
  	<link rel="stylesheet" type="text/css" href="/css/personal.css" media="all">
	<!-- load js -->
	<script type="text/javascript" src="/newA/layui/layui.js"></script>
	<script type="text/javascript" src="/js/plus/jquery-1.12.4.min.js"></script>
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/public.js"></script>
</head>
<body>
<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>