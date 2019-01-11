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
    <?php $form = ActiveForm::begin(['id' => 'transfer-form','action' => '/funds/conftransfer']); ?>
    <div class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label class="layui-form-label">积分余额：</label>

                <label class="layui-form-label"><?=$model['amount']?></label>

            <div class="layui-form-mid layui-word-aux" id="msg_loginname"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">接收会员：</label>
            <div class="layui-input-inline">
                <input type="text" name="to_userid" id="to_userid" lay-verify="required" onchange="checkuserid(this)" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_to_userid"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">转账积分：</label>
            <div class="layui-input-inline">
                <input type="text" name="money" id="money" onkeyup="value=value.replace(/[^0-9-]/g,'')" onchange="checkmoney(this,<?=$model['amount']?>)" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_money"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">转账说明：</label>
            <div class="layui-input-inline">
                <input type="text" name="why_change" id="why_change" onkeyup="value=value.replace(/[^0-9-a-zA-z\u4E00-\u9FA5，。()（）,.]/g,'')" placeholder="" autocomplete="off" class="layui-input">
            </div>
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

    function checkuserid(obj) {
        $.ajax({
            type: 'get',
            url: 'checkuserid',
            dataType: "json",
            data: {'to_userid':obj.value},
            success: function (da) {
                if(da.cod!=0){
                    $("#to_userid").focus();
                    $("#msg_to_userid").html("<span class='red'>"+da.msg+"</span>");

                    return false;
                }else{
                    $("#msg_to_userid").html("<span class='red'>"+da.msg+"</span>");
                    return true;
                }


            }
        });
    }


    function checkmoney(obj,amount) {
        var money = obj.value;
        var isMoney=money%50;
        if(isMoney!=0){
            $("#money").focus();
            $("#msg_money").html("<span class='red'>转账金额为50的倍数</span>");
            return false;
        }else{
            if(money>amount){
                $("#money").focus();
                $("#msg_money").html("<span class='red'>转账金额不能大于当前余额</span>");
                return false;
            }else{
                $("#msg_money").html("");
            }


        }

        return true;
    }
    layui.use(['form', 'layedit', 'laydate'], function(){


        //监听提交
        $('#transfer-form').bind('submit', function(){

            $(this).ajaxSubmit({
                type: 'post',
                url: $(this).attr('action'),
                dataType: "json",
                data: {},
                success: function (da) {
                    if(da.ok.cod==1){
                        $("#but1").addClass("layui-btn-disabled");
                        layer.msg('转账成功');
                        setTimeout("location.href='"+da.ok.url+"';",1000);
                    }else{
                        if(da.to_userid.cod!=0){
                            $("#to_userid").focus();
                            $("#msg_to_userid").html("<span class='red'>"+da.to_userid.msg+"</span>");
                        }else{
                            $("#msg_to_userid").html("<span class='red'>"+da.to_userid.msg+"</span>");
                        }
                        if(da.money.cod!=0){
                            $("#money").focus();
                            $("#msg_money").html("<span class='red'>"+da.money.msg+"</span>");
                        }else{
                            $("#msg_money").html("");
                        }
                    }
                }
            });

            return false;
        });




    });
</script>
