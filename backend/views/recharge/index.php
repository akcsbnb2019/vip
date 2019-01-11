<?php
	
	/* @var $this yii\web\View */
	/* @var $form yii\bootstrap\ActiveForm */
	/* @var $model \common\models\LoginForm */
	
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Url;
	
	$this->title = '报单充值管理 - 列表';
	$this->params['breadcrumbs'][] = $this->title;
?>
<section class="larry-grid">
    <div class="larry-personal">
        <div class="layui-tab">
            <div class="larry-separate"></div>
            <div class="layui-tab-content larry-personal-body clearfix mylog-info-box">
                <div class="demoTable" id="forms">
					<?php $form = ActiveForm::begin(['id' => 'menu-form']); ?>
                    搜索ID：
                    <div class="layui-inline">
                        <input class="layui-input" name="s" id="search" value="<?=(isset($_POST['s'])?$_POST['s']:'')?>">
                    </div>
                    <button class="layui-btn" data-type="reload">搜索</button>
					<?php ActiveForm::end(); ?>
                </div>
                <style>.jietu{height: 25px;min-width: 25px;border: 1px solid #ddd;}</style>
                <!-- 菜单列表 -->
                <div class="layui-tab-item layui-field-box layui-show">
                    <table class="layui-table table-hover" lay-even="" lay-skin="nob" id="lists">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="selected-all"></th>
                            <th>报单中心</th>
                            <th>申请时间</th>
                            <th>申请金额</th>
                            <th>申请说明</th>
                            <th>截图</th>
                            <th>操作&状态</th>
                        </tr>
                        </thead>
                        <tbody id="tbodys">
						<?php foreach($model as $key=>$val){?>
                            <tr>
                                <td>
                                <?php if($val['incomeId'] == 0){?>
                                	<input type="checkbox" value="<?= $val['id']?>" class="id">
								<?php }?>
                                </td>
                                <td><?= $val['user']?></td>
                                <td><?= $val['createdTime']?></td>
                                <td><?= $val['money']?></td>
                                <td><?= $val['memo']?></td>
                                <td><a href="http://bd.yhr001.net/upload/recharge/<?= $val['img']?>" target="_blank"><img class="jietu" src="http://47.95.227.79:91/upload/recharge/<?= $val['img']?>"/></a></td>
                                <td>
									<?php if($val['incomeId'] == 0){?>
                                        <button class="layui-btn layui-btn-danger layui-btn-mini" id="del">取消</button>
                                        <button class="layui-btn  layui-btn-mini" id="up2">下发</button>
									<?php }else if($val['incomeId'] == -1){?>未通过
									<?php }else if($val['incomeId'] == -2){?>用户取消
									<?php }else if($val['incomeId'] > 0){?>通过
									<?php }?>
                                </td>
                            </tr>
						<?php } ?>
                        </tbody>
                    </table>
                    <div class="larry-table-page clearfix">
                        <a href="javascript:;" class="layui-btn layui-btn-small layui-btn-danger" id="delall">取消</a>
                        <a href="javascript:;" class="layui-btn layui-btn-small" id="upall">下发</a>
                        <div id="page" class="page"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- 分页用 -->
<link rel="stylesheet" type="text/css" href="/layui/uio/css2/layui.css" media="all">
<script language="JavaScript" src="/js/pc/pagePost.js"></script>
<script type="text/javascript">
    var Urs   = '<?= Url::to('/'.THISID.'/'); ?>';
    var addU  = '<?= Url::to('/'.THISID.'/add'); ?>?d=0';
    var editU = '<?= Url::to('/'.THISID.'/edit'); ?>?d=0';
    var num   = '<?= $page->totalCount ?>';
    var page  = '<?= ($page->page)+1 ?>';
    var limit = <?= $page->defaultPageSize ?>;
</script>