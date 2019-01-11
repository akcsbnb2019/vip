<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

AppAsset::addJs($this, 'bootstrap.min');
AppAsset::addJs($this, 'page');
AppAsset::addJs($this, 'icheck.min','js/plugins/iCheck/');
AppAsset::addCss($this, 'custom','css/plugins/iCheck/');
AppAsset::addJs($this, 'main');
 
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-sm-12">
			<div class="ibox">
				<div class="ibox-title">
                    <h5 class="tt-font-size-16">第<?= $total['scount'];?>期</h5>
                </div>
				<div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c center-block"><strong class="center-block" style="color:#2d97d3 ; text-align: center">YQ</strong></div>
								<div class="row">
									<div class="col-sm-6 tt-style-score" style="border-right:1px solid #ddd;text-align: center">本期积分</div>
									<div class="col-sm-6 tt-style-score" style="text-align: center;"><?=(isset($model['alltj']['zong'])?$model['alltj']['zong']:0)?></div>
								</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#fa631a; text-align: center">XS</strong></div>
								<div class="row">
									<div class="col-sm-6 tt-style-score" style="border-right:1px solid #1ab394; text-align: center">本期积分</div>
									<div class="col-sm-6 tt-style-score" style="text-align: center"><?=(isset($model['allxs']['zong'])?$model['allxs']['zong']:0)?></div>
								</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#fa4556; text-align: center">GL</strong></div>
								<div class="row">
									<div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6;text-align: center">本期积分</div>
									<div class="col-sm-6 tt-style-score" style="text-align: center"><?=(isset($model['allgl']['zong'])?$model['allgl']['zong']:0)?></div>
								</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#EE82EE ; text-align: center">JC</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6; text-align: center">本期积分</div>
                                    <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$model['alljb']['zong']?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#FF1493; text-align: center">CY</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6; text-align: center">本期积分</div>
                                    <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$model['alljc']['zong']?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#0000aa; text-align: center">FXZF</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6; text-align: center">本期积分</div>
                                    <?php if($total['fuxiao']>=300){?>
                                        <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$total['fuxiao']-300?></div>
                                    <?php }else{?>
                                        <div class="col-sm-6 tt-style-score" style="text-align: center"><?= 0;?></div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
	                    <?php if($total['declaration']>0):?>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#0000aa; text-align: center">DLFW</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6; text-align: center">本期积分</div>
                                    <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$total['declaration']?></div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#ffc341; text-align: center">AXJJ</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #ddd; text-align: center">本期积分</div>
                                    <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$model['alllove']['zong']?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                            <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#4ab624; text-align: center">FXQ</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1ab394;text-align: center">本期积分</div>
	                                <?php if($total['fuxiao']>=300){?><div class="col-sm-6 tt-style-score" style="text-align: center"><?= 300;?></div><?php }else{?><div class="col-sm-6 tt-style-score" style="text-align: center"><?=$total['fuxiao']?></div><?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#0bc2d2; text-align: center">LY</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6;text-align: center">本期积分</div>
                                    <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$model['allly']['zong']?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#7B68EE  ;text-align: center" >实发奖金</strong></div>
								<div class="row">
									<div class="col-sm-6 tt-style-score" style="border-right:1px solid #23c6c8;text-align: center">本期积分</div>
									<div class="col-sm-6 tt-style-score" style="text-align: center"><?=$total['bonus']?></div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
				
			</div>
		</div>
        <!--<div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content hiddens">
                    <?php
/*                        $form = ActiveForm::begin([
                            'id' => 'sForm',
                            'action' => Url::to('/'.THISID.'/details'),
                            'options' => ['class' => 'form-inline',],
                        ]);
                        */?>
                        <div class="form-group">
                        <?/*= Html::submitButton('立即提交', ['class' => 'btn btn-primary btn-info', 'name' => 'form-button']) */?>
                        </div>
                    <?php /*ActiveForm::end(); */?>
                </div>
                <div class="ibox-content iboxo">
                    <table class="table table-hover d-border" id="tables">
                        <thead>
                            <tr>
                                <th class="pabc">变动时间</th>
                                <th class="center">类型</th>
                                <th class="center">积分</th>
                            </tr>
                        </thead>
                        <tbody id="lists">
                        <?php /*foreach($model as $key=>$val){*/?>
                            <tr>
                                <td class="pabc"><?/*=$val['addtime']; */?></td>
                                <td><?/*=$val['types'];*/?></td>
                                <td class="text-navy"><?/*=$val['amount'];*/?></td>
                            </tr>
                        <?php /*} */?>
                        </tbody>
                    </table>
                    <nav class="tpage" aria-label="Page navigation">
                		<div id="pagination"></div>
                	</nav>
                </div>
                
            </div>
        </div>-->
    </div>
</div>
