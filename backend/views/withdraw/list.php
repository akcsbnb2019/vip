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
        <td><?= $val['bankuser']?></td>
        <td><?= $val['bank']?></td>
        <td><?= $val['bankno']?></td>
        <td><?= $val['amount']?></td>
        <td><?= $val['get_amount']?></td>
        <td><?= $val['addtimes']?></td>
        <td>
			<?php if($val['states']==8){?>
                兑换
			<?php }else{?>
                提现
			<?php }?>
        </td>
        <td>
			<?php if($val['states']==0){
				echo "未处理";
			}else{
				echo "已处理";
			}?>
        </td>
        <td>
			<?php if($val['states']==0){?>
                <button class="layui-btn layui-btn-normal layui-btn-mini" id="up2">处理</button>
                <button class="layui-btn layui-btn-danger layui-btn-mini" id="del">取消</button>
			<?php }?>
        </td>
        <!--<td>
		<button class="layui-btn  layui-btn-mini" id="edit">编辑</button>
		<button class="layui-btn layui-btn-danger layui-btn-mini" id="del">删除</button>
		</td>-->
    </tr>
<?php } ?>