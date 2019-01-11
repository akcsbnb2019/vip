<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '列表 - 管理员';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="larry-grid">
	<div class="larry-personal">
	    <div class="layui-tab">
            <blockquote class="layui-elem-quote mylog-info-tit">
                <ul class="layui-tab-title">
					<li class="layui-btn layui-this"><i class="layui-icon">&#xe60a;</i>列表</li>
				</ul>
            </blockquote>
            <div class="larry-separate"></div>
		    <div class="layui-tab-content larry-personal-body clearfix mylog-info-box">
				<div class="layui-form" id="forms">
					<?php $form = ActiveForm::begin(['id' => 'menu-form']); ?>
					搜索ID：
					<div class="layui-inline">
						<input class="layui-input" name="s" value="<?= $uname;?>" id="search">
					</div>
					状态：
					<div class="layui-input-inline" class="layui-input-block" >
						<select name="s1" id="s1" lay-filter="aihao">
                            <option value="0,1,8" <?= $we=='0,1,8'?'selected':'';?>>全部</option>
                            <option value="0" <?= $we=='0'?'selected':'';?>>提现未处理</option>
                            <option value="1" <?= $we=='1'?'selected':'';?>>提现已处理</option>
							<option value="8" <?= $we=='8'?'selected':'';?>>兑换</option>
						</select>
					</div>
					开始时间：
					<div class="layui-inline">
					<input type="text" name="begtime" id="begtime" class="layui-input" value="<?=(isset($_REQUEST['begtime'])?$_REQUEST['begtime']:'')?>" msg="开始时间">
					</div>
					结束时间：
					<div class="layui-inline">
					<input type="text" name="endtime" id="endtime" class="layui-input" value="<?=(isset($_REQUEST['endtime'])?$_REQUEST['endtime']:'')?>" msg="开始时间">
					</div>
					<button class="layui-btn" data-type="reload">搜索</button><input name="_csrf-backend" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
					<?php ActiveForm::end(); ?>
					<button class="layui-btn" data-type="reload" id="import" >导出</button>
				</div>
		         <!-- 菜单列表 -->
                <div class="layui-tab-item layui-field-box layui-show">
                     <table class="layui-table table-hover" lay-even="" lay-skin="nob" id="lists">
                          <thead>
                              <tr>
                                  <th><input type="checkbox" id="selected-all"></th>
                                  <th>ID</th>
                                  <th>会员编号</th>
                                  <th>姓名</th>
                                  <th>开户行</th>
                                  <th>银行卡号</th>
                                  <th>金额</th>
                                  <th>到账金额</th>
                                  <th>时间</th>
                                  <th>类型</th>
                                  <th>状态</th>
                                  <th>操作</th>
                              </tr>
                          </thead>
                          <tbody id="tbodys">
                          <?php foreach($model as $key=>$val){?>
                              <tr>
                                <td><input type="checkbox" value="<?= $val['id']?>" class="id"></td>
                                <td><?= $val['id']?></td>
                                <td><?= $val['userid']?></td>
                                <td><?= $val['bankuser']?></td>
                                <td><?= $val['bank']?></td>
                                <td><?= $val['bankno']?></td>
                                <td><?= $val['amount']?></td>
                                <td><?= $val['get_amount']?></td>
                                <td><?= $val['addtimes']?></td>
                                <td>
                                <?php if($val['states']==8){?>
                                兑换
                                <?php }else{?>
                                提现
                                <?php }?>
                                </td>
                                <td>
                                <?php if($val['states']==0){
                                    echo "未处理";
                                }else{
                                    echo "已处理";
                                }?>
                                </td>
                              <td>
                                  <?php if($val['states']==0){?>
                                      <button class="layui-btn layui-btn-normal layui-btn-mini" id="up2">处理</button>
                                      <button class="layui-btn layui-btn-danger layui-btn-mini" id="del">取消</button>
                                  <?php }?>
                              </td>
                                <!--<td>
                                <button class="layui-btn  layui-btn-mini" id="edit">编辑</button>
                                <button class="layui-btn layui-btn-danger layui-btn-mini" id="del">删除</button>
                                </td>-->
                              </tr>
                          <?php } ?>
                          </tbody>
                     </table>
                     <div class="larry-table-page clearfix">
<!--                          <a href="javascript:;" class="layui-btn layui-btn-small" id="delall"><i class="iconfont icon-shanchu1"></i>删除</a>-->
				          <div id="page" class="page"></div>
			         </div>
			    </div>
		    </div>
		</div>
	</div>
</section>
<script type="text/javascript">
addU  = '<?= Url::to('/'.THISID.'/add'); ?>?cid=0';
editU = '<?= Url::to('/'.THISID.'/edit'); ?>?cid=0';
</script>
<!-- 分页用 -->
<link rel="stylesheet" type="text/css" href="/layui/uio/css2/layui.css" media="all">
<script language="JavaScript" src="/js/pc/pagePost.js"></script>
<script type="text/javascript">
var num   = '<?= $page->totalCount ?>';
var page  = '<?= ($page->page)+1 ?>';
var limit = <?= $page->defaultPageSize ?>;
Urs   = '<?= Url::to('/'.THISID.'/'); ?>';

layui.use(['layer','element'],function(){
    window.layer = layui.layer;
    var element = layui.element();
});

layui.use(['layer','element'],function(){
    window.layer = layui.layer;
    var element = layui.element();
});
layui.use('laydate', function(){
	var laydate = layui.laydate;
	laydate.render({
		elem: '#begtime',
		format: 'yyyy-MM-dd'
	});
	laydate.render({
		elem: '#endtime',
		format: 'yyyy-MM-dd'
	});
});
</script>