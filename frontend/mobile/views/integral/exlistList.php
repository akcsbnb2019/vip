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
	<div class="col-50"><span class="font_color_666">积分：</span><?=$val['amount'];?></div>
	<div class="col-50"><span class="font_color_666">手续费：</span><?php if ($val['states']==8) { echo "-"; } else { echo $val['amount']-$val['get_amount']; } ?></div>
	<div class="col-50"><span class="font_color_666">兑换账户：</span><?=$val['bank'];?></div>
	<div class="col-50"><span class="font_color_666">帐号：</span><?=$val['bankno'];?></div>
	<div class="col-50"><span class="font_color_666">户名：</span><?=$val['bankuser'];?></div>
	<div class="col-50"><span class="font_color_666">备注：</span><?=$val['memo'];?></div>
	<div class="col-50"><span class="font_color_666">状态：</span><span class="font_color_5690fc"><?php if($val['states']=="1") {echo '已处理';} else if($val['states']=="8") {echo '自动处理';} else {echo '未处理';}?></span></div>
	<?php if(Yii::$app->request->get('funin')){ ?>
	<!--<div class="col-50">返回提现</div>-->
	<?php } ?>
  </div>
<?php } ?>