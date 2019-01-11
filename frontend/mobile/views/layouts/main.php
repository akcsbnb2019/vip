<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\WapAsset;
use common\widgets\Alert;
WapAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <?= Html::csrfMetaTags() ?>
  
  <link rel="stylesheet" href="/mobile/css/framework7.min.css">
  <link rel="stylesheet" href="/mobile/css/app.css">
  <link rel="stylesheet" href="/mobile/css/menu.css">
  <!--
  <script src="/mobile/js/framework7.min.js"></script>
  <script src="/mobile/js/app.js"></script>
  <script src="/mobile/js/menu.js"></script>
  <script src="/js/plugins/layer/layer.min.js"></script>
  <script src="/mobile/js/public.js"></script>-->

  <title><?= Html::encode($this->title) ?></title>
</head>
<body>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>