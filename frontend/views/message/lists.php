<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\bootstrap\ActiveForm;
?>
<?php foreach($model as $key=>$val){?>
<tr>
	<td><?=$val['title']; ?></td>
	<td><?= date('Y-m-d H:i:s',$val['addtime'])?></td>
	<td><?=$val['flag']==1?"已解决":"未解决"; ?></td>
	<td><a href="/message/messageinfo?id=<?=$val['id']?>">查看<?php if ($val['states'] == 2) {?><span class="layui-badge-dot"></span><?php }?></a></td>
</tr>
<?php } ?>