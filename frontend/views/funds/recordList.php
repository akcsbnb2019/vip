<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
    <tr>
        <td class="pabc"><?=$val['send_userid']=='0'?"管理员":$val['send_userid']; ?></td>
        <td><?=$val['to_userid']=='0'?"管理员":$val['to_userid']; ?></td>
    <td><?=$val['money']; ?></td>
    <td class="text-navy"><?=$val['why_change'];?></td>
    <td colspan="2"><?=$val['change_time'];?></td>
    </tr>
<?php } ?>
