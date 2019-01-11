<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
//pr($model);
?>

<div class="cents">
<!--<form class="layui-form layui-form-pane" action="/user/checkreg" onsubmit="return false;">-->
    <?php $form = ActiveForm::begin(['id' => 'reg-form','action' => '/user/checkreg']); ?>
    <div class="layui-form layui-form-pane">
    <div class="layui-form-item">
        <label class="layui-form-label">新会员编号：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_loginname" id="txt_loginname" lay-verify="required" placeholder="请输入" onkeyup="value=value.replace(/[^a-zA-Z0-9]/g,'')" onchange="checkUser(this)" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_loginname"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">邀请人代码：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_rid" id="txt_rid" lay-verify="required" placeholder="请输入" onchange="checkRid(this)" autocomplete="off" class="layui-input">
            <input type="hidden" id="thisname" value="<?=$model['loginname']?>">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_rid"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">安置人代码：</label>
        <div class="layui-input-inline">
            <input type="text"   lay-verify="required" placeholder="请输入" value="<?=$model['pid']?>" disabled="" autocomplete="off" class="layui-input">
            <input type="hidden"  name="txt_pid" id="txt_pid" lay-verify="required" placeholder="请输入" value="<?=$model['pid']?>"  autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_pid"></div>
    </div>
    <div class="layui-form-item" ><!-- pane="" -->
        <label class="layui-form-label">位置：</label>
        <div class="layui-input-inline">
            <input type="radio" id="txt_area1" name="txt_area" value="1" title="左" <?php if($model['area']==1):?> checked <?php endif;?> >
            <input type="radio" id="txt_area2" name="txt_area" value="2" title="右" <?php if($model['area']==2):?> checked <?php endif;?> >
<!--            <input type="radio" name="sex" value="禁" title="禁用" disabled="">-->
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_area"></div>
    </div>
    <div class="layui-form-item" >
        <label class="layui-form-label">代理选择：</label>
        <div class="layui-input-inline">
            <input type="checkbox" checked="" name="open" lay-skin="switch" lay-filter="switchTest" title="开关">
        </div>
    </div>

    <div class="layui-form-item" id="baodan">
        <label class="layui-form-label">代理商：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_baodan" id="txt_baodan" lay-verify="required" placeholder="请输入" onchange="checkBaodan(this)" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_baodan"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">登陆密码：</label>
        <div class="layui-input-inline">
            <input type="password" name="txt_pwd" id="txt_pwd" placeholder="请输入密码" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_pwd"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">重复登录密码：</label>
        <div class="layui-input-inline">
            <input type="password" name="txt_pwd_check" id="txt_pwd_check" placeholder="请确认密码" onchange="checkPwd(this.value,2)" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_pwd1"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">二级密码：</label>
        <div class="layui-input-inline">
            <input type="password" name="txt_pwd2" id="txt_pwd2" placeholder="请输入二级密码" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_pwd2"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">重复二级密码：</label>
        <div class="layui-input-inline">
            <input type="password" name="txt_pwd2_check" id="txt_pwd2_check" placeholder="请确认二级密码" onchange="checkPwd(this.value,4)" lay-verify="required" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_pwd3"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">昵称：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_truename" id="txt_truename" placeholder="请输入" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_truename"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">详细地址：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_address"  id="txt_address" placeholder="请输入" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_address"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">邮政编码：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_pic" id="txt_pic"  placeholder="请输入" onkeyup="value=value.replace(/[^0-9]/g,'')"  autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_pic"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">手机：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_tel" id="txt_tel" lay-verify="required" placeholder="请输入" onkeyup="value=value.replace(/[^0-9-]/g,'')" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_tel"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">email：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_qq" id="txt_qq" placeholder="请输入" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_email"></div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">身份证号：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_identityid" id="txt_identityid" lay-verify="required" placeholder="请输入" onkeyup="value=value.replace(/[^0-9Xx]/g,'')" onchange="checkIdentityid(this)" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_identityid"></div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">真实姓名：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_bankname" id="txt_bankname" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_bankname"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开户行：</label>
        <div class="layui-input-inline"><!-- block 长     inline 短-->
            <select name="txt_bank" id="txt_bank" lay-filter="aihao">
                <option value="农业银行">农业银行</option>
                <option value="工商银行">工商银行</option>
                <option value="建设银行">建设银行</option>
                <option value="农商银行">农商银行</option>
                <option value="支付宝">支付宝</option>
                <option value="财付通">财付通</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">银行卡号：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_bankno" id="txt_bankno" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_bankno"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">开户地址：</label>
        <div class="layui-input-inline">
            <input type="text" name="txt_bankaddress" id="txt_bankaddress" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux" id="msg_bankaddress"></div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1" id="but1">立即注册</button>

        </div>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

    <!--</form>-->



    <script language="JavaScript" src="/pc/js/base.js"></script>
</div>


