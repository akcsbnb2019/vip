<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);

AppAsset::addCss($this, 'animate.min');
AppAsset::addCss($this, 'style.min862f');
AppAsset::addCss($this, 'index');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<meta name="keywords" content="<?= Html::encode($this->title) ?>" />
    <meta name="description" content="<?= Html::encode($this->title) ?>" />
    <link rel="shortcut icon" href="/favicon.ico">
    <!--[if lt IE 9]>
    <script>
        location.href = '/site?ie=1';
    </script>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
	<!-- load css -->
    <?php $this->head() ?>
</head>
<body class="fixed-sidebar full-height-layout gray-bg  pace-done boxed-layout" style="overflow:hidden">
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
