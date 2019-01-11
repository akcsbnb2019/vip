<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

AppAsset::addJs($this, 'bootstrap.min');
AppAsset::addJs($this, 'page');
AppAsset::addJs($this, 'icheck.min','js/plugins/iCheck/');
AppAsset::addCss($this, 'custom','css/plugins/iCheck/');
AppAsset::addJs($this, 'main3');

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
            	<div class="ibox-content">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'sForm',
                        'action' => Url::to('/'.THISID.'/index'),
                        'method'=>'post',
                        'options' => [
                            'class' => 'form-inline',
                        ],
                        'fieldConfig'=>['template'=> "{input}"]
                    ]);
                    ?>
                    <div class="form-group">
                        <label for="exampleInputEmail2" class="sr-only">用户名</label>
                        <?= $form->field($user, 'loginname')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>"请输入要查找的用户名"]) ?>
                        <input type="hidden" id="user-rid" class="form-control" name="User[rid]" autofocus="" placeholder="请输入要查找的用户名">
                    </div>
                        <div class="form-group">
                        <?= Html::button('立即查询', ['class' => 'btn btn-primary btn-info', 'name' => 'form-button','id'=>'sxlis']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="ibox-content iboxo">
                    <table class="table table-hover d-border" id="tables">
                        <thead>
                            <tr>
                                <th class="pabc">会员编号</th>
                                <th class="center">级别</th>
                                <th class="center">推荐人</th>
                                <th class="center">安置人</th>
                                <th class="center">会员昵称</th>
                                <th class="center">电话</th>
                                <th class="center">注册时间</th>
                                <th class="center">操作</th>
                            </tr>
                        </thead>
                        <tbody id="lists">
                        <?php foreach($model as $key=>$val){?>
                            <tr>
                                <td class="pabc"><?=$val['loginname']; ?></td>
                                <td><?php if($val['standardlevel']>0){echo "VIP".$val['standardlevel'];}else{echo "普通";} ?></td>
                                <td><?=$val['rid']; ?></td>
                                <td><?=$val['pid']; ?></td>
                                <td><?=$val['truename'];?></td>
                                <td><?=$val['tel'];?></td>
                                <td><?=$val['addtime'];?></td>
                                <td class="text-navy"><a href="javascript:ckrid('<?=$val['loginname']; ?>')">查看</a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <nav class="tpage" aria-label="Page navigation">
                		<div id="pagination"></div>
                	</nav>
                </div>
                
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="nums" name="count" value="<?= $page->totalCount ?>">
<input type="hidden" id="page" value="<?= $page->page+1 ?>">