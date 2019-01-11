<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;

?>
<?php foreach($model as $key=>$val){?>
    <tr>
        <td>
        <?php if($val['incomeId'] == 0){?>
        	<input type="checkbox" value="<?= $val['id']?>" class="id">
		<?php }?>
		</td>
        <td><?= $val['user']?></td>
        <td><?= $val['createdTime']?></td>
        <td><?= $val['money']?></td>
        <td><?= $val['memo']?></td>
        <td><a href="http://bd.yhr001.net/upload/recharge/<?= $val['img']?>" target="_blank"><img class="jietu" src="http://47.95.227.79:91/upload/recharge/<?= $val['img']?>"/></a></td>
        <td>
			<?php if($val['incomeId'] == 0){?>
                <button class="layui-btn layui-btn-danger layui-btn-mini" id="del">取消</button>
                <button class="layui-btn  layui-btn-mini" id="up2">下发</button>
			<?php }else if($val['incomeId'] == -1){?>未通过
			<?php }else if($val['incomeId'] == -2){?>用户取消
			<?php }else if($val['incomeId'] > 0){?>通过
			<?php }?>
        </td>
    </tr>
<?php } ?>