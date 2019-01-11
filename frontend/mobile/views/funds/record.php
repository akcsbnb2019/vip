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
						'action' => Url::to('/'.THISID.'/index'),
						'options' => ['class' => 'form-inline',],
					]);
					?>
					<div class="form-group">
					<?= Html::submitButton('立即提交', ['class' => 'btn btn-primary btn-info', 'name' => 'form-button']) ?>	
					</div>
				<?php ActiveForm::end(); ?>
			</div>

			<div class="list font_size_13">
				<?php if(Yii::$app->request->get('funin')){ ?>
					<div class="block">
						<div class="row">
							<button class="col button"></button>
							<button class="col button"></button>
							<button type="button" class="col button button-fill color-blue" id="funin">返回转账</button>
						</div>
					</div>
				<?php }else{ ?>
				<!-- <button type="button" class="btn btn-outline btn-primary righo" id="goform">刷新列表</button> -->
				<?php } ?>

				<div class="content-block cards_jl" id="lists">
					
				  <?php foreach($model as $key=>$val){?>
				  <div class="row font_color_333" style="background:#<?php if ($key%2 == 1) {?>fffcee<?php } else {?>fff<?php }?>;">
					<div class="col-100 m_p_b font_size_16"><span class="font_color_666"><?=$val['change_time']; ?></span></div>
					<div class="col-50"><span class="font_color_666">转出会员：</span><?=$val['send_userid'];?></div>
					<div class="col-50"><span class="font_color_666">转入会员：</span><?=$val['to_userid'];?></div>
					<div class="col-50"><span class="font_color_666">转帐积分：</span><?=$val['money'];?></div>
					<div class="col-50"><span class="font_color_666">转帐说明：</span><?=$val['why_change'];?></div>
					<div class="col-20"></div><div class="col-20"></div><div class="col-20"></div><div class="col-20"></div>
				  </div>
				  <?php } ?>
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