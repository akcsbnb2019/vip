<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
<tr><td class="pabc"><?=$val['userid']; ?></td><td><?=$val['amount']; ?></td><td><?=$val['addtimes']; ?></td><td><?=$val['memo']; ?></td><td class="text-navy" colspan="2"><?php if($val['states']=="1") {echo '已处理';} else if($val['states']=="8") {echo '自动处理';} else {echo '未处理';}?></td></tr>
<?php } ?>
