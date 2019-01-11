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
    <?php $form = ActiveForm::begin(['id' => 'exchange-form','action' => '/weltare/confexchange']); ?>
    <div class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label class="layui-form-label">商城余额：</label>

            <label class="layui-form-label"><?=$model['user_money']?></label>

            <div class="layui-form-mid layui-word-aux" id="msg_loginname"></div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">可购买股数：</label>
            <label class="layui-form-label"><?=$model['guquan']?></label>

        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">购买股数：</label>
            <div class="layui-input-inline">
                <input type="text" name="amount" id="amount" lay-verify="required" onkeyup="value=value.replace(/[^0-9-]/g,'')" onchange="checkmoney(this,<?=$model['user_money']?>,<?=$model['guquan']?>)" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_amount"></div>
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



    function checkmoney(obj,amount,allgu) {
        //allgu = 0;
        var gu = obj.value;
        if(gu%6!=0){
            $("#amount").focus();
            $("#msg_amount").html("<span class='red'>购买股数为6的倍数,请重新输入</span>");
            return false;
        }else {
            if (gu * 10 > amount) {
                $("#amount").focus();
                $("#msg_amount").html("<span class='red'>商城余额不足,请重新输入</span>");
                return false;
            } else {
                if (gu > allgu) {
                    $("#amount").focus();
                    $("#msg_amount").html("<span class='red'>购买股权股数不能大于当前可购买股数</span>");
                    return false;
                } else {
                    $("#msg_amount").html("");
                }


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
                        layer.msg('购买成功,正在跳转,请稍候!');
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
