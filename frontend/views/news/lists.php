<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
<tr><td class="pabc"><a href="/news/info?id=<?= $val['ArticleID']?>"><?=$val['title'];?></a></td><td><?=$val['UpdateTime'];?></td><td class="text-navy"><a href="/news/info?id=<?= $val['ArticleID']?>">查看</a></td></tr>
<?php } ?>