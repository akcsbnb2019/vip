<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
<tr><td class="pabc"><?=$val['username']; ?></td><td><?=$val['stocks']; ?></td><td><?=$val['bfje']; ?></td><td class="text-navy"><?=$val['addtime'];?></td></tr>
<?php } ?>