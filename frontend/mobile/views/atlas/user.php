<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="app">
	<div class="page">
	<!-- 头部 -->
	<?= $this->render('/layouts/head.php'); ?>
	<!-- 头部 -->
        <div class="page-content">
		  <?php
			$form = ActiveForm::begin([
				'id' => 'select-form',
				'method'=>'post',
				'fieldConfig'=>['template'=> "{input}"]
			]);
		  ?>
		  <div class="searchbar row hytp_searchbar no-gutter">
			<div class="search-input col-80">
			  <label class="icon icon-search" for="search"></label>
			  <?= $form->field($user, 'loginname')->textInput(['autofocus' => true,'placeholder'=>"请输入要查找的用户名"]) ?>
			</div>
			<?= Html::submitButton('查询', ['class' => 'button button-fill button-primary col-20 ht_40', 'name' => 'login-button']) ?>
		  </div>
		  <?php ActiveForm::end(); ?>

		  <div class="tp">
			<div class="tp_top"><?php if($model['user']['standardlevel']>0) : ?><img src="/img/vip.png" class="tx"><?php else:?><img src="/img/no-vip.png" class="tx"><?php endif;?></div>
			<div class="tp_bt tp_bt2 bg_fff">
				<div class="user text_center font_size_16"><a class="href_" href="/atlas/user?id=<?=$model['user']['id']?>"><?=$model['user']['loginname']?></a> <?php if($model['user']['standardlevel']>0) : ?><img class="v" src="/img/v<?=$model['user']['standardlevel']?>.png" ><?php endif;?></div>
				<div class="user text_center pd_b_7">总消费：<?=$model['user']['pay_points_all']?></div>
				<div class="row text_center border_bt pd_b_7 m_b_7">
				  <div class="col-50">左区</div>
				  <div class="col-50">右区</div>
				</div>
				<div class="row border_bt pd_b_7 m_b_7">
				  <div class="col-33 text_left"><?=$model['user']['num1']?></div>
				  <div class="col-33 text_center">会员数量</div>
				  <div class="col-33 text_right"><?=$model['user']['num2']?></div>
				</div>
				<div class="row pd_b_7 border_bt">
				  <div class="col-35 text_left" style="word-wrap:break-word"><?=$model['user']['lallyeji']?></div>
				  <div class="col-30 text_center">消费业绩</div>
				  <div class="col-35 text_right" style="word-wrap:break-word"><?=$model['user']['rallyeji']?></div>
				</div>
			</div>
		  </div>
		  
		  <?php if(empty($model['left']['loginname'])) : ?>
		  <div class="tp tp2">
			<div class="tp_top"><a class="href_" href="/user/reg?pid=<?=$model['user']['id']?>&area=1"><img src="/img/add_user.png" class="tx"></a><img src="/mobile/img/xx_1.png" class="xx_1"/></div>
			<div class="tp_bt bg_fff">
				<p>尚未有会员信息~</p>
			</div>
		  </div>
		  <?php else:?>
		  <div class="tp tp2">
			<div class="tp_top"><?php if($model['left']['standardlevel']>0) : ?><img src="/img/vip.png" class="tx"><?php else:?><img src="/img/no-vip.png" class="tx"><?php endif;?><img src="/mobile/img/xx_1.png" class="xx_1"/></div>
			<div class="tp_bt bg_fff">
				<div class="user text_center font_size_16"><a class="href_" href="/atlas/user?id=<?=$model['left']['id']?>"><?=$model['left']['loginname']?> <?php if($model['left']['standardlevel']>0) : ?><img class="v" src="/img/v<?=$model['left']['standardlevel']?>.png" ><?php endif;?></a></div>
				<div class="user text_center pd_b_7">总业绩：<?=$model['left']['pay_points_all']?></div>
				<div class="text_center border_bt pd_b_7 m_b_7">左区</div>
				<div class="row border_bt pd_b_7 m_b_7">
				  <div class="col-50 text_left">会员数量</div>
				  <div class="col-50 text_right"><?=$model['left']['num1']?></div>
				</div>
				<div class="row pd_b_7 border_bt m_b_7">
				  <div class="col-50 text_left">消费业绩</div>
				  <div class="col-50 text_right" style="word-wrap:break-word"><?=$model['left']['lallyeji']?></div>
				</div>
				<div class="text_center border_bt pd_b_7 m_b_7">右区</div>
				<div class="row border_bt pd_b_7 m_b_7">
				  <div class="col-50 text_left">会员数量</div>
				  <div class="col-50 text_right"><?=$model['left']['num2']?></div>
				</div>
				<div class="row pd_b_7 border_bt">
				  <div class="col-50 text_left">消费业绩</div>
				  <div class="col-50 text_right" style="word-wrap:break-word"><?=$model['left']['rallyeji']?></div>
				</div>
			</div>
		  </div>
		  <?php endif;?>
		  
		  <?php if(empty($model['right']['loginname'])) : ?>
		  <div class="tp tp3">
			<div class="tp_top"><a class="href_" href="/user/reg?pid=<?=$model['user']['id']?>&area=2"><img src="/img/add_user.png" class="tx"></a><img src="/mobile/img/xx_2.png" class="xx_2"/></div>
			<div class="tp_bt bg_fff">
				<p>尚未有会员信息~</p>
			</div>
		  </div>
		  <?php else:?>
		  <div class="tp tp3">
			<div class="tp_top"><?php if($model['right']['standardlevel']>0) : ?><img src="/img/vip.png" class="tx"><?php else:?><img src="/img/no-vip.png" class="tx"><?php endif;?><img src="/mobile/img/xx_2.png" class="xx_2"/></div>
			<div class="tp_bt bg_fff">
				<div class="user text_center font_size_16"><a class="href_" class="href_" href="/atlas/user?id=<?=$model['right']['id']?>"><?=$model['right']['loginname']?></a> <?php if($model['right']['standardlevel']>0) : ?><img class="v" src="/img/v<?=$model['right']['standardlevel']?>.png" ><?php endif;?></div>
				<div class="user text_center pd_b_7">总业绩：<?=$model['right']['pay_points_all']?></div>
				<div class="text_center border_bt pd_b_7 m_b_7">左区</div>
				<div class="row border_bt pd_b_7 m_b_7">
				  <div class="col-50 text_left">会员数量</div>
				  <div class="col-50 text_right"><?=$model['right']['num1']?></div>
				</div>
				<div class="row pd_b_7 border_bt m_b_7">
				  <div class="col-50 text_left">消费业绩</div>
				  <div class="col-50 text_right" style="word-wrap:break-word"><?=$model['right']['lallyeji']?></div>
				</div>
				<div class="text_center border_bt pd_b_7 m_b_7">右区</div>
				<div class="row border_bt pd_b_7 m_b_7">
				  <div class="col-50 text_left">会员数量</div>
				  <div class="col-50 text_right"><?=$model['right']['num2']?></div>
				</div>
				<div class="row pd_b_7 border_bt">
				  <div class="col-50 text_left">消费业绩</div>
				  <div class="col-50 text_right" style="word-wrap:break-word"><?=$model['right']['rallyeji']?></div>
				</div>
			</div>
		  </div>
		  <?php endif;?>

        </div>
    </div>
	<!-- 菜单 -->
	<?= $this->render('/layouts/head_menu.php'); ?>
	<!-- 菜单 -->
</div>
<script type="text/javascript">
	function isoff(id) {
		$.get("/message/infooff?id=" + id, function (d) {
		   layer.msg(d.msg, {icon: d.status,});
		});
	}
</script>