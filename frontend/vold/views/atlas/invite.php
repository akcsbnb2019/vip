<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cents">
    <div>
        <?php $form = ActiveForm::begin(['id' => 'select-form','method'=>'post']); ?>
        <div style="float: right"><div style="float: left"><?= $form->field($user, 'loginname')->textInput(['autofocus' => true]) ?></div>
            <div style="float: left"><?= Html::submitButton('搜索', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?></div></div>
        <?php ActiveForm::end(); ?>

    </div>
    <table class="layui-table" lay-even="" lay-skin="row">
        <colgroup>
            <col width="150">
            <col width="150">
            <col width="150">
        </colgroup>
        <thead>
        <tr >
            <th class="center">会员编号</th>
            <th class="center">级别</th>
            <th class="center">推荐人</th>
            <th class="center">安置人</th>
            <th class="center">会员昵称</th>
            <th class="center">电话</th>
            <th class="center">注册时间</th>
            <th class="center">操作</th>
        </tr>
        </thead>
        <?php foreach($model as $key=>$val){?>
            <tbody align="center">
            <td><?=$val['loginname']; ?></td>
            <td><?php if($val['standardlevel']>0){echo "VIP".$val['standardlevel'];}else{echo "普通";} ?></td>
            <td><?=$val['rid']; ?></td>
            <td><?=$val['pid']; ?></td>
            <td><?=$val['truename'];?></td>
            <td><?=$val['tel'];?></td>
            <td><?=$val['addtime'];?></td>
            <td><a href="?username=<?=$val['loginname']?>">查看</a></td>
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
