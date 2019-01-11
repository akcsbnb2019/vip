<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
  <div class="row font_color_333" style="background:#<?php if ($key%2 == 1) {?>fffcee<?php } else {?>fff<?php }?>;">
	<div class="col-100 m_p_b font_size_16"><span class="font_color_666">注册时间：<?=$val['addtime']; ?></span></div>
	<div class="col-50"><span class="font_color_666">会员编号：</span><?=$val['loginname'];?></div>
	<div class="col-50"><span class="font_color_666">级别：</span><?php if($val['standardlevel']>0){echo "VIP".$val['standardlevel'];}else{echo "普通";} ?></div>
	<div class="col-50"><span class="font_color_666">推荐人：</span><?=$val['rid'];?></div>
	<div class="col-50"><span class="font_color_666">安置人：</span><?=$val['pid'];?></div>
	<div class="col-50"><span class="font_color_666">会员昵称：</span><?=$val['truename'];?></div>
	<div class="col-50"><span class="font_color_666">电话：</span><?=$val['tel'];?></div>
	<div class="col-20"></div><div class="col-20"></div><div class="col-20"></div><div class="col-20"></div>
	<div class="col-20">
		<a href="?username=<?=$val['loginname']?>" class="button button-fill color-blue href_">查看</a>
	</div>
  </div>
<?php } ?>
