$(function(){

  $(".menuBox .rclick").bind("click",function(){
	var liIndex=$(this).parent().index();
	switch( Math.floor(liIndex/3) ){
	  case 0:
		$(".menuBox .bBor").eq(3).css({"clear":"both"})
	  break
	  case 1:
		$(".menuBox .bBor").eq(6).css({"clear":"both"})
	  break
	}

	if($(this).parent().attr("class").indexOf("bBor_cut") != -1){
	  $(this).siblings(".bor_list").slideToggle();
	  $(this).parent().removeClass("bBor_cut");
	}else{
	  $(".bBor").removeClass("bBor_cut");
	  $(".bBor .bor_list").removeAttr("style")
	  $(this).parent().addClass("bBor_cut");
	  $(this).siblings(".bor_list").css({marginLeft:-$(this).offset().left})
	  $(this).siblings(".bor_list").slideToggle()
	}
  })
  $(".menuBox .rhref").bind("click",function(){
	  window.location.href = $(this).attr("href");
  })

  $(".revise_container_click").bind("click",function(){
	$(".revise_container").toggle("fast");
  })

})