<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
  <div class="row font_color_333" style="background:#<?php if ($key%2 == 1) {?>fffcee<?php } else {?>fff<?php }?>;">
	<div class="col-50"><span class="font_color_666">会员编号：</span><?=$val['loginname'];?></div>
	<div class="col-50"><span class="font_color_666">积分：</span><?=$val['points'];?></div>
	<div class="col-50"><span class="font_color_666">比例：</span><?=$val['pre'];?></div>
	<div class="col-50"><span class="font_color_666">时间：</span><?=date("Y-m-d",$val['addtime']);?></div> 
  </div>
<?php } ?>