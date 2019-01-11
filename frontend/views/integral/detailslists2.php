<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
<tr>
     <tr>
     <td class="pabc"><?=$val['loginname'];?></td>
      <td><?=$val['points'];?></td>
      <td><?=$val['pre'];?></td> 
      <td><?=date("Y-m-d",$val['addtime']);?></td>
    </tr>
</tr>
<?php } ?>
