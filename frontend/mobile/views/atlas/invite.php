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
			<div class="ibox-content">
				<?php
                    $form = ActiveForm::begin([
                        'id' => 'sForm',
                        'action' => Url::to('/'.THISID.'/index'),
                        'method'=>'post',
                        'fieldConfig'=>['template'=> "{input}"]
                    ]);
				?>
				<div class="searchbar row hytp_searchbar no-gutter xiu3 xiu7 xiu8">
					<div class="search-input col-50 xiu6">
					  <label class="icon icon-search" for="search"></label>
					  <?= $form->field($user, 'loginname')->textInput(['autofocus' => true,'placeholder'=>"请输入要查找的用户名"]) ?>
					</div>
					<?= Html::submitButton('立即查询', ['class' => 'button button-fill button-primary col-20 ht_40', 'name' => 'login-button']) ?>
					<?= Html::button('查看全部', ['class' => 'button button-fill button-primary col-30 ht_40', 'name' => 'form-button', 'id'=>'sxlis']) ?>
				</div>
				<?php ActiveForm::end(); ?>
			</div>

			<div class="list font_size_13">
				<div class="content-block cards_jl" id="lists">
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