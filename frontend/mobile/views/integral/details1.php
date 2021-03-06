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
	<div class="page">
	<!-- 头部 -->
	<?= $this->render('/layouts/head.php'); ?>
	<!-- 头部 -->
		<div class="page-content">
			<div class="ibox-content hiddens">
				<?php
					$form = ActiveForm::begin([
						'id' => 'sForm',
						'action' => Url::to('/'.THISID.'/details'),
						'options' => ['class' => 'form-inline',],
					]);
					?>
					<div class="form-group">
					<?= Html::submitButton('立即提交', ['class' => 'btn btn-primary btn-info', 'name' => 'form-button']) ?>	
					</div>
				<?php ActiveForm::end(); ?>
			</div>
			<div class="list font_size_13">
				<div class="content-block-title tt-block-title">第<?= $total['scount'];?>期</div>
				<div class="card">
				  <div class="card-header tt-card-header"><div style="color:#2d97d3;">YQ</div></div>
				  <div class="card-content">
					<div class="card-content-inner">
					<div class="row">
						<div class="col-50 tt-card-header" style="border-right:1px solid #e1e1e1;">本期积分</div>
						<div class="col-50 tt-card-header"><?=(isset($model['alltj']['zong'])?$model['alltj']['zong']:0)?></div>
					  </div>
					</div>
				  </div>
				</div>
				<div class="card">
				  <div class="card-header tt-card-header"><div style="color:#fa631a;">XS</div></div>
				  <div class="card-content">
					<div class="card-content-inner">
					<div class="row">
						<div class="col-50 tt-style-score" style="border-right:1px solid #e1e1e1;">本期积分</div>
						<div class="col-50 tt-style-score"><?=(isset($model['allxs']['zong'])?$model['allxs']['zong']:0)?></div>
					  </div>
					</div>
				  </div>
				</div>
				<div class="card">
				  <div class="card-header tt-card-header"><div style="color:#fa4556;">GL</div></div>
				  <div class="card-content">
					<div class="card-content-inner">
					<div class="row">
						<div class="col-50 tt-style-score" style="border-right:1px solid #e1e1e1;">本期积分</div>
						<div class="col-50 tt-style-score"><?=(isset($model['allgl']['zong'])?$model['allgl']['zong']:0)?></div>
					  </div>
					</div>
				  </div>
				</div>
                <div class="card">
                    <div class="card-header tt-card-header"><div style="color:#EE82EE;">JC</div></div>
                    <div class="card-content">
                        <div class="card-content-inner">
                            <div class="row">
                                <div class="col-50 tt-style-score" style="border-right:1px solid #e1e1e1;">本期积分</div>
                                <div class="col-50 tt-style-score"><?=$model['alljb']['zong']?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header tt-card-header"><div style="color:#FF1493;">CY</div></div>
                    <div class="card-content">
                        <div class="card-content-inner">
                            <div class="row">
                                <div class="col-50 tt-style-score" style="border-right:1px solid #e1e1e1;">本期积分</div>
                                <div class="col-50 tt-style-score"><?=$model['alljc']['zong']?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header tt-card-header"><div style="color:#FF1493;">FXZF</div></div>
                    <div class="card-content">
                        <div class="card-content-inner">
                            <div class="row">
                                <div class="col-50 tt-style-score" style="border-right:1px solid #e1e1e1;">本期积分</div>
	                            <?php if($total['fuxiao']>=300){?>
                                    <div class="col-50 tt-style-score"><?=$total['fuxiao']-300?></div>
                                <?php }else{?>
                                    <div class="col-50 tt-style-score"><?= 0;?></div>
	                            <?php }?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php if($total['declaration']>0):?>
                <div class="card">
                    <div class="card-header tt-card-header"><div style="color:#FF1493;">DLFW</div></div>
                    <div class="card-content">
                        <div class="card-content-inner">
                            <div class="row">
                                <div class="col-50 tt-style-score" style="border-right:1px solid #e1e1e1;">本期积分</div>
                                <div class="col-50 tt-style-score"><?=$total['declaration']?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif;?>
                
				<div class="card">
				  <div class="card-header tt-card-header"><div style="color:#ffc341;">AXJJ</div></div>
				  <div class="card-content">
					<div class="card-content-inner">
					<div class="row">
						<div class="col-50 tt-style-score" style="border-right:1px solid #e1e1e1;">本期积分</div>
						<div class="col-50 tt-style-score"><?=$model['alllove']['zong']?></div>
					  </div>
					</div>
				  </div>
				</div>
				<div class="card">
				  <div class="card-header tt-card-header"><div style="color:#4ab624;">FXQ</div></div>
				  <div class="card-content">
					<div class="card-content-inner">
					<div class="row">
						<div class="col-50 tt-style-score" style="border-right:1px solid #e1e1e1;">本期积分</div>
						<?php if($total['fuxiao']>=300){?>
                            <div class="col-50 tt-style-score"><?= 300?></div>
						<?php }else{?>
                            <div class="col-50 tt-style-score"><?=$total['fuxiao']?></div>
						<?php }?>
					  </div>
					</div>
				  </div>
				</div>
				<div class="card">
				  <div class="card-header tt-card-header"><div style="color:#0bc2d2;">LY</div></div>
				  <div class="card-content">
					<div class="card-content-inner">
					<div class="row">
						<div class="col-50 tt-style-score" style="border-right:1px solid #e1e1e1;">本期积分</div>
						<div class="col-50 tt-style-score"><?=$model['allly']['zong']?></div>
					  </div>
					</div>
				  </div>
				</div>
				
				<div class="card">
				  <div class="card-header tt-card-header"><div style="color:#2d97d3;">实发奖金</div></div>
				  <div class="card-content">
					<div class="card-content-inner">
					<div class="row">
						<div class="col-50 tt-style-score" style="border-right:1px solid #e1e1e1;">本期积分</div>
						<div class="col-50 tt-style-score"><?=$total['bonus']?></div>
					  </div>
					</div>
				  </div>
				</div>
				
				<!--<div class="content-block-title tt-block-title">第666期</div>
				<div class="card">
				  <div class="card-header tt-card-header"><div>本期积分</div></div>
				  <div class="card-content">
					<div class="card-content-inner">
					<div class="row">
						<div class="col-50 tt-style-score" style="border-right:1px solid #e1e1e1;">本期积分</div>
						<div class="col-50 tt-style-score">88.88</div>
					  </div>
					</div>
				  </div>
				</div>-->
				
				<!--<div class="content-block cards_jl" id="lists">
				  <?php //foreach($model as $key=>$val){?>
				  <div class="row font_color_333" style="background:#<?php //if ($key%2 == 1) {?>fffcee<?php //} else {?>fff<?php //}?>;">
					<div class="col-100 m_p_b font_size_16"><span class="font_color_666"><?//=$val['addtime']; ?></span></div>
					<div class="col-50"><span class="font_color_666">类型：</span><?//=$val['types'];?></div>
					<div class="col-50"><span class="font_color_666">积分：</span><?//=$val['amount'];?></div>
				  </div>
				  <?php //} ?>
				</div>-->
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
<input type="hidden" id="nums" name="count" value="<?//=$page->totalCount ?>">
<input type="hidden" id="page" value="<?//=$page->page+1 ?>">