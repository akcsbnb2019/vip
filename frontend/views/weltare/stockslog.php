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
            <div class="ibox float-e-margins">
                <div class="ibox-content hiddens">
                    <?php
                        $form = ActiveForm::begin([
                            'id' => 'sForm',
                            'action' => Url::to('/'.THISID.'/stockslog'),
                            'options' => ['class' => 'form-inline',],
                        ]);
                        ?>
                        <div class="form-group">
                        <?= Html::submitButton('立即提交', ['class' => 'btn btn-primary btn-info', 'name' => 'form-button']) ?>	
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="ibox-content iboxo">
                    <table class="table table-hover d-border" id="tables">
                        <thead>
                            <tr>
                                <th class="pabc">会员编号</th>
                                <th>拥有股数</th>
                                <th>发放金额</th>
                                <th>发放时间</th>
                            </tr>
                        </thead>
                        <tbody id="lists">
                        <?php foreach($model as $key=>$val){?>
                            <tr>
                            <td class="pabc"><?=$val['username']; ?></td>
                            <td><?=$val['stocks']; ?></td>
                            <td><?=$val['bfje']; ?></td>
                            <td class="text-navy"><?=$val['addtime'];?></td>
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
<input type="hidden" id="nums" name="count" value="<?= $page->totalCount ?>">
<input type="hidden" id="page" value="<?= $page->page+1 ?>">