<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    function checkUser(obj) {
        if(obj.value.length<4||obj.value.length>12){
            $("#txt_loginname").focus();
            $("#msg_loginname").html("<span class='red'>会员编号为4-12位</span>");
        }else{
            $.ajax({
                type: 'get',
                url: 'checkuser',
                dataType: "json",
                data: {'txt_loginname':obj.value},
                success: function (da) {
                    if(da.cod!=0){
                        $("#txt_loginname").focus();
                        $("#msg_loginname").html("<span class='red'>"+da.msg+"</span>");
                        return false;
                    }else{
                        $("#msg_loginname").html("");
                        return true;
                    }


                }
            });
        }

    }
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

    function checkRid(obj) {
        var area = $('input:radio[name="txt_area"]:checked').val();
        if(area==2){
            var thisName = $("#thisname").val();
            if(obj.value!=thisName){
                $("#txt_rid").focus();
                $("#msg_rid").html("<span class='red'>注册右区推荐人必须是自己</span>");
            }else{
                $("#msg_rid").html("");
            }
        }else{
            $.ajax({
                type: 'get',
                url: 'checkrid',
                dataType: "json",
                data: {'txt_rid':obj.value},
                success: function (da) {
                    if(da.cod!=0){
                        $("#txt_rid").focus();
                        $("#msg_rid").html("<span class='red'>"+da.msg+"</span>");
                        return false;
                    }else{
                        $("#msg_rid").html("");
                        return true;
                    }


                }
            });
        }

    }
    function checkBaodan(obj) {
        $.ajax({
            type: 'get',
            url: 'checkbaodan',
            dataType: "json",
            data: {'txt_baodan':obj.value},
            success: function (da) {
                if(da.cod!=0){
                    $("#txt_baodan").focus();
                    $("#msg_baodan").html("<span class='red'>"+da.msg+"</span>");
                    return false;

                }else{
                    $("#msg_baodan").html("");
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
        /*var form = layui.form()
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate;

        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');

        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 5){
                    return '标题至少得5个字符啊';
                }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,content: function(value){
                layedit.sync(editIndex);
            }
        });*/

        //监听指定开关
        form.on('switch(switchTest)', function(data){
            /*layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
                offset: '6px'
            });
            layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)*/
            if(this.checked==true){
                $("#txt_baodan").val("");

                $("#baodan").show();
            }else{
                $("#txt_baodan").val('ds003');
                $("#baodan").hide();

            }
        });

        //监听提交
        $('#reg-form').bind('submit', function(){

            /*var loginname= $('#txt_loginname').val(),
            var pwd = $('#txt_pwd').val();
            var pwd_check = $('#txt_pwd_check').val();
            var pwd2 = $('#txt_pwd2').val();
            var pwd2_check = $('#txt_pwd2_check').val();
            var pwd = $('#txt_pwd').val();
            var pwd = $('#txt_pwd').val();*/

            /*if(loginname.length<=4&&loginname.length>=12){
                layer.msg('用户名格式不正确！', {icon: 2});
            }else if(pwd == '') {

            }else{*/
                $(this).ajaxSubmit({
                    type: 'post',
                    url: $(this).attr('action'),
                    dataType: "json",
                    data: {},
                    success: function (da) {
                        //var msg = eval(da);
                        if(da.ok.cod==1){
                            $("#but1").addClass("layui-btn-disabled");
                            layer.msg('注册成功');
                            setTimeout("location.href='"+da.ok.url+"';",1000);
                        }else{
                            if(da.loginname.cod!=0){
                                $("#txt_loginname").focus();
                                $("#msg_loginname").html("<span class='red'>"+da.loginname.msg+"</span>");
                            }else{
                                $("#msg_loginname").html("");
                            }
                            if(da.rid.cod!=0){
                                $("#txt_rid").focus();
                                $("#msg_rid").html("<span class='red'>"+da.rid.msg+"</span>");
                            }else{
                                $("#msg_rid").html("");
                            }
                            if(da.area.cod!=0){
                                $("#txt_area").focus();
                                $("#msg_area").html("<span class='red'>"+da.area.msg+"</span>");
                            }else{
                                $("#msg_area").html("");
                            }
                            if(da.baodan.cod!=0){
                                $("#txt_baodan").focus();
                                $("#msg_baodan").html("<span class='red'>"+da.baodan.msg+"</span>");
                            }else{
                                $("#msg_baodan").html("");
                            }
                            if(da.pwd1.cod!=0){
                                $("#txt_pwd_check").focus();
                                $("#msg_pwd1").html("<span class='red'>"+da.pwd1.msg+"</span>");
                            }else{
                                $("#msg_pwd1").html("");
                            }
                            if(da.pwd2.cod!=0){
                                $("#txt_pwd2_check").focus();
                                $("#msg_pwd3").html("<span class='red'>"+da.pwd2.msg+"</span>");
                            }else{
                                $("#msg_pwd3").html("");
                            }
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
