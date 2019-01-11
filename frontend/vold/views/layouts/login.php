<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

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
    <link rel="stylesheet" href="/pc/css/global.css">
    <link rel="stylesheet" href="/pc/css/global_color.css">
    <link rel="stylesheet" href="/pc/layui/css/layui.css">
    <script src="/pc/js/jquery.min.js"></script>
    <script src="/js/jquery.form.min.js"></script>
    <script src="/pc/layui/layui.js"></script>
</head>
<body class="index">
<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
