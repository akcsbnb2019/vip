$(function(){
	/* 验证用户是否存在*/
	var touid = '';
	$('#changemoney-to_userid').blur('on',function(){
		if(touid != $(this).val()){
			$.post('/funds/checkuserid', {'uname':$(this).val()}, function(r){
				if(r.status == 1){
					if(r.msg == null){
						/* layer.msg('用户没有输入真实姓名！',{icon: r.status}); */
						layer.open({
						  style: 'border:none; background-color:#fff; color:#40AFFE;',
						  content:'用户没有输入真实姓名！'
						})
					}else{
						$('.field-changemoney-to_userid #errer').html('<p class="help-block">'+r.msg+'</p>');
					}
				}else{
					/* layer.msg(r.msg, {icon: r.status}); */
					layer.open({
						  style: 'border:none; background-color:#fff; color:#40AFFE;',
						  content:r.msg
						})
				}
            });
			touid = $(this).val();
		}
	});
	$('#changemoney-money,#getamount-amount').blur('on',function(){
		if($(this).val()%50 > 0){
			/* layer.msg('输入的积分需为50的倍数！',{icon: 2}); */
			layer.open({
			  style: 'border:none; background-color:#fff; color:#40AFFE;',
			  content:'输入的积分需为50的倍数！'
			})
		}
		if($('#amountss').val()*1 < $(this).val()*1){
			/* layer.msg('输入的积分不能大于当前余额！',{icon: 2}); */
			layer.open({
			  style: 'border:none; background-color:#fff; color:#40AFFE;',
			  content:'输入的积分不能大于当前余额！'
			})
			$(this).val($('#amountss').val()-$('#amountss').val()%50);
		}
	});
	
	$(".checs").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",});
	
	/* 注册验证*/
	var regs  = new Array();
	var regid = new Array();
	regs[1] = regs[2] = regs[3] = regs[5] = regs[6] = null;
	regid['uso-rid'] = 1,regid['uso-baodan'] = 2,regid['uso-loginname'] = 3,regid['uso-pwd1'] = 5,regid['uso-tel'] = 6;
	$('#uso-baodan,#uso-rid,#uso-loginname,#uso-tel,#uso-pwd1').blur('on',function(){
		var _t  = $(this);
		var ido = _t.attr('id');
		if(regs[regid[ido]] != _t.val() && _t.val() != ''){
			$.post('/user/checkuserid', {'uname':_t.val(),'type':regid[ido]}, function(r){
				if(r.status == 1){
					if(r.msg == null || r.msg == ''){
						if(regid[ido] == 1){
							/* layer.msg('用户没有输入真实姓名！',{icon: r.status}); */
							layer.open({
							  style: 'border:none; background-color:#fff; color:#40AFFE;',
							  content:'用户没有输入真实姓名！'
							})
						}
					}else{
						$('.field-'+ido+' #errer').html('<p class="help-block">'+r.msg+'</p>');
					}
				}else{
					if(regid[ido] == 1){
						$('.field-'+ido+' #errer').html('');
					}
					/* layer.msg(r.msg, {icon: 0}); */
					layer.open({
					  style: 'border:none; background-color:#fff; color:#40AFFE;',
					  content:r.msg
					})
				}
            });
			regs[regid[ido]] = _t.val();
		}
	});
	var bdin = '';
	$('#bds').next('ins').click('on',function(){
		bdin = bdin == '' ? 'hiddens' : '';
		if(bdin == ''){
			$('.field-uso-fuwuuser,#bdi').removeClass('hiddens');
		}else{
			$('.field-uso-fuwuuser,#bdi').addClass('hiddens');
		}
	});
	if(Zi.isNull($('#isarea').val()) && $('#isarea').val() == '2'){
		$.post('/user/isright', {}, function(r){
			if(r.status != 1){
				/* layer.msg(r.msg,{icon: 2, time:3000}); */
				layer.open({
				  style: 'border:none; background-color:#fff; color:#40AFFE;',
				  content:r.msg
				})
       			setTimeout("window.history.go(-1);",3000);
			}
        });
	}
});