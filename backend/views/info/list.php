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
<td><?= $val['loginname']?></td>
<td><?= $val['title']?></td>
<td><?= date('Y-m-d H:i:s',$val['addtime'])?></td>
<td>
<?php if($val['flag']){?>
<button class="layui-btn layui-btn-disabled layui-btn-mini">已关闭</button>
<?php }else{?>
<button class="layui-btn layui-btn-danger layui-btn-mini" id="up2">关闭</button>
<?php }?>
</td>
<td>
<button class="layui-btn  layui-btn-mini" id="edit">查看<?php if ($val['states'] == 1 || $val['states'] == 3) {?><span class="layui-badge-dot"></span><?php }?></button>
<!-- <button class="layui-btn layui-btn-danger layui-btn-mini" id="del">删除</button> -->
</td>
</tr>
<?php } ?>