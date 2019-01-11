<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '会员管理';
$this->params['breadcrumbs'][] = $this->title;

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
            <div class="larry-separate"></div>
            <div class="layui-tab-content larry-personal-body clearfix mylog-info-box">
                <div class="demoTable" id="forms">
                    <?php $form = ActiveForm::begin(['id' => 'sel_name-form','method'=>'post']); ?> 搜索：
                    <div class="layui-inline">
                        <?= $form->field($user, 'loginname')->textInput(['autofocus' => true, 'placeholder' => '用户名&姓名','value'=>(isset($_POST['User']['loginname'])?$_POST['User']['loginname']:'')]) ?>
                    </div>
                  	-
                  	<div class="layui-inline">
                    	<input class="form-control layui-input" name="addtime" id="addtime" value="<?=(isset($_POST['addtime'])?$_POST['addtime']:'')?>" placeholder="起始时间">
                  	</div>
                  	&
                  	<div class="layui-inline">
                    	<input class="form-control layui-input" name="endtime" id="endtime" value="<?=(isset($_POST['endtime'])?$_POST['endtime']:'')?>" placeholder="结束时间">
                  	</div>
                  	-
                  	<div class="layui-inline">
                    <select class="form-control" name="level" id="level" lay-filter="aihao">
							<option value="" selected="selected">不限等级</option>
							<option value="10">普通用户</option>
							<option value="-1">VIP会员</option>
							<option value="1">VIP1会员</option>
							<option value="2">VIP2会员</option>
							<option value="3">VIP3会员</option>
							<option value="11">代理商</option>
							<option value="12">微超市</option>
							<option value="13">店铺</option>
						</select>
					</div>
                    <?= Html::submitButton('搜索', ['class' => 'layui-btn', 'data-type' => 'reload']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <!-- 菜单列表 -->
                <div class="layui-tab-item layui-field-box layui-show">
                    <table class="layui-table table-hover" lay-even="" lay-skin="nob" id="lists">
                        <thead>
                        <tr>
                        	<th><input type="checkbox" id="selected-all"></th>
                            <th>用户名</th>
                            <th>类型</th>
                            <th>电子币</th>
                            <th>爱心基金</th>
                            <th>股权</th>
                            <th>推荐人</th>
                            <th>安置人</th>
                            <th>级别</th>
                            <th>姓名</th>
                            <th>开户行</th>
                            <th>银行卡号</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="tbodys">
                        <?php foreach($model as $key=>$val){?>
                            <tr>
                                <td><input type="checkbox" value="<?= $val['id']?>" class="id"></td>
                                <td><?= $val['loginname']?></td>
                                <td><?= $val['standardlevel']>0?"VIP".$val['standardlevel']."会员":"普通用户";?></td>
                                <td><?= $val['amount']?></td>
                                <td><?= $val['aixinjijin']?></td>
                                <td><?= $val['yuanshigu']?></td>
                                <td><?= $val['rid']?></td>
                                <td><?= $val['pid']?></td>
                                <td><?php 
                                $pos =['6'=>'总裁董事','7'=>'董事','8'=>'高级总监','9'=>'总监','10'=>'高级经理','11'=>'经理','12'=>'主任','13'=>'见习主任'];
                                echo (isset($pos[$val['position']])?$pos[$val['position']]:'无级别');
                                ?></td>
                                <td><?= $val['truename']?></td>
                                <td><?= $val['bankname']?></td>
                                <td><?= $val['bank']?></td>
                                <td>
                                <?php if($val['lockuser']){?>
                                <button class="layui-btn layui-btn-primary layui-btn-mini" id="up1">已冻结</button>
                                <?php }else{?>
                                <button class="layui-btn layui-btn-normal layui-btn-mini" id="up2">正常</button>
                                <?php }?>
                                </td>
                                <td>
                                    <input type="hidden" id="id" class="id" value="<?=$val['id']?>">
                                    <button class="layui-btn  layui-btn-mini" id="edit" >编辑</button>
                                    <a href="/user/obsedit?id=<?=$val['id']?>" class="layui-btn  layui-btn-mini" id="absedit">其它</a>
                                    <a href="/user/fund?id=<?=$val['id']?>" class="layui-btn  layui-btn-mini layui-btn-warm" id="absedit">资金</a>
                                    <a href="/user/seltotal?id=<?=$val['id']?>" class="layui-btn  layui-btn-mini layui-btn-primary" id="absedit">奖金</a>
                                    <button class="layui-btn layui-btn-danger layui-btn-mini" id="deluser" >删除</button>
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
<!-- 分页用 -->
<link rel="stylesheet" type="text/css" href="/layui/uio/css2/layui.css" media="all">
<link rel="stylesheet" type="text/css" href="/css/pc/list.css" media="all">
<script language="JavaScript" src="/js/pc/pagePost.js"></script>
<script type="text/javascript">
	/* 分页用 */
    var num = '<?= $page->totalCount ?>';
    var page = '<?= ($page->page)+1 ?>';
    var limit = <?= $page->defaultPageSize ?>;
    
    editU = '<?= Url::to('/'.THISID.'/edit'); ?>?cid=0';
    layuiTime();
    $(function(){
        $('#level').find('option').each(function(a,b){
    		if(this.value == '<?= $level; ?>'){
    			this.selected = 'selected';
            }
  	  	});
    });
</script>

