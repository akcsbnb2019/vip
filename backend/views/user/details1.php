<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\assets\AppAsset;
use yii\helpers\Url;

?>
<style>
    .tt-font-size-16 {font-size:16px;}
    .tt-font-size-18 {font-size:18px;}
    .tt-padding-20-0 {padding:20px 0;}
    .tt-cross-line {height:20px;background: #f2f2f2;}
    .tt-layui-elem-quote {margin-bottom: 0 !important;background: #fff !important;}
    #tt_style_score .tt-layui-card {background-color: #C9C9C9;border-radius:6px 6px 2px 2px;}
    #tt_style_score .tt-layui-card .tt-layui-card-header {height:36px;line-height:44px;padding:0 15px;color:#fff;text-align: center;}
    #tt_style_score .tt-layui-card .tt-layui-card-body {padding: 10px 15px; line-height: 24px;}
    #tt_style_score .tt-layui-card .tt-layui-col-md {text-align: center;height:30px;line-height: 30px;}
    #tt_style_score .tt-layui-card .tt-layui-col-md1 {background-color: #F2F2F2;}
    #tt_style_score .tt-layui-card .tt-layui-col-md2 {background-color: #FFF;}
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
		<div class="col-sm-12">
			<div class="ibox">
                <blockquote class="layui-elem-quote mylog-info-tit">
                    <ul class="layui-tab-title">
                        <li class="layui-btn layui-this"><i class="layui-icon">&#xe60a;</i>第<?= $total['scount'];?>期</li>
                        <a class="layui-btn layui-btn-small larry-log-del" href="<?= Url::to("/".THISID."/seltotal?id=".$id); ?>"><i class="iconfont icon-huishouzhan1"></i>返回</a>
                    </ul>
                </blockquote>
				<div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c center-block"><strong class="center-block" style="color:#2d97d3 ; text-align: center">YQ</strong></div>
								<div class="row">
									<div class="col-sm-6 tt-style-score" style="border-right:1px solid #ddd;text-align: center">本期积分</div>
									<div class="col-sm-6 tt-style-score" style="text-align: center;"><?=(isset($model['alltj']['zong'])?$model['alltj']['zong']:0)?></div>
								</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#fa631a; text-align: center">XS</strong></div>
								<div class="row">
									<div class="col-sm-6 tt-style-score" style="border-right:1px solid #1ab394; text-align: center">本期积分</div>
									<div class="col-sm-6 tt-style-score" style="text-align: center"><?=(isset($model['allxs']['zong'])?$model['allxs']['zong']:0)?></div>
								</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#fa4556; text-align: center">GL</strong></div>
								<div class="row">
									<div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6;text-align: center">本期积分</div>
									<div class="col-sm-6 tt-style-score" style="text-align: center"><?=(isset($model['allgl']['zong'])?$model['allgl']['zong']:0)?></div>
								</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#EE82EE ; text-align: center">JC</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6; text-align: center">本期积分</div>
                                    <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$model['alljb']['zong']?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#FF1493; text-align: center">CY</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6; text-align: center">本期积分</div>
                                    <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$model['alljc']['zong']?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#0000aa; text-align: center">FXZF</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6; text-align: center">本期积分</div>
                                    <?php if($total['fuxiao']>=300){?>
                                        <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$total['fuxiao']-300?></div>
                                    <?php }else{?>
                                        <div class="col-sm-6 tt-style-score" style="text-align: center"><?= 0;?></div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
	                    <?php if($total['declaration']>0):?>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#0000aa; text-align: center">DLFW</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6; text-align: center">本期积分</div>
                                    <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$total['declaration']?></div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#ffc341; text-align: center">AXJJ</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #ddd; text-align: center">本期积分</div>
                                    <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$model['alllove']['zong']?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                            <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#4ab624; text-align: center">FXQ</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1ab394;text-align: center">本期积分</div>
	                                <?php if($total['fuxiao']>=300){?><div class="col-sm-6 tt-style-score" style="text-align: center"><?= 300;?></div><?php }else{?><div class="col-sm-6 tt-style-score" style="text-align: center"><?=$total['fuxiao']?></div><?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#0bc2d2; text-align: center">LY</strong></div>
                                <div class="row">
                                    <div class="col-sm-6 tt-style-score" style="border-right:1px solid #1c84c6;text-align: center">本期积分</div>
                                    <div class="col-sm-6 tt-style-score" style="text-align: center"><?=$model['allly']['zong']?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading tt-t-a-c"><strong class="center-block" style="color:#7B68EE  ;text-align: center" >实发奖金</strong></div>
								<div class="row">
									<div class="col-sm-6 tt-style-score" style="border-right:1px solid #23c6c8;text-align: center">本期积分</div>
									<div class="col-sm-6 tt-style-score" style="text-align: center"><?=$total['bonus']?></div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
				
			</div>
		</div>
    </div>
</div>
