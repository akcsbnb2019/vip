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
        </colgroup>
        <thead>
        <tr>
            <th class="center">问题</th>
            <th class="center">时间</th>
            <th class="center">状态</th>
            <th class="center">操作</th>
        </tr>
        </thead>
		<tbody align="center" id="tbodys">
		<?php foreach($model as $key=>$val){?>
		<tr>
			<td><?=$val['title']; ?></td>
			<td><?= date('Y-m-d H:i:s',$val['addtime'])?></td>
			<td><?=$val['flag']==1?"已解决":"未解决"; ?></td>
			<td><a href="/message/messageinfo?id=<?=$val['id']?>">查看<?php if ($val['states'] == 2) {?><span class="layui-badge-dot"></span><?php }?></a></td>
		</tr>
        <?php } ?>
		</tbody>
    </table>
	<div class="larry-table-page clearfix" style="margin:0 0 0 10px;">
		<div id="page" class="page"></div>
	</div>
    <script language="JavaScript" src="/pc/js/pagePost.js"></script>
    <script type="text/javascript">
		var num   = '<?= $page->totalCount ?>';
		var page  = '<?= ($page->page)+1 ?>';
		var limit = '<?= $page->defaultPageSize ?>';
		var _csrf = '<?= Yii::$app->request->csrfToken ?>';
		var url = '/message/list';
	</script>
</div>