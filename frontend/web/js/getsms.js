function get_mobile_code(){
    $('#span1').html('<input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
        '                                        <button type="button" class="btn btn-primary" id="zphone">获取短信验证码</button>');
    $('#zphone').addClass("disabled");
    $('#zphone').html("正在提交请求..") ;

    $.post('/index/getsms', {mobile:"<?=$user['tel'];?>"}, function(r) {
        if(r.status==1){
            RemainTime();
        }else{
            $('#span1').html('<input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
                '                                        <button type="button" class="btn btn-primary" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>');

            layer.msg(r.msg, {icon: r.status});
            $('#zphone').removeClass("disabled");
            $('#zphone').html('获取短信验证码');

        }
    });
};
var iTime = 59;
var Account;
function RemainTime(){
    $('#zphone').addClass("disabled");

    var iSecond,sSecond="",sTime="";
    if (iTime >= 0){
        iSecond = parseInt(iTime%60);
        iMinute = parseInt(iTime/60)
        if (iSecond >= 0){
            if(iMinute>0){
                sSecond = iMinute + "分" + iSecond + "秒";
            }else{
                sSecond = iSecond + "秒后,可再次获取..";
            }
        }
        sTime=sSecond;
        if(iTime==0){

            clearTimeout(Account);
            sTime='获取手机验证码';
            iTime = 59;
            $('#zphone').removeClass("disabled");

        }else{

            Account = setTimeout("RemainTime()",1000);
            iTime=iTime-1;
        }
    }else{
        sTime='没有倒计时';
    }
    $('#zphone').html(sTime) ;
    if(sTime=='获取手机验证码'){
        $('#span1').html('<input type="text" class="form-control" name="mobile_code" id="mobile_code" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onafterpaste="this.value=this.value.replace(/\\D/g,\'\')" maxlength="4" id="">\n' +
            '                                        <button type="button" class="btn btn-primary" id="zphone" onclick="get_mobile_code()">获取短信验证码</button>');
    }
}