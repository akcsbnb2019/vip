lastScrollY=0;
function closeqq(){
var el = document.getElementById("LeftAd");
el.style.display = "none";
}
function heartBeat(){
var diffY;
if (document.documentElement && document.documentElement.scrollTop)
diffY = document.documentElement.scrollTop;
else if (document.body)
diffY = document.body.scrollTop
else
{/*Netscape stuff*/}
//alert(diffY);
percent=.1*(diffY-lastScrollY);
if(percent>0)percent=Math.ceil(percent);
else percent=Math.floor(percent);
document.getElementById("LeftAd").style.top=parseInt(document.getElementById("LeftAd").style.top)+percent+"px";

lastScrollY=lastScrollY+percent;
//alert(lastScrollY);
}
suspendcode12="<DIV id=LeftAd style='right:5px;POSITION:absolute;TOP:180px;'><table width=110  border=0 cellpadding=0 cellspacing=0><tr><td width=110 ><img src=images/qq1.gif width=110 ></td></tr><tr><td  align=center background=images/qq2.gif><iframe src='qq.php' width=90  frameborder=0 marginheight=0 marginwidth=0 scrolling=no></iframe></td></tr><tr><td height=19><SPAN id=close01 onmousedown=closeqq() style=CURSOR: hand ><img src=images/qq3.gif alt=µã»÷¹Ø±Õ width=110 height=31></span></td></tr></table></div>"
document.write(suspendcode12);

window.setInterval("heartBeat()",1);
function ClosedivLeft()
{
LeftAd.style.visibility="hidden";
}
