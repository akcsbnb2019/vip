<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\bootstrap\ActiveForm;
?>
<?php foreach($model as $key=>$val){?>
  <tr>
	<td><?= $val['send_userid']?></td>
	<td><?= $val['to_userid']?></td>
	<td><?= $val['truename']?></td>
	<td><?= $val['money']?></td>
	<td><?= $val['why_change']?></td>
	<td><?= $val['change_time']?></td>
  </tr>
<?php } ?>