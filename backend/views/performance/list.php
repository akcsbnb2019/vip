<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\bootstrap\ActiveForm;
?>
<?php foreach($model as $key=>$val){?>
  <tr>
	<td><input type="checkbox" value="<?= $val['id']?>" class="id"></td>
	<td><?= $val['id']?></td>
	<td><?= $val['userid']?></td>
	<td><?= $val['amount']?></td>
  </tr>
<?php } ?>