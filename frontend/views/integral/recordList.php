<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
<tr>
    <td class="pabc"><?=$val['scount'];?></td>
    <td><?=date("Y-m-d",$val['stime']);?></td>
    <td><?=date("Y-m-d",$val['etime']);?></td>
    <td><?=$val['bonus'];?></td>
    <td><a href="<?= Url::to('/integral/details?scount='.$val['scount']); ?>">详情</a></td>
</tr>
<?php } ?>
