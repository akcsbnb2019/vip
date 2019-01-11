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
            <col width="150">
            <col width="150">
        </colgroup>
        <thead>
        <tr >
            <th class="center">会员编号</th>
            <th class="center">股数</th>
            <th class="center">所需商城金额</th>
            <th class="center">时间</th>
            <th class="center">状态</th>
        </tr>
        </thead>
        <?php foreach($model as $key=>$val){?>
            <tbody align="center">
            <td><?=$val['userid']; ?></td>
            <td><?=$val['amount']; ?></td>
            <td><?=$val['amount']*10; ?></td>
            <td><?=$val['addtimes'];?></td>
            <td><?php if($val['states']==1){ echo "已完成";}else{echo "未处理";}?></td>
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

