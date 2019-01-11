<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
  <div class="row font_color_333" style="background:#<?php if ($key%2 == 1) {?>fffcee<?php } else {?>fff<?php }?>;">
	<div class="col-100 m_p_b font_size_16"><span class="font_color_666"><?=$val['addtimes']; ?></span></div>
	<div class="col-50"><span class="font_color_666">会员编号：</span><?=$val['userid'];?></div>
	<div class="col-50"><span class="font_color_666">股数：</span><?=$val['amount'];?></div>
	<div class="col-50"><span class="font_color_666">所需商城金额：</span><?=$val['amount']*10;?></div>
	<div class="col-50"><span class="font_color_666">状态：</span><span class="font_color_5690fc"><?php if($val['states']==1){ echo "已完成";}else{echo "未处理";}?></span></div>
  </div>
<?php } ?>