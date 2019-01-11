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
<style>
.zhengshu{ margin: 0 auto; width:100%; margin:0px 0; position:relative; font-size: 12px;}

.zhengshu_01{ margin: 0 auto; width:100%; height:75px; background:url(/img/zs/zs_05.png) top center no-repeat;background-size:100%; }
.zhengshu_02{ margin: 0 auto; width:100%; height:74px; background:url(/img/zs/zs_06.png) no-repeat;}
.zhengshu_03{ margin: 0 auto; width:100%; height:52px; background:url(/img/zs/zs_07.png) no-repeat;}

.zhengshu_04{/*  margin: 0 auto; width:100%; height:228px; background:url(/img/zs_08.png) no-repeat; */}
.zhengshu_04 img{ float:left; width:120px; height:120px; margin-left:200px; margin-top:20px;}

.shuliang { position:absolute;  top:29%; right:31%;}
.xingming { position:absolute;  top:29%; left:28%;}
.xingming2 { position:absolute;  top:29%; right:26%;}
.shijian { position:absolute;  top:36%; left:25%;}
.haoma { position:absolute;  top:36%; right:16%;}

.haina{ position:absolute; width:20%; top:10px; left:30%; }

html,body {overflow-y:scroll !important; overflow-x:scroll !important;min-width:460px;max-width:510px;margin:auto;width:70%;}

@media only screen and (max-width: 480px) {

/*.shuliang {top: 20%;}
.xingming { top:30%;left:28%;}
.xingming2 {  top:30%; }
.shijian {top:30%; left:28%;}
.haoma { top:30%; right:11%;}*/

}
</style>
<div>
    <div style="height:100px;"></div>
    <div class="zhengshu">
        <img src="/img/zs/zs_01.png" style="display:block;width:100%;" />
    </div>
    <div class="zhengshu">
        <img src="/img/zs/zs_02.png" style="display:block;width:100%;" />
    </div>
    <div class="zhengshu">
        <img src="/img/zs/zs_03.png" style="display:block;width:100%;" />
    </div>
    <div class="zhengshu">
        <img src="/img/zs/zs_04.png" style="display:block;width:100%;" />
    </div>
    <div class="zhengshu">
        <img src="/img/zs/zs_05.png" style="display:block;width:100%;" />
        <span class="shuliang"><?=$model['yuanshigu']?></span>
    </div>
    <div class="zhengshu">
        <img src="/img/zs/zs_06.png" style="display:block;width:100%;" />
        <span class="xingming"><?=$model["loginname"]?></span>
        <span class="xingming2"><?=$model["truename"]?> </span>
    </div>
    <div class="zhengshu"><img src="/img/zs/zs_07.png" style="display:block;width:100%;" />
        <span class="shijian"><?=$model['addtime']?></span>
        <span class="haoma"><?=substr($model["identityid"],0,strlen($model["identityid"])-3)."****";?></span>
    </div>
    <div class="zhengshu"><img src="/img/zs/zs_08.png" style="display:block;width:100%;" />
        <img src="/img/haina.gif" class="haina"/>
    </div>
</div>


