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
            <th class="center">会员编号</th>
            <th class="center">积分</th>
            <th class="center">手续费</th>
            <th class="center">兑换账户</th>
            <th class="center">帐号</th>
            <th class="center">户名</th>
            <th class="center">时间</th>
            <th class="center">备注</th>
            <th class="center">状态</th>
        </tr>
        </thead>
        <?php foreach($model as $key=>$val){?>
            <tbody align="center">
            <td><?=$val['userid']; ?></td>
            <td><?=$val['amount']; ?></td>
            <td><?php if ($val['states']==8) { echo "-"; } else { echo $val['amount']-$val['get_amount']; } ?></td>
            <td><?=$val['bank']; ?></td>
            <td><?=$val['bankno']; ?></td>
            <td><?=$val['bankuser']; ?></td>
            <td><?=$val['addtimes']; ?></td>
            <td><?=$val['memo']; ?></td>
            <td><?php if($val['states']=="1") {echo '已处理';} else if($val['states']=="8") {echo '自动处理';} else if($val['states']<0) {echo '管理员取消';}else {echo $val['states'].'未处理';} echo $val['states'];?></td>
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
