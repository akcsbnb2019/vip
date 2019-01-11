<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use frontend\models\Region;
use frontend\region\Region as re;

AppAsset::register($this);

AppAsset::addJs($this, 'bootstrap.min');
AppAsset::addJs($this, 'content.min');
AppAsset::addJs($this, 'icheck.min','js/plugins/iCheck/');
AppAsset::addCss($this, 'custom','css/plugins/iCheck/');
AppAsset::addJs($this, 'mForm');


$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
.selfr1,.selfr2,.selfr3{width: 30%; float: left; margin-right: 1%; max-width: 180px;}
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12 animated fadeInRight">
            <div class="ibox-content">
	            <?php
		            $form = ActiveForm::begin([
			            'id' => 'form1',
			            'action' => Url::to('/'.THISID.'/upvip?id='.$row['newvip']),
			            'options' => [
				            'class' => 'form-horizontal',
			            ],
			            'fieldConfig'=>['template'=> "<div class='form-group'><div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6 labrs'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div></div>"]
		            ]);
	            ?>
                <div class="ibox-content iboxo">
                    <table class="table table-hover d-border" id="tables">
                        <thead>
                        <tr>
                            <th >说明</th>
                            <th >升级前</th>
                            <th >升级后</th>
                        </tr>
                        </thead>
                        <tbody id="lists">
                        <tr>
                            <td>级别</td>
                            <td style="color: red">VIP<?=$row[$row['level']]['level']?></td>
                            <td style="color: green">VIP<?=$row[$row['newvip']]['level']?></td>

                        </tr>
                        <tr>
                            <td>套餐</td>
                            <td style="color: red " colspan="2">
                                <?php
	                                $model->goods_id = $goods_check[$row['level'].'-'.$row['newvip']];
                                    echo $form->field($model, 'goods_id',[
	                                    'template'=> "<div class='form-group' style='text-align:center;line-height: 5px; padding-top: 25px;'><div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-4 labrs' >{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div></div>"
                                    ])->radioList($goods[$row['level'].'-'.$row['newvip']])->label(false);
                                ?>
                                <a href='javascript:addgoods()' style='float: right;line-height: 5px; display: block;'>选定套餐后点击此处查看</a>
                            </td>
                        </tr>
                        <tr>
                            <td>电子币余额</td>
                            <td style="color: red"></td>
                            <td style="color: green"><?=$row['amount']?></td>
                        </tr>
                        <tr>
                            <td>所需电子币</td>
                            <td style="color: red"></td>
                            <td style="color: green"><?=$row['newamount']?></td>
                        </tr>
                        
                        <!--<tr>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
						</tr>-->

                        </tbody>
                    </table>
                    <nav class="tpage" aria-label="Page navigation">
                        <div id="pagination"></div>
                    </nav>
                </div>
               
	            <?= $form->field($model, 'up_standardlevel')->textInput()->hiddenInput(['value'=>$row['newvip']])->label(false); ?>
                <?= $form->field($model, 'consignee',[
                    'template'=> "<div class='form-group'><div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-4 labrs'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div></div>"
                ])->textInput(); ?>

                <?= $form->field($model, 'district')->widget(re::className(),[
                    'model'=>$model,
                    'url'=> Url::toRoute(['get-region']),
                    'province'=>[
                        'attribute'=>'province',
                        'items'=>Region::getRegion(),
                        'options'=>['class'=>'form-control form-control-inline selfr1','prompt'=>'选择省份']
                    ],
                    'city'=>[
                        'attribute'=>'city',
                        'items'=>[],
                        'options'=>['class'=>'form-control form-control-inline selfr2','prompt'=>'选择城市']
                    ],
                    'district'=>[
                        'attribute'=>'district',
                        'items'=>[],
                        'options'=>['class'=>'form-control form-control-inline selfr3','prompt'=>'选择县/区']
                    ]
                ]);
                ?>
                <?= $form->field($model, 'address',[
                    'template'=> "<div class='form-group'><div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-4 labrs'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div></div>"
                ])->textInput(); ?>
                <?= $form->field($model, 'tel',[
                    'template'=> "<div class='form-group'><div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-4 labrs'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div></div>"
                ])->textInput(); ?>
                <?= $form->field($model, 'zipcode',[
                    'template'=> "<div class='form-group'><div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-4 labrs'>{input}</div>\n<div class='col-sm-4' id='errer'>{error}</div></div>"
                ])->textInput(); ?>

                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-4">
                        <?= Html::submitButton('升级', ['class' => 'btn btn-w-m btn-info btno', 'name' => 'form-button']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    function addgoods() {
        var goods_id = $(":checked").val();
        
        layer.open({
            type: 1,
            title: false,
            closeBtn: 2,
            area: '751px',
            offset: ['150px', '100px'],
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: '<img src="/img/vip/goods-'+goods_id+'.jpg">'
        });
        
    }
    /*layer.open({
        type: 1,
        title: false,
        closeBtn: 2,
        area: '1',
        skin: 'layui-layer-nobg', //没有背景色
        shadeClose: true,
        content: '<div class="layui-layer-wrap"><img src="/img/vip/goods-'+goods_id+'.jpg"></div>'
    });*/

</script>