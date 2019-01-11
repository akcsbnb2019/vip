<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .left{
        float: left;
    }
    .right{
        float: right;
    }
</style>
<div class="cents">
    <table class="layui-table" lay-even="" lay-skin="nob">

        <tbody>
        <tr>
            <td class="right">用 户 编 号：</td>
            <td><?=$user['loginname'];?></td>
        </tr>
        <tr>
            <td class="right">用 户 级 别：</td>
            <td><?=$model['level'];?></td>
        </tr>
        <?php if($model['fuli']):?>
            <tr>
                <td class="right">福 利 会 员：</td>
                <td>福利会员</td>
            </tr>
            <tr>
                <td class="right">福 利 积 分：</td>
                <td><?=$user['yuanshigu'];?></td>
            </tr>
        <?php endif?>
        <?php if($model['dlName']):?>
            <tr>
                <td class="right">代 理 级 别：</td>
                <td><?=$model['dlName'];?></td>
            </tr>
            <tr>
                <td class="right">代 理 积 分：</td>
                <td><?=$model['dlamount']?></td>
            </tr>
        <?php endif?>
        <tr>
            <td class="right">电子币余额：</td>
            <td><?=$user['amount'];?></td>
        </tr>
        <tr>
            <td class="right">电子币历史：</td>
            <td><?=$model['amountall'];?></td>
        </tr>
        <tr>
            <td class="right">商城累计积分：</td>
            <td><?=$user['pay_points'];?></td>
        </tr>
        <tr>
            <td class="right">商城历史积分：</td>
            <td><?=$user['pay_points_all'];?></td>
        </tr>
        <tr>
            <td class="right">爱 心 基 金：</td>
            <td><?=$user['aixinjijin'];?></td>
        </tr>
        <tr>
            <td></td>
            <td>查看股权证书</td>
        </tr>
        <tr>
            <td></td>
            <td><a href="/news/index">我的首页</a></td>
        </tr>

        </tbody>
    </table>
    <script language="JavaScript" src="/pc/js/base.js"></script>
</div>

