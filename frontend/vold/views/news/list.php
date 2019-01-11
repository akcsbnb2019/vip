<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cents">
    <table class="layui-table">
      <colgroup>
        <col width="300">
        <col width="60">
        <col>
      </colgroup>
      <thead>
        <tr>
          <th class="center">公告标题</th>
          <th class="center">发布时间</th>
        </tr> 
      </thead>
      <tbody>
    <?php foreach($model as $key=>$val){?>
        <tr>
        <td><a href="/news/info?id=<?= $val['ArticleID']?>"><?=$val['title'];?></a></td>
        <td class="center"><?=$val['UpdateTime'];?></td>
        </tr> 
    <?php } ?>
      </tbody>
    </table>
	<div id="demo2"></div>
<script language="JavaScript" src="/pc/js/base.js"></script>
<script language="JavaScript" src="/pc/js/pages.js"></script>
<script>
var num = '<?= ceil($page->totalCount/$page->defaultPageSize) ?>';
var page = '<?= ($page->page)+1 ?>';
</script>
</div>
