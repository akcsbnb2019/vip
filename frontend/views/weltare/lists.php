<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
<tr><td class="pabc"><?=$val['userid']; ?></td><td><?=$val['amount']; ?></td><td><?=$val['amount']*10; ?></td><td><?=$val['addtimes'];?></td><td colspan="2" class="text-navy"><?php if($val['states']==1){ echo "已完成";}else{echo "未处理";}?></td></tr>
<?php } ?>