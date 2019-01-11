<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;

?>

<?php foreach($model as $key=>$val){?>
    <tr>
        <td><input type="checkbox" value="<?= $val['id']?>" class="id"></td>

        <td><?= $val['userid']?></td>
        <td><?= $val['adddate']?></td>
        <td><?= $val['province']."-".$val['city']."-".$val['district']?></td>
        <td><?= $val['tel']?></td>
        <td>
			<?php if($val['status']){?>
                通过
			<?php }else{?>
                未通过
			<?php }?>
        </td>
        <td>
			<?php if($val['status']){?>
			<?php }else{?>
                <button class="layui-btn layui-btn-primary layui-btn-mini" id="up2">允许</button>
			<?php }?>
        </td>
    </tr>
<?php } ?>