<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\WapAsset;
use yii\helpers\Url;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
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
                      <div class="row no-gap" style="line-height: 30px;">
                        <div class="col-33" style="background: #e9f1ff;text-align: left !importent;"><b style="padding-left:20px;">升级前</b></div>
                        <div class="col-33" style="background: #e9f1ff;text-align: left !importent;"><b style="padding-left:20px;">升级后</b></div>
                        <div class="col-33" style="background: #e9f1ff;text-align: center;"><b>升级时间</b></div>
                        <?php foreach($model as $key=>$val){?>
                        <div class="col-33" style="text-align: left !importent;"><img src="/img/<?=$val['old_level']; ?>.png" style="height:18px;vertical-align: middle;padding-left:20px;"/> <?=$val['old_levels']; ?></div>
                        <div class="col-33" style="color: #34c08b;text-align: left !importent;"><img src="/img/<?=$val['level']; ?>.png" style="height:18px;vertical-align: middle;padding-left:20px;"/> <?=$val['levels']; ?></div>
                        <div class="col-33 tt-card-header"><?=date("Y-m-d",$val['add_time']);?></div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>

            </div>

        </div>
    </div>
    <!-- 菜单 -->
    <?= $this->render('/layouts/head_menu.php'); ?>
    <!-- 菜单 -->
</div>
