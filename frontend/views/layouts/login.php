<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);

AppAsset::addCss($this, 'animate.min');
AppAsset::addCss($this, 'style.min');
AppAsset::addCss($this, 'login.min');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<meta name="keywords" content="<?= Html::encode($this->title) ?>" />
    <meta name="description" content="<?= Html::encode($this->title) ?>" />
    <link rel="shortcut icon" href="/favicon.ico">
    <!--[if lt IE 9]>
    <script>
        location.href = location.href+'?ie=1';
    </script>
    <![endif]-->
	<!-- load css -->
    <?php $this->head() ?>
</head>
<body class="signin">
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
