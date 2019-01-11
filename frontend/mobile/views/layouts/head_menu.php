<?php
use yii\helpers\Url;

use common\models\User;
use frontend\models\ZmPosition;
$users = new User();

$position = new ZmPosition();
$row = $users->findOne(['id'=>UID]);
$position_info = $position->findOne(['users_id'=>UID]);
$p_row = $users->findOne(['pid'=>$row['loginname'],'area'=>1]);
$jihuotime = "2018-08-29 00:00:00";
$where=array(
    'isbd'  =>  0,
    'isup'  =>  0,
    'isup2'  =>  0,
    'isup3'  =>  0,
    'isdw'  =>  0,
    'ispy'  =>  0,
    'isfl'  =>  0,
    'isjb'  =>  0,
    'iswcs'  =>  0,
);
if((empty($row['bdl'])||$row['bdl']==0) && ($row['position']<=11&&$row['position']>0)){
    $where['isbd'] = 1;
}
if($row['standardlevel']==0 && $position_info['pan']==1){
	$where['ispy'] = 1;
}
if($row['position']>0){
    $where['isjb'] = $row['position'];
}
if($row['standardlevel']<3&&$row['standardlevel']>0&&($row['jihuotime']<=date("Y-m-d H:i:s",strtotime("+90 day")) || ($row['jihuotime']<$jihuotime && $jihuotime<=date("Y-m-d H:i:s",strtotime("+90 day"))))){
    $where['isup'] = 1;
    if($row['standardlevel']==2){
	    $where['isup3'] = 1;
    }
    if($row['standardlevel']==1){
	    $where['isup2'] = 1;
	    $where['isup3'] = 1;
    }
}
if($row['yuanshigu']>0){
	$where['isfl'] = 1;
	
}
if((empty($p_row)||$p_row['standardlevel']==0)&&$row['standardlevel']==0){
    $where['isdw'] = 1;
}
if($row['bd']==1&&$row['dllevel']==2){
    $where['iswcs'] = 1;
}
?>
<!-- 菜单 -->
  <div class="revise_container">
	  <div class="menuBox">
		<ul>
			<li class="bBor">
				<a href="<?= Url::to('/funds/transfer'); ?>" class="href_ rBor"><i class="icon1"></i><p>转账</p><i class="after_line"></i></a>
			</li>
			<li class="bBor">
				<a href="<?= Url::to('/integral/exchange'); ?>" class="href_ rBor"><i class="icon2"></i><p>兑换</p><i class="after_line"></i></a>
			</li>
			<li class="bBor">
				<a href="<?= Url::to('/integral/exchange/?type=1'); ?>" class="href_"><i class="icon3"></i><p>提现</p><i class="after_line"></i></a>
			</li>
			<li class="bBor">
				<?php if($where['isdw']==1):?>
	            <a href="<?= Url::to('/user/upreg'); ?>" class="rclick rBor href_"><i class="icon4"></i><p>三点位</p><i class="after_line"></i></a>
	            <?php elseif($where['isup']==1):?>
				<a href="javascript:void(0)" class="rclick rBor"><i class="icon5"></i><p>升级</p><i class="after_line"></i></a>
				<ul class="bor_list">
					<?php if($where['isup2']==1):?>
                    <li><a href="<?= Url::to('/user/upvip?id=2'); ?>" class="href_">升级V2</a></li>
                    <?php endif;?>
                    <?php if($where['isup3']==1):?>
                    <li><a href="<?= Url::to('/user/upvip?id=3'); ?>" class="href_">升级V3</a></li>
                    <?php endif;?>
				</ul>
	            <?php else:?>
				<a href="/index" class="rclick rBor href_"><i class="icon4"></i><p>基本信息</p><i class="after_line"></i></a>
				<?php endif;?>
			</li>
			<li class="bBor">
				<a href="javascript:void(0)" class="rclick rBor"><i class="icon5"></i><p>图谱管理</p><i class="after_line"></i></a>
				<ul class="bor_list">
                    <?php if(($row['position']>0 && $row['position']<13) || $where['iswcs']==1):?>
					<li><a href="<?= Url::to('/atlas/user');?>" class="href_">会员图谱</a></li>
                    <?php endif;?>
					<li><a href="<?= Url::to('/atlas/index');?>" class="href_">邀请图谱</a></li>
				</ul>
			</li>
			<li class="bBor">
				<a href="javascript:void(0)" class="rclick rBor"><i class="icon6"></i><p>记录</p><i class="after_line"></i></a>
				<ul class="bor_list">
					<li><a href="<?= Url::to('/integral/index');?>" class="href_">积分记录</a></li>
					<li><a href="<?= Url::to('/integral/details');?>" class="href_">积分明细</a> </li>
					<!-- <li><a href="<?= Url::to('/funds/lovefund');?>" class="href_">爱心基金</a> </li> -->
					<li><a href="<?= Url::to('/funds/index');?>" class="href_">转账记录</a> </li>
					<li><a href="<?= Url::to('/integral/exlist');?>" class="href_">提现记录</a> </li>
					<li><a href="<?= Url::to('/integral/exlist/?sval=1');?>" class="href_">兑换记录</a> </li>
					<li><a href="<?= Url::to('/weltare/stockslog');?>" class="href_">分红记录</a> </li>
					<?php if($where['isfl']==1):?>
                    <li><a href="<?= Url::to('/weltare/index');?>" class="href_">福利兑换记录</a> </li>
                    <?php endif;?>
                </ul>
			</li>
			<li class="bBor">
				<a href="javascript:void(0)" class="rclick rBor"><i class="icon7"></i><p>留言管理</p><i class="after_line"></i></a>
				<ul class="bor_list">
					<li><a href="/message/list" class="href_">收到留言</a></li>
					<li><a href="/message/send" class="href_">发送留言</a></li>
				</ul>
			</li>
			<li class="bBor">
				<?php if($where['isbd']==1):?>
				<a href="<?= Url::to('/user/addreport'); ?>" class="href_ rBor"><i class="icon8"></i><p>申请报单中心</p><i class="after_line"></i></a>
				<?php else:?>
				<a href="<?= Url::to('/news/index'); ?>" class="href_ rBor"><i class="icon8"></i><p>系统公告</p><i class="after_line"></i></a>
				<?php endif;?>
			</li>
			<?php if($where['ispy']==1):?>
			<li class="bBor">
				<a href="<?= Url::to('/user/pupvip?id=3');?>" class="rclick rBor href_"><i class="icon9"></i><p>平移升级</p><i class="after_line"></i></a>
			</li>
			<?php else:?>
			<li class="bBor">
				<a href="javascript:void(0)" class="rclick rBor logout"><i class="icon9"></i><p>退出系统</p><i class="after_line"></i></a>
			</li>
			<?php endif;?>
			<div class="clr"></div>
		</ul>
	  </div>
  </div>
</div>
  <!-- 菜单 -->