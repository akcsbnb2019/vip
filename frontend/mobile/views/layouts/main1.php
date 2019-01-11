<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

use common\widgets\Alert;

use frontend\assets\WapAsset;

WapAsset::register($this);
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

    
    <script src="/pc/js/jquery.min.js"></script>
    <script src="/js/jquery.form.min.js"></script>
	<!-- <link rel="stylesheet" href="/pc/layui/css/layui.css">
    <script src="/pc/layui/lay/dest/layui.all.js"></script> -->
	<script src="/js/plugins/layer_mobile/layer.js"></script>
</head>
<body class="index">
<?= $content ?>
</body>
</html>
