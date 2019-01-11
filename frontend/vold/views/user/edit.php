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
    <?php $form = ActiveForm::begin(['id' => 'update-form','action' => '/user/upinfo']); ?>
    <div class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label class="layui-form-label">新会员编号：</label>
            <div class="layui-input-inline">
                <input type="text" value="<?=$model['loginname']?>" disabled autocomplete="off" class="layui-input">
                <input type="hidden" name="txt_loginname" id="txt_loginname" value="<?=$model['loginname']?>" placeholder="请输入"  autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_loginname"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邀请人代码：</label>
            <div class="layui-input-inline">
                <input type="text" value="<?=$model['rid']?>" disabled autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_rid"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">安置人代码：</label>
            <div class="layui-input-inline">
                <input type="text"  value="<?=$model['pid']?>" disabled="" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_pid"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">登陆密码：</label>
            <div class="layui-input-inline">
                <input type="password" name="txt_pwd" id="txt_pwd" placeholder="不修改请保持为空" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_pwd"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">重复登录密码：</label>
            <div class="layui-input-inline">
                <input type="password" name="txt_pwd_check" id="txt_pwd_check" placeholder="不修改请保持为空" onchange="checkPwd(this.value,2)" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_pwd1"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">二级密码：</label>
            <div class="layui-input-inline">
                <input type="password" name="txt_pwd2" id="txt_pwd2" placeholder="不修改请保持为空" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_pwd2"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">重复二级密码：</label>
            <div class="layui-input-inline">
                <input type="password" name="txt_pwd2_check" id="txt_pwd2_check" placeholder="不修改请保持为空" onchange="checkPwd(this.value,4)" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_pwd3"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">昵称：</label>
            <div class="layui-input-inline">
                <input type="text" name="txt_truename" id="txt_truename" value="<?=$model['truename']?>" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_truename"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">详细地址：</label>
            <div class="layui-input-inline">
                <input type="text" name="txt_address"  id="txt_address" value="<?=$model['address']?>" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_address"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮政编码：</label>
            <div class="layui-input-inline">
                <input type="text" name="txt_pic" id="txt_pic"  value="<?=$model['pic']?>" onkeyup="value=value.replace(/[^0-9]/g,'')"  autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_pic"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机：</label>
            <div class="layui-input-inline">
                <input type="text" name="txt_tel" id="txt_tel" value="<?=$model['tel']?>" onkeyup="value=value.replace(/[^0-9-]/g,'')" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_tel"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">email：</label>
            <div class="layui-input-inline">
                <input type="text" name="txt_qq" id="txt_qq" value="<?=$model['qq']?>" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_email"></div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">身份证号：</label>
            <div class="layui-input-inline">
                <input type="text" name="txt_identityid" id="txt_identityid" value="<?=$model['identityid']?>"  onkeyup="value=value.replace(/[^0-9Xx]/g,'')" onchange="checkIdentityid(this)" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_identityid"></div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名：</label>
            <div class="layui-input-inline">
                <input type="text" name="txt_bankname" id="txt_bankname" value="<?=$model['bankname']?>" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_bankname"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开户行：</label>
            <div class="layui-input-inline"><!-- block 长     inline 短-->
                <select name="txt_bank" id="txt_bank" lay-filter="aihao">
                    <option value="农业银行" <?php if($model['bank']=='农业银行') :?> selected <?php endif;?> >农业银行</option>
                    <option value="工商银行" <?php if($model['bank']=='工商银行') :?> selected <?php endif;?> >工商银行</option>
                    <option value="建设银行" <?php if($model['bank']=='建设银行') :?> selected <?php endif;?> >建设银行</option>
                    <option value="农商银行" <?php if($model['bank']=='农商银行') :?> selected <?php endif;?> >农商银行</option>
                    <option value="支付宝" <?php if($model['bank']=='支付宝') :?> selected <?php endif;?> >支付宝</option>
                    <option value="财付通" <?php if($model['bank']=='财付通') :?> selected <?php endif;?> >财付通</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">银行卡号：</label>
            <div class="layui-input-inline">
                <input type="text" name="txt_bankno" id="txt_bankno" lay-verify="required" value="<?=$model['bankno']?>" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_bankno"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开户地址：</label>
            <div class="layui-input-inline">
                <input type="text" name="txt_bankaddress" id="txt_bankaddress" lay-verify="required"  value="<?=$model['bankaddress']?>" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux" id="msg_bankaddress"></div>
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

    function checkIdentityid(obj) {
        $.ajax({
            type: 'get',
            url: 'checkidentityid',
            dataType: "json",
            data: {'txt_identityid':obj.value},
            success: function (da) {
                if(da.cod!=0){
                    $("#txt_identityid").focus();
                    $("#msg_identityid").html("<span class='red'>"+da.msg+"</span>");

                    return false;
                }else{
                    $("#msg_identityid").html("");
                    return true;
                }


            }
        });
    }


    function checkPwd(obj,str) {

        if(str==2){
            var pwd = $("#txt_pwd").val();
            if(pwd!=obj){
                $("#txt_pwd_check").focus();
                $("#msg_pwd1").html("<span class='red'>两次密码输入不一致</span>");
                return false;
            }else{
                $("#msg_pwd1").html("");

            }
        }


        if(str==4){
            var pwd = $("#txt_pwd2").val();
            if(pwd!=obj){
                $("#txt_pwd2_check").focus();
                $("#msg_pwd3").html("<span class='red'>二级密码两次输入不一致</span>");
                return false;
            }else{
                $("#msg_pwd3").html("");

            }
        }
        return true;
    }
    layui.use(['form', 'layedit', 'laydate'], function(){


        //监听提交
        $('#update-form').bind('submit', function(){

            $(this).ajaxSubmit({
                type: 'post',
                url: $(this).attr('action'),
                dataType: "json",
                data: {},
                success: function (da) {
                    //var msg = eval(da);
                    if(da.ok.cod==1){
                        $("#but1").addClass("layui-btn-disabled");
                        layer.msg('修改成功');
                        setTimeout("location.href='"+da.ok.url+"';",1000);
                    }else{
                        if(da.identityid.cod!=0){
                            $("#txt_identityid").focus();
                            $("#msg_identityid").html("<span class='red'>"+da.identityid.msg+"</span>");
                        }else{
                            $("#msg_identityid").html("");
                        }
                    }


                }
            });

            return false;
        });




    });
</script>
