<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
	
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Url;

?>



<section class="larry-grid">
    <div class="larry-personal">
        <div class="layui-tab">
            <blockquote class="layui-elem-quote mylog-info-tit">
                <ul class="layui-tab-title">
                    <li class="layui-btn layui-this"><i class="layui-icon">&#xe60a;</i>会员管理</li>
                    <a class="layui-btn layui-btn-small larry-log-del" href="<?= Url::to("/".THISID."/index"); ?>"><i class="iconfont icon-huishouzhan1"></i>返回</a>
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
                            <th>周期</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>下发总奖金</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbodys">
						<?php foreach($model as $key=>$val){?>
                            <tr>
                                <td class="pabc"><?=$val['scount'];?></td>
                                <td><?=date("Y-m-d",$val['stime']);?></td>
                                <td><?=date("Y-m-d",$val['etime']);?></td>
                                <td><?=$val['zong'];?></td>
                                <td>
                                    <input type="hidden" id="id" class="id" value="<?=$val['id']?>">
                                    <a href="<?= Url::to('/user/details?id='.$id.'&scount='.$val['scount']); ?>" class="layui-btn  layui-btn-mini" id="absedit">详情</a>
                                </td>
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