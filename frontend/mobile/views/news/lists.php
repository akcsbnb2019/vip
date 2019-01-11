<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php foreach($model as $key=>$val){?>
<ul class="m_b_10 list_xiu">
	<li class="accordion-item bg_fff">
	  <a href="/news/info?id=<?= $val['ArticleID']?>" class="href_ item-link item-content" style="padding: 0 16px;">
		<div class="item-inner" style="background:none;padding-right:0;">
		  <div class="item-title color-41abe2"><?=$val['title'];?></div>
		</div>
		<div class="item-after"><?=$val['UpdateTime'];?></div>
	  </a>
	</li>
</ul>
<?php } ?>