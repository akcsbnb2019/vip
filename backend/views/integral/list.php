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
	<td><?= $val['realname']?></td>
	<td><?= $val['LastLoginIP']?></td>
	<td><?= $val['LastLoginTime']?></td>
	<td><?= $val['sort']?></td>
	<td>
	<?php if($val['status']){?>
	<button class="layui-btn layui-btn-normal layui-btn-mini" id="up1">启用</button>
	<?php }else{?>
	<button class="layui-btn layui-btn-primary layui-btn-mini" id="up2">停用</button>
	<?php }?>
	</td>
	<td>
	<button class="layui-btn  layui-btn-mini" id="edit">编辑</button>
	<button class="layui-btn layui-btn-danger layui-btn-mini" id="del">删除</button>
	</td>
</tr>
<?php } ?>