<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
<div class="row font_color_333" style="background:#<?php if ($key%2 == 1) {?>fffcee<?php } else {?>fff<?php }?>;">
	<div class="col-50"><span class="font_color_666">周期：</span><?=$val['scount'];?></div>
	<div class="col-50"><span class="font_color_666">开始时间：</span><?=date("Y-m-d",$val['stime']);?></div>
	<div class="col-50"><span class="font_color_666">下发总金额：</span><?=$val['bonus'];?></div>
	<div class="col-50"><span class="font_color_666">结束时间：</span><?=date("Y-m-d",$val['etime']);?></div>
	<div class="col-50"></div>
	<div class="col-50" style="text-align: right;">
		<span class="font_color_666"></span>
		<a href="<?= Url::to('/integral/details?scount='.$val['scount']); ?>" class="href_">详情</a>
	</div>
</div>
<?php } ?>