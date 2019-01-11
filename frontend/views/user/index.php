<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <table class="table table-hover d-border">
                        <tbody class="">
                        <tr>
                            <td width="12%">用 户 编 号：</td>
                            <td width="80%"><?=$user['loginname'];?></td>
                            <td width="10%" style="background-color:#ffffff"><a href="/user/edit" class="btn btn-sm btn-success"> 修改 </a></td>
                        </tr>
                        <tr>
                            <td>用 户 级 别：</td> <td colspan="2"><?=$model['level'];?></td>
                        </tr>
                        <?php if($model['fuli']):?>
                        <tr>
                            <td>福 利 会 员：</td><td colspan="2" class="table-tr-td2">福利会员<img src="/img/main-info.png"></td>
                        </tr>
                        <tr>
                            <td>福 利 积 分：</td><td colspan="2">￥<?=$user['yuanshigu'];?></td>
                        </tr>
                        <?php endif?>
                        <?php if($model['dlName']):?>
                        <tr>
                            <td>代 理 级 别：</td><td colspan="2"><?=$model['dlName'];?></td>
                        </tr>
                        <tr>
                            <td>代 理 积 分：</td><td colspan="2">￥<?=AppAsset::dec($model['dlamount'])?></td>
                        </tr>
                        <?php endif?>
                        <tr>
                            <td>电子币余额：</td><td colspan="2">￥<?=AppAsset::dec($user['amount']);?></td>
                        </tr>
                        <tr>
                            <td>电子币历史：</td><td colspan="2">￥<?=AppAsset::dec($model['amountall']);?></td>
                        </tr>
                        <tr>
                            <td>商城累计积分：</td><td colspan="2">￥<?=AppAsset::dec($user['pay_points']);?></td>
                        </tr>
                        <tr>
                            <td>商城历史积分：</td><td colspan="2">￥<?=AppAsset::dec($user['pay_points_all']);?></td>
                        </tr>
                        <tr>
                            <td>爱 心 基 金：</td><td colspan="2">￥<?=AppAsset::dec($user['aixinjijin']);?></td>
                        </tr>
                        <?php if($model['fuli']):?>
                        <tr>
                            <td></td><td><a href="<?= Url::to('/user/stockcert'); ?>">查看股权证书</a></td>
                        </tr>
                        <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>