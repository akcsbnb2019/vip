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
            <col width="150">
        </colgroup>
        <thead>
        <tr >
            <th class="center">转出会员</th>
            <th class="center">转入会员</th>
            <th class="center">转账积分</th>
            <th class="center">转账理由</th>
            <th class="center">时间</th>
        </tr>
        </thead>
        <?php foreach($model as $key=>$val){?>
            <tbody align="center">
            <td><?=$val['send_userid']; ?></td>
            <td><?=$val['to_userid']; ?></td>
            <td><?=$val['money']; ?></td>
            <td><?=$val['why_change'];?></td>
            <td><?=$val['change_time'];?></td>
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
