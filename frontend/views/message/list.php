<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

AppAsset::addJs($this, 'bootstrap.min');
AppAsset::addJs($this, 'content.min');
AppAsset::addJs($this, 'icheck.min','js/plugins/iCheck/');
AppAsset::addCss($this, 'custom','css/plugins/iCheck/');
$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'select-form',
                        'method'=>'post',
                        'options' => [
                            'class' => 'form-inline',
                        ],
                        'fieldConfig'=>['template'=> "{input}"]
                    ]);
                    ?>
                    <div class="form-group">
                        <label for="exampleInputEmail2" class="sr-only">用户名</label>
                        <?= $form->field($message, 'title1')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>"请输入要查找的问题"]) ?>
                    </div>
                    <!--                        <button class="btn btn-white" type="submit">登录</button>-->
                    <?= Html::submitButton('查询', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    <a href="/message/send" class = "btn btn-warning" style="float: right" >新增留言</a>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <?php foreach($model as $key=>$val){?>
                        <div class="m-i-d3"><a href="/message/messageinfo?id=<?=$val['id']?>"><span><?=$val['title']?></span> </a>
                            <?php if($val['flag']==0):?>
                                <div class="m-l-d btn btn-warning" onclick="isoff(<?=$val['id']?>)">
                                    关闭
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="m-i-d2"><span><?= date('Y-m-d',$val['addtime'])?></span></div>
                        <div class="hr-line-dashed"></div>
                    <?php } ?>
                    <!--<table class="table table-hover d-border">
                        <thead>
                            <tr>
                                <th>问题</th>
                                <th>时间</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody  id="tbodys">
                        <?php /*foreach($model as $key=>$val){*/?>
                            <tr>
                                <td><?/*=$val['title']; */?></td>
                                <td><?/*= date('Y-m-d H:i:s',$val['addtime'])*/?></td>
                                <td><?/*=$val['flag']==1?"已解决":"未解决"; */?></td>
                                <td><a href="/message/messageinfo?id=<?/*=$val['id']*/?>">查看<?php /*if ($val['states'] == 2) {*/?><span class="layui-badge-dot"></span><?php /*}*/?></a></td>
                            </tr>
                        <?php /*} */?>
                        </tbody>
                    </table>-->
                </div>
            </div>
        </div>
    </div>
</div>


	<!--<div class="larry-table-page clearfix" style="margin:0 0 0 10px;">
		<div id="page" class="page"></div>
	</div>
    <script language="JavaScript" src="/pc/js/pagePost.js"></script>
    <script type="text/javascript">
		var num   = '<?/*= $page->totalCount */?>';
		var page  = '<?/*= ($page->page)+1 */?>';
		var limit = '<?/*= $page->defaultPageSize */?>';
		var _csrf = '<?/*= Yii::$app->request->csrfToken */?>';
		var url = '/message/list';
	</script>-->
<script type="text/javascript">
    function isoff(id) {
        $.get("/message/infooff?id=" + id, function (d) {
           layer.msg(d.msg, {icon: d.status});
        });
    }
</script>
