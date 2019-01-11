var _n = _p = _l = 0,_w = '';
var forms = {};
var nulls = true;
$(function(){
	$('#sForm input').focus('on',function(){
		var _t = $(this);
		if(_t.attr('aria-required')&&_t.val()=='.'){
			_t.val('');
		}
	});
	$('#sForm input').blur('on',function(){
		var _t = $(this);
		if(_t.attr('aria-required')&&!$.fn.isNull(_t.val())){
			_t.val('.');
		}
	});
	
	$.each($('#sForm').serializeArray(),function(a,b){
		forms[this.name] = this.value;
	});
	/* 分页 */
	_n = $('#nums');
	_p = $('#page');
	if(Zi.isNull(_n.val()) && Zi.isNull(_p.val())){
		
		$.post($('#sForm').attr('action'), {'count':1}, function(r){
			if(r.count > 0){
				_n.val(r.count);
				_l = 15;
				if(Zi.isNull($('#limit').val())){
					_l = $('#limit').val();
				}
				
				$("#pagination").whjPaging({
			        pageSizeOpt: [
			            {'value': 15, 'text': '15条/页', 'selected': true},
			            {'value': 30, 'text': '30条/页'}
			        ],
			        totalPage: Math.ceil(_n.val()/_l),
			        showPageNum: 5,
			        previousPage: '«',
			        nextPage: '»',
			        callBack: Pagings
			    });
				
				if(_p.val() > 1){
					$("#pagination").whjPaging('setPage', _p.val(), Math.ceil(_n.val()/_l));
				}
				
				$('#sxlis').click('on',function(){
					$('.whj_hover').click();
				});
			}else{
				$('#lists').html('<tr><td colspan="'+$('#tables > thead > tr').children().length+'"><center>没找到数据</center></td></tr>');
			}
        });
		
		
	}
	/* 搜索 */
	$('form#sForm').on('beforeSubmit', function (e) {
		Pagings(1,_l);
        return false;
    }).on('submit', function (e) {
        e.preventDefault();
    });
	
	$('#goform').click('on',function(){
		location.reload();
	});
	$('#funin').click('on',function(){
		window.history.go(-1);
	});
	
	$(".i-checks").iCheck({checkboxClass:"icheckbox_square-green",radioClass:"iradio_square-green",});
});
/**
 * 初始化可更新
 */
function statusOn(){
	
}

function Pagings(currPage, pageSize) {
	_l = pageSize;
	
	var urls = $('#sForm').attr('action');
	urls += (urls.indexOf('?')!=-1?'&':'?')+'limit='+pageSize+'&page=' + currPage +_w;
	var count= _n.val();
	$.each($('#sForm').serializeArray(),function(a,b){
		if(forms[this.name] != this.value){
			count = 0;
			forms[this.name] = this.value;
		}
	});
	
	if(nulls && Zi.isOk() === true){
		return false;
	}
	
	if(Zi.sub === true){
		return false;
	}
	
	$.ajax({
		type: 'post',
		url: urls+'&count='+count,
		dataType : "json",
		data: $('#sForm').serialize(),
		success: function(d) {
			if(d.html){
				$('#lists').html(d.html.replace("\\",""));
				/* 指定更新 */
				statusOn();
			}

			/*if(d.page.totalCount != _n.val()){
				nulls = false;
				_n.val(d.page.totalCount);
				$("#pagination").whjPaging('setPage', 1, Math.ceil(_n.val()/_l));
			}*/
			Zi.sub = false;
        },
        beforeSend:function(d){
        	Zi.sub = nulls = true;
        }
	});
	
    console.log('currPage:' + currPage + ' pageSize:' + pageSize);
}
