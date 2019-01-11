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
	<td><?= $val['username']?></td>
	<td><?= $val['stocks']?></td>
	<td><?= $val['yyje']?></td>
	<td><?= $val['bfje']/$val['stocks']?></td>
	<td><?= $val['bfje']?></td>
	<td><?= $val['addtime']?></td>
</tr>
<?php } ?>