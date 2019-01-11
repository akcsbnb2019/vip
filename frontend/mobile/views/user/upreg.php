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

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="app">
    <div class="page">
    <!-- 头部 -->
    <?= $this->render('/layouts/head.php'); ?>
    <!-- 头部 -->
        
        <div class="page-content ov" style="padding-right:10px;padding-left:10px;">
            
            <?php 
            $form = ActiveForm::begin([
                'id' => 'form1',
                'action' => Url::to('/'.THISID.'/upreg'),
                'options' => [
                    'class' => 'form-horizontal',
                ],
                'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-4' id='runame-errer'>{error}</div>"]
            ]);
            ?>
            <div class="card">
                <div class="card-content">
                    <div class="card-content-inner">
                        <div class="row no-gap">
                            <div class="col-30 tt-card-header" style="background: #e9f1ff;"><b>说明</b></div>
                            <div class="col-70 tt-card-header" style="background: #e9f1ff;"><b>详情</b></div>

                            <!--<div class="col-33 tt-card-header">封顶收益</div>
                        <div class="col-33 tt-card-header" style="color: red"><?/*=$row[$row['level']]['fd']*/?></div>
                        <div class="col-33 tt-card-header" style="color: green"><?/*=$row[$row['newvip']]['fd']*/?></div>-->
                            <div class="col-33 tt-card-header">套餐</div>
                            <div class="col-66 tt-card-header" style="color: red">

                                <?php
//                                echo $goods_check['0-3'];die;
                                foreach ($goods['0-3'] as $key=>$val){
                                    if($key == $goods_check['0-3']){
                                        echo '<input type="radio" name="OrderInfo[goods_id]" value = "'.$key.'" checked /> '.$val."<br>";
                                    }else{
                                        echo '<input type="radio" value = "'.$key.'" name="OrderInfo[goods_id]" > '.$val."<br>";
                                    }

                                }
                                ?>
                                <a href='javascript:addgoods()'>选定套餐后点击此处查看</a>

                            </div>
                            <div class="col-30 tt-card-header">电子币余额</div>
                            <div class="col-70 tt-card-header" style="color: green"><?=$row['amount']?></div>

                            <div class="col-30 tt-card-header">所需电子币</div>
                            <div class="col-70 tt-card-header" style="color: green">27000</div>


                            <div style="clear:both;"></div>
                            <div class="form form_xiu">
                                <div class="list no-hairlines-md list2 list4 list2_xiu">
                                    <ul>
                                        <li class="item-content item-input inline-label xiu2">
                                            <div class="ios item-inner item-inner-dh">
                                                <div class="item-title item-label text-align-right form1" style="padding-top:20px;">收货人姓名</div>
                                                <div class="item-input-wrap inputx inputx_p">
                                                    <?= $form->field($model, 'consignee')->textInput(['placeholder' => '']) ?>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="item-content item-input inline-label xiu2">
                                            <div class="ios item-inner item-inner-dh">
                                                <div class="item-title item-label text-align-right form1" style="padding-top:20px;">地区</div>
                                                <div class="item-input-wrap inputx inputx_p" style="height:50px !important;">
                                                    <?= $form->field($model, 'district')->widget(re::className(),[
                                                        'model'=>$model,
                                                        'url'=> Url::toRoute(['get-region']),
                                                        'province'=>[
                                                            'attribute'=>'province',
                                                            'items'=>Region::getRegion(),
                                                            'options'=>['class'=>'form-control form-control-inline selfr1','style'=>'height:30px;width:33.33%;float:left;','prompt'=>'省份']
                                                        ],
                                                        'city'=>[
                                                            'attribute'=>'city',
                                                            'items'=>[],
                                                            'options'=>['class'=>'form-control form-control-inline selfr2','style'=>'height:30px;width:33.33%;float:left;','prompt'=>'城市']
                                                        ],
                                                        'district'=>[
                                                            'attribute'=>'district',
                                                            'items'=>[],
                                                            'options'=>['class'=>'form-control form-control-inline selfr3','style'=>'height:30px;width:33.33%;float:left;','prompt'=>'县/区']
                                                        ]
                                                    ]);
                                                    ?>
                                                    <div style="clear:both;"></div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="item-content item-input inline-label xiu2">
                                            <div class="ios item-inner item-inner-dh">
                                                <div class="item-title item-label text-align-right form1" style="padding-top:20px;">详细地址</div>
                                                <div class="item-input-wrap inputx inputx_p">
                                                    <?= $form->field($model, 'address')->textInput(['placeholder' => '']) ?>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="item-content item-input inline-label xiu2">
                                            <div class="ios item-inner item-inner-dh">
                                                <div class="item-title item-label text-align-right form1" style="padding-top:20px;">手机号</div>
                                                <div class="item-input-wrap inputx inputx_p">
                                                    <?= $form->field($model, 'tel')->textInput(['placeholder' => '']) ?>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="item-content item-input inline-label xiu2">
                                            <div class="ios item-inner item-inner-dh">
                                                <div class="item-title item-label text-align-right form1" style="padding-top:20px;">邮政编码</div>
                                                <div class="item-input-wrap inputx inputx_p">
                                                    <?= $form->field($model, 'zipcode')->textInput(['placeholder' => '']) ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php if(!empty($lname)): ?>
                                            <li class="item-content item-input inline-label xiu2">
                                                <div class="ios item-inner item-inner-dh">
                                                    <div class="item-title item-label text-align-right form1" style="padding-top:20px;">左区用户</div>
                                                    <div class="item-input-wrap inputx inputx_p" style="line-height:initial;height:48px;">
                                                        (<span style='color: red'><?=$lname?></span>) 是否使用
                                                        <label class="checkbox icon-checkbox-m">
                                                            <input type='checkbox' class='checs' value='1' name='User[isleft]' id='User-isleft' >
                                                            <i class="icon-checkbox"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php else:?>
                                            <li class="item-content item-input inline-label xiu2">
                                                <div class="ios item-inner item-inner-dh">
                                                    <div class="item-title item-label text-align-right form1" style="padding-top:20px;">左区用户</div>
                                                    <div class="item-input-wrap inputx inputx_p">
                                                        <?= $form->field($model, 'luname')->textInput([ 'placeholder' => '']) ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endif;?>
                                        <li class="item-content item-input inline-label xiu2">
                                            <div class="ios item-inner item-inner-dh">
                                                <div class="item-title item-label text-align-right form1" style="padding-top:20px;">右区用户</div>
                                                <div class="item-input-wrap inputx inputx_p">
                                                    <?= $form->field($model, 'runame')->textInput(['placeholder' => '请输入右区用户']) ?>
                                                </div>
                                            </div>
                                        </li>


                                    </ul>
                                </div>
                                <div class="row row_xiu">
                                    <div class="col-10"></div>
                                    <?= Html::submitButton('立即提交', ['class' => 'm_t_12 col-40 button button-raised button-fill lg_dl', 'name' => 'form-button']) ?>
                                    <?= Html::resetButton('重置', ['class' => 'm_t_12 col-40 button button-raised button-fill lg_dl', 'name' => 'reset']) ?>
                                    <div class="col-10"></div>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                    <!-- 菜单 -->
                    <?= $this->render('/layouts/head_menu.php'); ?>
                    <!-- 菜单 -->
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
    content: '<img style="width:100%;" src="/img/vip/goods-'+goods_id+'.jpg">'
    });

}
</script>
