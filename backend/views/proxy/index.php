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
		    <div class="demoTable" id="forms">
		    	<?php $form = ActiveForm::begin(['id' => 'menu-form']); ?>
              	搜索：
              	<div class="layui-inline">
                	<input class="form-control layui-input" name="s" id="search" autofocus="true" value="<?=(isset($_POST['s'])?$_POST['s']:'')?>" placeholder="用户名&姓名">
              	</div>
              	-
              	<div class="layui-inline">
                	<input class="form-control layui-input" name="addtime" id="addtime" value="<?=(isset($_POST['addtime'])?$_POST['addtime']:'')?>" placeholder="起始时间">
              	</div>
              	&
              	<div class="layui-inline">
                	<input class="form-control layui-input" name="endtime" id="endtime" value="<?=(isset($_POST['endtime'])?$_POST['endtime']:'')?>" placeholder="结束时间">
              	</div>
              	<button class="layui-btn" data-type="reload">搜索</button>
              	<?php ActiveForm::end(); ?>
            </div>
		         <!-- 菜单列表 -->
                <div class="layui-tab-item layui-field-box layui-show">
                     <table class="layui-table table-hover" lay-even="" lay-skin="nob" id="lists">
                          <thead>
                              <tr>
                              	  <th><input type="checkbox" id="selected-all"></th>
                                  <th>用户名</th>
                                  <th>姓名</th>
                                  <th>类型</th>
                                  <th>账户余额</th>
                                  <th>推荐人</th>
                                  <th>安置人</th>
                                  <th>开户行</th>
                                  <th>银行卡号</th>
                                  <th>激活时间</th>
                                  <th>状态</th>
                                  <th>操作</th>
                              </tr>
                          </thead>
                          <tbody id="tbodys">
                          <?php foreach($model as $key=>$val){?>
                              <tr>
                                <td><input type="checkbox" value="<?= $val['id']?>" class="id"></td>
                                <td><?= $val['loginname']?></td>
                                <td><?= $val['truename']?></td>
                                <td><?php if($val['dllevel']==1): echo "代理商"; elseif($val['dllevel']==2): echo "微超市"; elseif ($val['dllevel']==3): echo "店铺";elseif ($val['bd']==1): echo "报单中心"; endif;?></td>
                                <td><?= $val['amount']?></td>
                                <td><?= $val['rid']?></td>
                                <td><?= $val['pid']?></td>
                                <td><?= $val['bank']?></td>
                                <td><?= $val['bankno']?></td>
                                <td class="small"><font><?= str_replace(' ', '<br>', $val['jihuotime'])?><font></td>
                                <td>
                                <?php if($val['lockuser']){?>
                                <button class="layui-btn layui-btn-primary layui-btn-mini" id="up1">已冻结</button>
                                <?php }else{?>
                                <button class="layui-btn layui-btn-normal layui-btn-mini" id="up2">正常</button>
                                <?php }?>
                                </td>
                                <td>
                                    <input type="hidden" id="id" class="id" value="<?=$val['id']?>">
                                    <button class="layui-btn layui-btn-warm layui-btn-mini" id="add" >电子券充值</button>
                                    <button class="layui-btn  layui-btn-mini" id="edit" >编辑</button>
                                </td>
                              </tr>
                          <?php } ?>
                          </tbody>
                     </table>
                     <div class="larry-table-page clearfix">
                     	  <a href="javascript:;" class="layui-btn layui-btn-small" id="delall"><i class="iconfont icon-shanchu1"></i>冻结</a>
				          <div id="page" class="page"></div>
			         </div>
			    </div>
		    </div>
		</div>
	</div>
</section>


<link rel="stylesheet" type="text/css" href="/layui/uio/css2/layui.css" media="all">
<script language="JavaScript" src="/js/pc/pagePost.js"></script>
<script type="text/javascript">
    /* 分页用 */
    var num = '<?= $page->totalCount; ?>';
    var page = '<?= ($page->page)+1; ?>';
    var limit = <?= $page->defaultPageSize; ?>;

    editU = '<?= Url::to('/user/edit'); ?>?cid=0';
    layuiTime();
</script>
<style>
.layui-field-box .layui-table tr td.small{font-size: 11px; line-height: 15px; padding: 0px 5px;}
</style>
