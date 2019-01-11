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
                            'action' => Url::to('/'.THISID.'/index'),
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
                                <th class="pabc">转出会员</th>
                                <th>转入会员</th>
                                <th>转账积分</th>
                                <th>转账说明</th>
                                <th>时间</th>
                                <th width="12%">
                                <?php if(Yii::$app->request->get('funin')){ ?>
                                <button type="button" class="btn btn-outline btn-primary righo" id="funin">返回转账</button>
                                <?php }else{ ?>
                                <!-- <button type="button" class="btn btn-outline btn-primary righo" id="goform">刷新列表</button> -->
                                <?php } ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="lists">
                        <?php foreach($model as $key=>$val){?>
                            <tr>
                            <td class="pabc"><?=$val['send_userid']=='0'?"管理员":$val['send_userid']; ?></td>
                            <td><?=$val['to_userid']=='0'?"管理员":$val['to_userid']; ?></td>
                            <td><?=$val['money']; ?></td>
                            <td class="text-navy"><?=$val['why_change'];?></td>
                            <td colspan="2"><?=$val['change_time'];?></td>
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
