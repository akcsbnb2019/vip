<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
    <tr>
    <td class="pabc"><?=$val['addtime']; ?></td>
    <td><?=$val['types']; ?></td>
    <td><?=$val['amount'];?></td>
    </tr>
<?php } ?>
