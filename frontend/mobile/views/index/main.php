<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;
use frontend\assets\WapAsset;
use yii\helpers\Url;

WapAsset::register($this);

if (!$vfi2) {
	WapAsset::WapJs($this, 'mVerify2');
}
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">

	<div class="list list_n media-list bg_fff list_xiu xiu10">
	  <ul>
		<li>
		  <div class="item-content">
			<div class="item-media toux"><a href="/user/info" class="href_"> <img src="/img/main-t.png" /></a></div>
			<div class="item-inner font_color_666">
			  <div class="item-subtitle">用户编号：<?=$model['loginname']?></div>
			  <div class="item-subtitle">用户级别：<?php if($model['standardlevel']>0):?>VIP<?=$model['standardlevel']?>会员<?php else:?>普通会员<?php endif;?>
			  </div>
			  <?php if($model['yuanshigu']>0):?>
			  <div class="item-subtitle">福利会员：<?php if($model['yuanshigu']>0){?>福利会员 <img src="/img/main-info.png"><?php }else{ echo "无"; }?></div>
			  <?php endif;?>
			  <?php if($model['position'] > 0):?>
			  <div class="item-subtitle">用户职位：
			  	<a href="/user/position?uid=<?=Yii::$app->session->get('__id')?>" class="href_"><?=$model['positions']?> 
			  	<img src="/img/<?=$model['position']?>.png" height=18 style="margin-bottom:-3px;"/></a>
              </div>
			  <?php endif;?>
			</div>
		  </div>
		</li>
	  </ul>
	</div>
	<?php if($model['yuanshigu']>0):?>
	<div><p class="block_n bg_fff color-41abe2"><a href="/user/stockcert" class="href_">查看股权证书</a></p></div>
	<?php endif;?>
	<div class="row m_b_16 bg_fff">
		<div class="col-33 tablet-15 demo-icon">
		  <div class="demo-icon-icon"><i class="f7-icons color-home-fill">home_fill</i></div>
		  <div class="demo-icon-name"><a href="/funds/transfer" class="href_">转账</a></div>
		</div>
		<div class="col-33 tablet-15 demo-icon">
		  <div class="demo-icon-icon"><i class="f7-icons color-card-fill">card_fill</i></div>
		  <div class="demo-icon-name"><a href="/integral/exchange/?type=1" class="href_">提现</a></div>
		</div>
		<div class="col-33 tablet-15 demo-icon">
		  <div class="demo-icon-icon"><i class="f7-icons color-money-yen-fill">money_yen_fill</i></div>
		  <div class="demo-icon-name"><a href="/integral/exchange" class="href_">兑换</a></div>
		</div>
	</div>

	<div class="block-title bg_fff block-title-n"><a href="<?= Url::to('/news/index'); ?>" class="href_"><span class="font_color_666">系统公告</span><b class="font_color_666">更多></b></a></div>
	<div class="list ind_xtgg_list accordion-list bg_fff">
	  <ul>
	    <?php foreach($neirong as $key=>$val){?>
		<li class="accordion-item">
		  <a href="/news/info?id=<?= $val['ArticleID']?>" class="item-link item-content href_">
			<div class="item-inner">
			  <div class="item-title color-41abe2"><?=$val['title']?></div>
			</div>
		  </a>
		</li>
		<?php }?>
	  </ul>
	</div>

</div>