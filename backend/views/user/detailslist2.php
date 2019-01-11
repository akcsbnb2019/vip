<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;
use yii\helpers\Url;
?>

<section class="larry-grid">
    <div class="larry-personal">
        <div class="layui-tab">
            <blockquote class="layui-elem-quote mylog-info-tit">
                <ul class="layui-tab-title">
                    <li class="layui-btn layui-this"><i class="layui-icon">&#xe60a;</i>奖金</li>
                    <a class="layui-btn layui-btn-small larry-log-del" href="<?= Url::to("/".THISID."/seltotal?id=".$id."scount=".$p_scount); ?>"><i class="iconfont icon-huishouzhan1"></i>返回</a>
                </ul>
            </blockquote>
            <div id="forms">
				<?php $form = ActiveForm::begin(['id' => 'sel_name-form','method'=>'post']); ?>
				
				<?php ActiveForm::end(); ?>
            </div>

            <div class="larry-separate"></div>
            <!-- 菜单列表 -->
            <div class="layui-tab-item layui-field-box layui-show">
                <table class="layui-table table-hover" lay-even="" lay-skin="nob" id="lists">
                    <thead>
                    <tr>
                        <th class="pabc">会员编号</th>
                        <th class="center">积分</th>
                        <th class="center">比例</th>
                        <th class="center">时间</th>
                    </tr>
                    </thead>
                    <tbody id="tbodys">
                    <?php foreach($model as $key=>$val){?>
                        <tr>
                            <td class="pabc"><?=$val['loginname']; ?></td>
                            <td><?=$val['points']; ?></td>
                            <td><?=$val['pre']; ?></td>
                            <td><?=date("Y-m-d",$val['addtime']);?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="larry-table-page clearfix">
                    <div id="page" class="page"></div>
                </div>
            </div>
        </div>
    </div>
    </div>

</section>
<!-- 分页用 -->
<link rel="stylesheet" type="text/css" href="/layui/uio/css2/layui.css" media="all">
<link rel="stylesheet" type="text/css" href="/css/pc/list.css" media="all">
<script language="JavaScript" src="/js/pc/pagePosts.js"></script>
<script type="text/javascript">
    /* 分页用 */
    var num = '<?= $page->totalCount ?>';
    var page = '<?= ($page->page)+1 ?>';
    var limit = <?= $page->defaultPageSize ?>;

    editU = '<?= Url::to('/'.THISID.'/edit'); ?>?cid=0';
    // layuiTime();
</script>