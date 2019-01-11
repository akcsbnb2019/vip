<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
  <div class="row font_color_333" style="background:#<?php if ($key%2 == 1) {?>fffcee<?php } else {?>fff<?php }?>;">
	<div class="col-100 m_p_b font_size_16"><span class="font_color_666"><?=$val['change_time']; ?></span></div>
	<div class="col-50"><span class="font_color_666">转出会员：</span><?=$val['send_userid'];?></div>
	<div class="col-50"><span class="font_color_666">转入会员：</span><?=$val['to_userid'];?></div>
	<div class="col-50"><span class="font_color_666">转帐积分：</span><?=$val['to_userid'];?></div>
	<div class="col-50"><span class="font_color_666">转帐说明：</span><?=$val['why_change'];?></div>
	<div class="col-20"></div><div class="col-20"></div><div class="col-20"></div><div class="col-20"></div>
  </div>
<?php } ?>