<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\WapAsset;
use yii\helpers\Url;

WapAsset::WapJs($this, 'page');
WapAsset::WapJs($this, 'icheck.min','mobile/js/iCheck/');
WapAsset::WapCss($this, 'custom','mobile/css/iCheck/');
WapAsset::WapJs($this, 'main');

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="app">
	<div class="page">
	<!-- 头部 -->
	<?= $this->render('/layouts/head.php'); ?>
	<!-- 头部 -->
		<div class="page-content">
			<div class="ibox-content hiddens">
				<?php
					$form = ActiveForm::begin([
						'id' => 'sForm',
							'action' => Url::to('/'.THISID.'/detailslist2?scount='.$p_scount.'&type='.$p_type),
						'options' => ['class' => 'form-inline',],
					]);
					?>
					<div class="form-group">
					<?= Html::submitButton('立即提交', ['class' => 'btn btn-primary btn-info', 'name' => 'form-button']) ?>	
					</div>
				<?php ActiveForm::end(); ?>
			</div>
			<div class="list font_size_13">
				<div class="content-block cards_jl" id="lists">
				  <?php foreach($model as $key=>$val){?>
				  <div class="row font_color_333" style="background:#<?php if ($key%2 == 1) {?>fffcee<?php } else {?>fff<?php }?>;">
					<div class="col-50"><span class="font_color_666">会员编号：</span><?=$val['loginname'];?></div>
					<div class="col-50"><span class="font_color_666">积分：</span><?=$val['points'];?></div>
					<div class="col-50"><span class="font_color_666">比例：</span><?=$val['pre'];?></div>
					<div class="col-50"><span class="font_color_666">时间：</span><?=date("Y-m-d",$val['addtime']);?></div>
				  </div>
				  <?php }?>
				</div>
			</div>
			<nav class="tpage" aria-label="Page navigation">
				<div id="pagination"></div>
			</nav>
		</div>
    </div>
	<!-- 菜单 -->
	<?= $this->render('/layouts/head_menu.php'); ?>
	<!-- 菜单 -->
</div>
<input type="hidden" id="nums" name="count" value="<?= $page->totalCount ?>">
<input type="hidden" id="page" value="<?= $page->page+1 ?>">