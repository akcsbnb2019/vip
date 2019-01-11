<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
/*use frontend\assets\AppAsset;

AppAsset::register($this);

AppAsset::addCss($this, 'main');*/

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox ">
                <div class="form-group" style="text-align: right;">
                        <a class="btn btn-primary btn-info" href="javascript:history.go(-1);">返回</a>
                    </div>
                <div class="zhengshu">
                    <img src="/img/zs/zs_01.png" />
                    <img src="/img/zs/zs_02.png" />
                    <img src="/img/zs/zs_03.png" />
                    <img src="/img/zs/zs_04.png" />
                    <div class="zhengshu_01">
                        <span class="shuliang"><?=$model['yuanshigu']?></span>
                    </div>
                    <div class="zhengshu_02">
                        <span class="xingming"><?=$model["truename"]?> </span>
                        <span class="bianhao"><?=$model["loginname"]?></span>
                    </div>
                    <div class="zhengshu_03">
                        <span class="shijian"><?=$model['addtime']?></span>
                        <span class="haoma"><?=substr($model["identityid"],0,strlen($model["identityid"])-3)."****";?></span>
                    </div>
                    <div class="zhengshu_04">
                        <img src="/img/haina.gif" />
                    </div>
            </div>
        </div>
    </div>
</div>
