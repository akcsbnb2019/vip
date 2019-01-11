<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
	use yii\helpers\Url;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
    <tr>
        <td class="pabc"><?=$val['scount'];?></td>
        <td><?=date("Y-m-d",$val['stime']);?></td>
        <td><?=date("Y-m-d",$val['etime']);?></td>
        <td><?=$val['zong'];?></td>
        <td>
            <input type="hidden" id="id" class="id" value="<?=$val['id']?>">
            <a href="<?= Url::to('/user/details?id='.$id.'&scount='.$val['scount']); ?>" class="layui-btn  layui-btn-mini" id="absedit">详情</a>
        </td>
    </tr>
<?php } ?>
