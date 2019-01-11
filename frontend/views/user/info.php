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
AppAsset::addJs($this, 'mForm');


$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
					<div class="form-group" style="text-align: right;">
						<a class="btn btn-primary btn-info" href="javascript:history.go(-1);">返回</a>
					</div>
                    <table class="table table-hover d-border">
                        <tbody class="">
                        <tr>
                            <td width="12%">用户名：</td>
                            <td width="80%"><?=$model['loginname'];?></td>
                            <td width="10%" style="background-color:#ffffff"></td>
                        </tr>
                        <tr>
                            <td>邀请人：</td> <td colspan="2"><?=$model['rid'];?></td>
                        </tr>
                        <tr>
                            <td>安置人：</td><td colspan="2"><?=$model['pid'];?></td>
                        </tr>
                        <tr>
                            <td>手  机：</td><td colspan="2"><?=$model['tel'];?></td>
                        </tr>
                        <tr>
                            <td>邮政编码：</td><td colspan="2"><?=$model['pic'];?></td>
                        </tr>
                        <tr>
                            <td>身份证号：</td><td colspan="2"><?=$model['identityid']?></td>
                        </tr>
                        <tr>
                            <td>真实姓名：</td><td colspan="2"><?=$model['bankname']?></td>
                        </tr>
                        <tr>
                            <td>开户行：</td><td colspan="2"><?=$model['bank']?></td>
                        </tr>
                        <tr>
                            <td>银行卡号：</td><td colspan="2"><?=$model['bankno']?></td>
                        </tr>
                        <tr>
                            <td>开户地址：</td><td colspan="2"><?=$model['bankaddress']?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>