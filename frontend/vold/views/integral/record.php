<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cents">

    <table class="layui-table" lay-even="" lay-skin="row">
        <colgroup>
            <col width="150">
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th class="center">日期</th>
            <th class="center">邀请积分</th>
            <th class="center">销售积分</th>
            <th class="center">管理积分</th>
            <th class="center">绩效积分</th>
            <th class="center">爱心基金</th>
            <th class="center">税收</th>
            <th class="center">合计</th>
        </tr>
        </thead>
        <?php foreach($model as $key=>$val){?>
            <tbody align="center">
            <td><?=$val['adddate']; ?></td>
            <td><?=$val['yaoqing'];?></td>
            <td><?=$val['xiaoshou'];?></td>
            <td><?=$val['guanli'];?></td>
            <td><?=$val['jixiao'];?></td>
            <td><?=$val['aixin'];?></td>
            <td><?=$val['shui'];?></td>
            <td><?=$val['sum'];?></td>
            </tbody>

        <?php } ?>
    </table>

    <div id="demo2"></div>
    <script language="JavaScript" src="/pc/js/base.js"></script>
    <script language="JavaScript" src="/pc/js/pages.js"></script>
    <script>
        var num = '<?= ceil($page->totalCount/$page->defaultPageSize) ?>';
        var page = '<?= ($page->page)+1 ?>';
    </script>
</div>

