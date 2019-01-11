<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
  <div class="row font_color_333" style="background:#<?php if ($key%2 == 1) {?>fffcee<?php } else {?>fff<?php }?>;">
	<div class="col-100 m_p_b font_size_16"><span class="font_color_666"><?=$val['addtime']; ?></span></div>
	<div class="col-50"><span class="font_color_666">会员编号：</span><?=$val['username'];?></div>
	<div class="col-50"><span class="font_color_666">拥有股数：</span><?=$val['stocks'];?></div>
	<div class="col-50"><span class="font_color_666">发放金额：</span><?=$val['bfje'];?></div>
  </div>
<?php } ?>