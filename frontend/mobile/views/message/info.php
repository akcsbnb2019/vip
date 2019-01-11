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
        <div class="page-content pd_b_170">
			<div class="m_b_16"></div>
			<div class="block-title text_center"><?=date('Y-m-d H:i:s',$info['addtime'])?></div>
			<div class="card card_info">
			  <div class="card-header"><?=$info['title']?></div>
			  <div class="card-content card-content-padding"><?=$info['content']?></div>
			</div>
			
			<?php
				$isarr = end($recdata);
				foreach ($recdata as $key=>$v) {
			?>
			<?php if($info['senduid']==$v['senduid']) :?>
			
				<?php if($isarr['id']==$v['id']):?>
			<div class="block-title text_center"><?=date('Y-m-d H:i:s',$info['addtime'])?></div>
			<div class="lylist">
				<img src="/mobile/img/logo.png" class="photo"/>
				<div class="info bg_fff"><?=$v['content']?></div>
				<div class="clr"></div>
			</div>
				<?php else:?>
			<div class="m_b_16"></div>
			<div class="block-title text_center"><?=date('Y-m-d H:i:s',$info['addtime'])?></div>
			<div class="lylist">
				<img src="/mobile/img/logo.png" class="photo"/>
				<div class="info bg_fff"><?=$v['content']?></div>
				<div class="clr"></div>
			</div>
				<?php endif;?>
			<?php else:?>
			
				<?php if($isarr['id']==$v['id']):?>
			<div class="block-title text_center"><?=date('Y-m-d H:i:s',$info['addtime'])?></div>
			<div class="lylist">
				<img src="/mobile/img/logo.png" class="photo2"/>
				<div class="bg_ef8181 info2"><?=$v['content']?></div>
				<div class="clr"></div>
			</div>
				<?php else:?>
			<div class="m_b_16"></div>
			<div class="block-title text_center"><?=date('Y-m-d H:i:s',$info['addtime'])?></div>
			<div class="lylist">
				<img src="/mobile/img/logo.png" class="photo2"/>
				<div class="bg_ef8181 info2"><?=$v['content']?></div>
				<div class="clr"></div>
			</div>
				<?php endif;?>
			<?php endif;?>
			<?php }?>
		
			<?php if ($isarr['senduid']==0 and $info['flag']==0):?>
		
			<div class="toolbar messagebar messagebar_n">
				<div class="toolbar-inner">
				  <?php
					$form = ActiveForm::begin([
						'id' => 'form1',
						'action' => Url::to('/'.THISID.'/infoform1'),
					]);
				  ?>
				  <div class="messagebar-area">
					<?= Html::activeHiddenInput($model,'title',array('value'=>$info['title'])) ?>
					<?= Html::activeHiddenInput($model,'parent_id',array('value'=>$info['id'])) ?>
					<?= $form->field($model, 'content')->textarea(['class' => 'resizable','placeholder' => '请输入问题内容']) ?>
				  </div>
				  <?= Html::submitButton('提交', ['class' => 'col button button-raised button-fill lg_dl', 'name' => 'form-button']) ?>
				  <?php ActiveForm::end(); ?>
				</div>
			</div>

			<?php else:?>
			<div class="pd_b_70"></div>
				<?php if ($info['flag']==1):?>
			<div class="block"><p class="row"><button class="col button color-gray">问题已关闭</button></p></div>
				<?php else:?>
			<button class="col button color-gray">请耐心等待客服回复请耐心等待客服回复</button>
				<?php endif;?>

			<?php endif;?>
		
		</div>


    </div>
	<!-- 菜单 -->
	<?= $this->render('/layouts/head_menu.php'); ?>
	<!-- 菜单 -->
</div>