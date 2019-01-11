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
			<div class="searchbar row hytp_searchbar no-gutter xiu3 xiu7 xiu8">
				<div class="search-input col-50 xiu6">
				  <label class="icon icon-search" for="search"></label>
				  <?= $form->field($message, 'title1')->textInput(['autofocus' => true,'placeholder'=>"请输入要查询的问题"]) ?>
				</div>
				<?= Html::submitButton('查询', ['class' => 'button button-fill button-primary col-20 ht_40', 'name' => 'login-button']) ?>
				<a href="/message/send" class="button button-fill button-primary col-30 href_">新增留言</a>
			</div>
			<?php ActiveForm::end(); ?>
			<div class="m_b_16"></div>

			<?php foreach($model as $key=>$val){?>

			<div class="liuyan_list">
				<a href="/message/messageinfo?id=<?=$val['id']?>" class="href_"><?=$val['title']?></a>
				<p><?= date('Y-m-d',$val['addtime'])?></p>
				<?php if($val['flag']==0):?>
				<div class="close_bt" onclick="isoff(<?=$val['id']?>)">关闭</div>
				<?php endif;?>
			</div>

			<?php } ?>
        </div>
    </div>
	<!-- 菜单 -->
	<?= $this->render('/layouts/head_menu.php'); ?>
	<!-- 菜单 -->
</div>
<script type="text/javascript">
	function isoff(id) {
		$.get("/message/infooff?id=" + id, function (d) {
		   /* layer.msg(d.msg, {icon: d.status,}); */
		   layer.open({
			  style: 'border:none; background-color:#fff; color:#f00;',
			  content:d.msg
			  ,time: 1
			  ,yes: function(){
				Zi.stoHref(location.reload(),0);
			  }
			})
			/* Zi.stoHref(location.reload(),5); */
			
		});
	}
</script>