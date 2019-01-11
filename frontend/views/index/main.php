<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use frontend\assets\AppAsset;
if (!$vfi2) {
	AppAsset::register($this);
	AppAsset::addJs($this, 'sweetalert.min','js/plugins/sweetalert/');
	AppAsset::addCss($this, 'sweetalert','css/plugins/sweetalert/');
	AppAsset::addJs($this, 'mVerify2');
}

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-6">
            <div class="ibox ">
                <div class="main-d1">
                    <div class="main-d1-d"><a href="/user/info"> <img src="/img/main-t.png" /></a></div>
                    <div class="main-d1-d1">
                        <table <?php if($model['position'] > 0 && $model['yuanshigu'] > 0):?>style="margin-top:16px;"<?php endif;?>>
                            <tbody>
                                <tr >
                                    <td class="table-tr-td1">用户编号：</td>
                                    <td class="table-tr-td2" colspan="2"><?=$model['loginname']?></td>
                                </tr>
                                <tr>
                                    <td>用户级别：</td>
                                    <td colspan="2"><?php if($model['standardlevel']>0):?>VIP<?=$model['standardlevel']?>会员<?php else:?>普通会员<?php endif;?></td>
                                </tr>
                                <?php if($model['yuanshigu']>0):?>
                                <tr>
                                    <td>福利会员：</td>
                                    <td class="table-tr-td2"><?php if($model['yuanshigu']>0){?>福利会员 <img src="/img/main-info.png"><?php }else{ echo "无"; }?></td>
                                    <td class="table-tr-td3"> <a href="/user/stockcert">查看股权证书</a></td>
                                </tr>
                            	<?php endif;?>
                                <?php if($model['position'] > 0):?>
                                <tr>
                                    <td>用户职位：</td>
                                    <td class="table-tr-td2" colspan="2">
                                        <a href="/user/position?uid=<?=Yii::$app->session->get('__id')?>"> 
                                        <?=$model['positions']?> 
                                            <img src="/img/<?=$model['position']?>.png" height=20/>
                                        </a>
                                </td>
                                </tr>
                                <?php endif;?>
                            	<?php if(Yii::$app->session->get('spwd')){ ?>
                            	<tr>
                                    <td>账号安全：</td>
                                    <td colspan="2">30%<a href="/user/pass?type=2">完善二级密码</a></td>
                                </tr>
                                <?php } ?>
                            	
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="main-d2">
                    <div class="main-d2-d">
                        <div class="main-d2-d-d1"><div>电子币余额<span>单位：元</span></div><h2 class="div-h2"><span class="div-h2-span1"><?=$model['amount']?></span></h2></div>
                        <div class="main-d2-d-d2"></div>
                    </div>
                    <div class="main-d2-d">
                        <div class="main-d2-d-d1"><div>商城累积积分<span>单位：个</span></div><h2 class="div-h2"><span class="div-h2-span2"><?=$model['pay_points_all']?></span></h2></div>
                        <div class="main-d2-d-d2"></div>
                    </div>
                    <div class="main-d2-d">
                        <div class="main-d2-d-d1"><div>大小区<span>单位：个</span></div><span style="display: block;margin: 4px 0px 0px 6px; font-size: 14px">左区：<span class="<?php if($model['cx_vipyeji1']>$model['cx_vipyeji2']):echo "div-h2-span2";elseif ($model['cx_vipyeji1']<$model['cx_vipyeji2']):echo "div-h2-span1";else:echo "div-h2-span3";endif;?>"><?=$model['cx_vipyeji1']?></span><br>右区：<span class="<?php if($model['cx_vipyeji1']>$model['cx_vipyeji2']):echo "div-h2-span1";elseif ($model['cx_vipyeji1']<$model['cx_vipyeji2']):echo "div-h2-span2";else:echo "div-h2-span3";endif;?>"><?=$model['cx_vipyeji2']?></span></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-d3">
            <div class="ibox-title">
                <h5>系统公告</h5>
            </div>
            <div class="ibox-content">
                <div id="morris-bar-chart">
                    <ul class="ul_li_tyle">
                        <?php foreach($neirong as $key=>$val){?>
                            <li <?php if ($key==0 || $key==1):?>class="li_type2"<?php endif; ?>><a href="/news/info?id=<?= $val['ArticleID']?>"><?=$val['title']?></a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>

        </div>

        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>帐号安全</h5>
                    <!--<div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>-->
                </div>
                <div class="ibox-content">
                    <!--<div id="morris-bar-chart">
                        <h5>安全完成度</h5>
                        <div class="progress">
                            <div style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="35" role="progressbar" class="progress-bar progress-bar-success">
                                <span class="sr-only">35% Complete (success)</span>

                            </div>

                        </div>
                                            </div>

-->
                    <div class="zhaq" style="width: 100%; height: 160px;">
                        <div class="ma-d-d1"><div>密码强度</div><?= $pwd?></div>
                        <div class="ma-d-d1"><div>二级密码</div><?php if(empty($model['pwd2'])):?><a href="/user/pass?type=2"><b class="ma-d-d1-b1">去完善</b></a><?php else:?><b class="ma-d-d1-b2">&#10004</b><?php endif;?></div>
                        <div class="ma-d-d1"><div>个人信息</div><?php if(empty($model['bankno'])||empty($model['identityid'])):?><a href="/user/edit"><b class="ma-d-d1-b1">去完善</b></a><?php else:?><b class="ma-d-d1-b2">&#10004</b><?php endif;?></div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>