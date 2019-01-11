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
                            'action' => Url::to('/'.THISID.'/exlist'),
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
                                <th class="center">积分</th>
                                <th class="center">手续费</th>
                                <th class="center">兑换账户</th>
                                <th class="center">帐号</th>
                                <th class="center">户名</th>
                                <th class="center">时间</th>
                                <th class="center">备注</th>
                                <th class="center">状态</th>
                                <th width="12%">
                                <?php if(Yii::$app->request->get('funin')){ ?>
                                <button type="button" class="btn btn-outline btn-primary righo" id="funin">返回提现</button>
                                <?php } ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="lists">
                        <?php foreach($model as $key=>$val){?>
                            <tr>
                                <td class="pabc"><?=$val['userid']; ?></td>
                                <td><?=$val['amount']; ?></td>
                                <td><?php if ($val['states']==8) { echo "-"; } else { echo $val['amount']-$val['get_amount']; } ?></td>
                                <td><?=$val['bank']; ?></td>
                                <td><?=$val['bankno']; ?></td>
                                <td><?=$val['bankuser']; ?></td>
                                <td><?=$val['addtimes']; ?></td>
                                <td><?=$val['memo']; ?></td>
                                <td class="text-navy" colspan="2"><?php if($val['states']=="1") {echo '已处理';} else if($val['states']=="8") {echo '自动处理';} else if($val['states']<0) {echo '管理员取消';}else {echo '未处理';}?></td>
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