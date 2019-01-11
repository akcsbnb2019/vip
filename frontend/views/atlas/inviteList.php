<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
<tr>
<td class="pabc"><?=$val['loginname']; ?></td>
<td><?php if($val['standardlevel']>0){echo "VIP".$val['standardlevel'];}else{echo "普通";} ?></td>
<td><?=$val['rid']; ?></td>
<td><?=$val['pid']; ?></td>
<td><?=$val['truename'];?></td>
<td><?=$val['tel'];?></td>
<td><?=$val['addtime'];?></td>
<td class="text-navy"><a href="javascript:ckrid('<?=$val['loginname']; ?>')">查看</a></td>
</tr>
<?php } ?>
