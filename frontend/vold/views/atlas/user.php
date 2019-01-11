<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>jOrgChart - A jQuery OrgChart Plugin</title>
    <link rel="stylesheet" href="/pc/tree/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/pc/tree/css/jquery.jOrgChart.css"/>
    <link rel="stylesheet" href="/pc/tree/css/custom.css"/>
    <link href="/pc/tree/css/prettify.css" type="text/css" rel="stylesheet" />

    <script type="text/javascript" src="/pc/tree/prettify.js"></script>

    <!-- jQuery includes -->
    <script type="text/javascript" src="/pc/js/jquery.min.js"></script>
    <script type="text/javascript" src="/pc/js/jquery.ui.min.js"></script>

    <script src="/pc/tree/jquery.jOrgChart.js"></script>
    <script src="/pc/js/base.js"></script>



</head>
<!--<div class="cents">-->
<body onload="prettyPrint();">
<script>
    jQuery(document).ready(function() {
        var error = "<?=$model['error'];?>";
        var error_url = "<?=$model['err_url'];?>";
        if(error.length>0){
            layer.msg("<span style='color:red'>"+error+"</span>", {icon: 2} );
            setTimeout("location.href='"+error_url+"';",1000);

        }
        $("#org").jOrgChart({
            chartElement : '#chart',
            dragAndDrop  : true
        });
    });
</script>
<div>

    <?php $form = ActiveForm::begin(['id' => 'select-form','method'=>'post']); ?>
    <div style="float: right"><div style="float: left"><?= $form->field($user, 'loginname')->textInput(['autofocus' => true]) ?></div>
    <div style="float: left"><?= Html::submitButton('搜索', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?></div></div>
    <?php ActiveForm::end(); ?>

</div>
<div align="center" style="margin-left: 80px;margin-top: 40px;">
    <ul id="org" style="display:none">
        <li>

            <table align="center" style="margin-left: 10px; margin-top:15px;">
                <tr >
                    <td colspan="5"><a href="/atlas/user?loginname=<?=$model['user']['loginname']?>"><?=$model['user']['loginname']?> <?=$model['user']['standardlevel']?></a><br><br></td>
                </tr>
                <tr>
                    <td>会员数量：</td>
                    <td>左：</td>
                    <td><?=$model['user']['num1']?></td>
                    <td>右：</td>
                    <td><?=$model['user']['num2']?><br></td>
                </tr>
                <tr>
                    <td>消费业绩：</td>
                    <td>左：</td>
                    <td><?=$model['user']['allyeji1']?></td>
                    <td>右：</td>
                    <td><?=$model['user']['allyeji2']?><br></td>
                </tr>
                <tr >
                    <td colspan="3">总消费：</td>
                    <td colspan="3"><?=$model['user']['pay_points_all']?></td>
                </tr>
            </table>

            <ul>

                <?php if(empty($model['left']['loginname'])) : ?>
                    <li>
                        <br><br><br><p><a href="/user/reg?pid=<?=$model['user']['loginname']?>&area=1">注册</a></p>
                    </li>
                <?php else:?>

                    <li>
                        <table align="center" style="margin-left:38px; margin-top:15px;">
                            <tr >
                                <td colspan="5"><a href="/atlas/user?loginname=<?=$model['left']['loginname']?>"><?=$model['left']['loginname']?> <?=$model['left']['standardlevel']?></a><br><br></td>
                            </tr>
                            <tr>
                                <td>会员数量：</td>
                                <td>左：</td>
                                <td><?=$model['left']['num1']?></td>
                                <td>右：</td>
                                <td><?=$model['left']['num2']?></td>
                            </tr>
                            <tr>
                                <td>消费业绩：</td>
                                <td>左：</td>
                                <td><?=$model['left']['allyeji1']?></td>
                                <td>右：</td>
                                <td><?=$model['left']['allyeji2']?></td>
                            </tr>
                            <tr >
                                <td colspan="3">总消费：</td>
                                <td colspan="3"><?=$model['left']['pay_points_all']?></td>
                            </tr>
                        </table>
                    </li>
                <?php endif;?>
                <?php if(empty($model['right']['loginname'])) : ?>
                    <li>
                        <br><br><br><p><a href="/user/reg?pid=<?=$model['user']['loginname']?>&area=2">注册</a></p>
                    </li>
                <?php else:?>

                    <li>
                        <table align="center" style="margin-left:38px; margin-top:15px;">
                            <tr >
                                <td colspan="5"><a href="/atlas/user?loginname=<?=$model['right']['loginname']?>" onclick="checkv()"><?=$model['right']['loginname']?> <?=$model['right']['standardlevel']?></a><br><br></td>
                            </tr>
                            <tr>
                                <td>会员数量：</td>
                                <td>左：</td>
                                <td><?=$model['right']['num1']?></td>
                                <td>右：</td>
                                <td><?=$model['right']['num2']?></td>
                            </tr>
                            <tr>
                                <td>消费业绩：</td>
                                <td>左：</td>
                                <td><?=$model['right']['allyeji1']?></td>
                                <td>右：</td>
                                <td><?=$model['right']['allyeji2']?></td>
                            </tr>
                            <tr >
                                <td colspan="3">总消费：</td>
                                <td colspan="3"><?=$model['right']['pay_points_all']?></td>
                            </tr>
                        </table>
                    </li>
                <?php endif;?>
            </ul>
        </li>
    </ul>

    <div id="chart" class="orgChart1"></div>

</div>
</body>
<!--</div>-->
