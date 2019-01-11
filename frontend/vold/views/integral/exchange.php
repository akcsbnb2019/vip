<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="cents">
    <!--<form class="layui-form layui-form-pane" action="/user/checkreg" onsubmit="return false;">-->
    <?php $form = ActiveForm::begin(['id' => 'exchange-form','action' => '/integral/confexchange']); ?>
    <div class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label class="layui-form-label">积分余额：</label>

            <label class="layui-form-label"><?=$model['amount']?></label>

            <div class="layui-form-mid layui-word-aux" id="msg_loginname"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">兑换积分：</label>
            <div class="layui-input-inline">
                <input type="text" name="amount" id="amount" lay-verify="required" onkeyup="value=value.replace(/[^0-9-]/g,'')" onchange="checkmoney(this,<?=$model['amount']?>)" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_amount"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">备注说明：</label>
            <div class="layui-input-inline">
                <input type="text" name="memo" id="memo" onkeyup="value=value.replace(/[^0-9-a-zA-z\u4E00-\u9FA5，。()（）,.]/g,'')" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_memo"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">汇款银行：</label>
            <label class="layui-form-label"><?=$model['bank']?></label>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">银行帐号：</label>
            <label class="layui-form-label"><?=$model['bankno']?></label>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开户姓名：</label>
            <label class="layui-form-label"><?=$model['bankname']?></label>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">申请日期：</label>
            <label class="layui-form-label"><?=date("Y-m-d",time())?></label>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">兑换类型：</label>
            <label class="layui-form-label">兑换到商城</label>

        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1" id="but1">提交</button>

            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <!--</form>-->



    <script language="JavaScript" src="/pc/js/base.js"></script>
</div>


<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>



    function checkmoney(obj,amount) {
        var money = obj.value;
        var isMoney=money%50;
        if(isMoney!=0){
            $("#amount").focus();
            $("#msg_amount").html("<span class='red'>兑换金额为50的倍数</span>");
            return false;
        }else{
            if(money>amount){
                $("#amount").focus();
                $("#msg_amount").html("<span class='red'>兑换金额不能大于当前余额</span>");
                return false;
            }else{
                $("#msg_amount").html("");
            }


        }

        return true;
    }
    layui.use(['form', 'layedit', 'laydate'], function(){


        //监听提交
        $('#exchange-form').bind('submit', function(){

            $(this).ajaxSubmit({
                type: 'post',
                url: $(this).attr('action'),
                dataType: "json",
                data: {},
                success: function (da) {
                    if(da.ok.cod==1){
                        $("#but1").addClass("layui-btn-disabled");
                        layer.msg('兑换成功');
                        setTimeout("location.href='"+da.ok.url+"';",1000);
                    }else{

                        if(da.amount.cod!=0){
                            $("#amount").focus();
                            $("#msg_amount").html("<span class='red'>"+da.amount.msg+"</span>");
                        }else{
                            $("#msg_amount").html("");
                        }
                    }
                }
            });

            return false;
        });




    });
</script>
