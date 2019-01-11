<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\WapAsset;
use yii\helpers\Url;
use frontend\models\Region;
use frontend\region\Region as re;

WapAsset::WapJs($this, 'page');
WapAsset::WapJs($this, 'icheck.min','mobile/js/iCheck/');
WapAsset::WapCss($this, 'custom','mobile/css/iCheck/');
WapAsset::WapJs($this, 'main');

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.radio input[type=radio] {display:inline;}
.tt-card-header {float:left;}
.list2_xiu li {margin-top: -15px !important;}
#leleo select{-webkit-appearance:menulist;width:31% !important;margin:0 1%;border:1px #ccc solid;border-radius:3px;font-size:14px;height:34px;float:left;}
</style>
<div id="app">
    <div class="page">
    <!-- 头部 -->
    <?= $this->render('/layouts/head.php'); ?>
    <!-- 头部 -->
        <div class="page-content" style="padding-left:0;padding-right:0;">
            <div class="list font_size_13">

                <div class="card">
                  <div class="card-content">
                    <div class="card-content-inner">
                      <div class="row no-gap">
                        <div class="col-33 tt-card-header" style="background: #e9f1ff;"><b>说明</b></div>
                        <div class="col-33 tt-card-header" style="background: #e9f1ff;"><b>升级前</b></div>
                        <div class="col-33 tt-card-header" style="background: #e9f1ff;"><b>升级后</b></div>

                        <div class="col-33 tt-card-header">级别</div>
                        <div class="col-33 tt-card-header" style="color: red">VIP<?=$row[$row['level']]['level']?></div>
                        <div class="col-33 tt-card-header" style="color: green">VIP<?=$row[$row['newvip']]['level']?></div>

                        <!--<div class="col-33 tt-card-header">封顶收益</div>
                        <div class="col-33 tt-card-header" style="color: red"><?/*=$row[$row['level']]['fd']*/?></div>
                        <div class="col-33 tt-card-header" style="color: green"><?/*=$row[$row['newvip']]['fd']*/?></div>-->
                        <?php
                            $form = ActiveForm::begin([
                                'id' => 'form1',
                                'action' => Url::to('/'.THISID.'/upvip?id='.$row['newvip']),
                                'options' => [
                                    'style' => 'margin:auto;',
                                ]
                            ]);
                        ?>
                        <div class="col-33 tt-card-header">套餐</div>
                        <div class="col-66 tt-card-header" style="color: red">
                        
                         <?php
                            $model->goods_id = $goods_check[$row['level'].'-'.$row['newvip']];
                            echo $form->field($model, 'goods_id',[
                                'template'=> "{input}"
                            ])->radioList($goods[$row['level'].'-'.$row['newvip']])->label(false);
                        ?>
                        <a href='javascript:addgoods()'>选定套餐后点击此处查看</a>
                        
                        </div>
                        <div class="col-33 tt-card-header">电子币余额</div>
                        <div class="col-66 tt-card-header" style="color: green"><?=$row['amount']?></div>

                        <div class="col-33 tt-card-header">所需电子币</div>
                        <div class="col-66 tt-card-header" style="color: green"><?=$row['newamount']?></div>


						<div style="clear:both;"></div>
                        <div class="form form_xiu">
                            <div class="list no-hairlines-md list2 list4 list2_xiu">
                                <ul>
                                    <li class="item-content item-input inline-label xiu2">
                                        <div class="ios item-inner item-inner-dh">
                                          <div class="item-title item-label text-align-right form1" style="padding-top:20px;">收货人</div>
                                          <div class="item-input-wrap inputx inputx_p">
                                            <?= $form->field($model, 'consignee')->textInput(['placeholder' => '']) ?>
                                          </div>
                                        </div>
                                    </li>
                                    <li class="item-content item-input inline-label xiu2">
                                        <div class="ios item-inner item-inner-dh" style="height:58px;margin-bottom:12px;">
                                          <div class="item-title item-label text-align-right form1" style="padding-top:14px;">地区</div>
                                          <div class="item-input-wrap inputx inputx_p" id="leleo">
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
                                </ul>
                            </div>
                            <div class="row row_xiu">
                                <div class="col-10"></div>
                            <?= $form->field($model, 'up_standardlevel')->textInput()->hiddenInput(['value'=>$row['newvip']])->label(false); ?>
                            <?= Html::submitButton('升级', ['class' => 'button button-fill', 'name' => 'form-button']) ?>
                                <div class="col-10"></div>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                      </div>
                    </div>
                  </div>
                </div>

            </div>
            <nav class="tpage" aria-label="Page navigation">
                <div id="pagination"></div>
            </nav>
            
        </div>
    </div>
    <!-- 菜单 -->
    <?= $this->render('/layouts/head_menu.php'); ?>
    <!-- 菜单 -->
</div>
<input type="hidden" id="nums" name="count" value="<?//=$page->totalCount ?>">
<input type="hidden" id="page" value="<?//=$page->page+1 ?>">
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