<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

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
	<div class="page news_page_top">
	<!-- 头部 -->
	<?= $this->render('/layouts/head.php'); ?>
	<!-- 头部 -->
		<div class="page-content">
			<div class="list accordion-list">
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