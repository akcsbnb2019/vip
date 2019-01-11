<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

AppAsset::addJs($this, 'bootstrap.min');
AppAsset::addJs($this, 'icheck.min','js/plugins/iCheck/');
AppAsset::addCss($this, 'custom','css/plugins/iCheck/');
AppAsset::addJs($this, 'main');

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content hiddens">
                    <?php
                        $form = ActiveForm::begin([
                            'id' => 'sForm',
                            'action' => Url::to('/'.THISID.'/position'),
                            'options' => ['class' => 'form-inline',],
                        ]);
                        ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="form-group" style="text-align: right;">
                    <a class="btn btn-primary btn-info" href="javascript:history.go(-1);">返回</a>
                </div>
                <div class="ibox-content iboxo">
                    <table class="table table-hover d-border" id="tables">
                        <thead>
                            <tr>
                                <th style="width:33%;">升级前</th>
                                <th style="width:33%;">升级后</th>
                                <th style="width:33%;">升级时间</th>
                            </tr>
                        </thead>
                        <tbody id="lists">
                        <?php foreach($model as $key=>$val){?>
                            <tr>
                            <td><img src="/img/<?=$val['old_level']; ?>.png" height="20" style="margin-bottom: 4px;"/> <?=$val['old_levels']; ?></td>
                            <td style="color: #34c08b"><img src="/img/<?=$val['level']; ?>.png" height="20" style="margin-bottom: 4px;"/> <?=$val['levels']; ?></td>
                            <td colspan="2"><?=date("Y-m-d H:i:s",$val['add_time']);?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <nav class="tpage" aria-label="Page navigation">
                		<div id="pagination"></div>
                	</nav>
                </div>
                
            </div>
        </div>
    </div>
</div>
