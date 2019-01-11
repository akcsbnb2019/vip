<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '编辑 - 新闻';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>.layui-btn-disabled{color:#000}.layui-form-radio div {font-size:14px;}</style>
<section class="larry-grid">
	<div class="larry-personal">
		<header class="larry-personal-tit">
			<span><?= Html::encode($this->title) ?></span>
			<a class="layui-btn layui-btn-small larry-log-del" href="/<?= THISID;?>/index" style="margin-top: 6px;"><i class="iconfont icon-huishouzhan1"></i>返回列表</a>
		</header><!-- /header -->
		<div class="larry-personal-body clearfix" id="section">
			<?php $form = ActiveForm::begin(['id' => 'news-form']); ?>
				<input type="hidden" name="Users[id]" value="<?= $model['id'];?>">
				
				<div class="layui-form-item">
                    <label class="layui-form-label">非修改信息</label>
                    <div class="layui-input-inline" style=" margin-left: 40px;">
                      	<input type="text" class="layui-input layui-btn-disabled" value="用户名:<?= $model['loginname'];?>" readonly="readonly" >
                    </div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-input-inline">
                      	<input type="text" class="layui-input layui-btn-disabled" value="安置人:<?= $model['pid'];?>" readonly="readonly" >
                    </div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-input-inline">
                      	<input type="text" class="layui-input layui-btn-disabled" value="代理编号:<?= $model['baodan'];?>" readonly="readonly" >
                    </div>
                </div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">推荐人</label>
					<div class="layui-input-block" style="width: 405px;">
                        <div class="layui-form-mid" style=" margin-left: 40px;"><?= $model['rid'];?></div>
                    </div>
				</div>
                <div class="layui-form-item">
                	<div class="layui-inline">
                		<label class="layui-form-label">账户余额</label>
                        <div class="layui-form-mid" style=" margin-left: 40px;"><?= $model['amount'];?></div>
                    </div>
                </div>
				<div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-inline" style=" margin-left: 40px;">
                      	<input type="password" name="Users[pwd1]" placeholder="一级密码不修改请留空" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-input-inline">
                      	<input type="password" name="Users[pwd2]" placeholder="二级密码不修改请留空" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">请填写6到12位密码</div>
                </div>
				<div class="layui-form-item">
					<label class="layui-form-label">身份证</label>
					<div class="layui-input-block" style="width: 405px;">
						<input type="text" name="Users[identityid]" value="<?= $model['identityid'];?>" autocomplete="off" class="layui-input">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">手机</label>
                    <div class="layui-input-inline" style="margin-left: 40px;width: 260px;">
                      	<input type="text" name="Users[tel]" value="<?= $model['tel'];?>" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">地址</div>
                    <div class="layui-input-inline" style="width: 260px;">
                      	<input type="text" name="Users[address]" value="<?= $model['address'];?>" autocomplete="off" class="layui-input">
                    </div>
				</div>
				
				<div class="layui-form-item">
                    <label class="layui-form-label">一般信息</label>
                    <div class="layui-form-mid" style="margin-left: 40px;">昵称：</div>
                    <div class="layui-input-inline" style="width: 120px;">
                      	<input type="text" name="Users[truename]" value="<?= $model['truename'];?>" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">邮编：</div>
                    <div class="layui-input-inline" style="width: 120px;">
                      	<input type="text" name="Users[pic]" value="<?= $model['pic'];?>" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">QQ/MSN：</div>
                    <div class="layui-input-inline" style="width: 120px;">
                      	<input type="text" name="Users[qq]" value="<?= $model['qq'];?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
				<div class="layui-form-item">
					<label class="layui-form-label">开户行</label>
                    <div class="layui-input-inline" style="margin-left: 40px;width: 260px;">
                      	<input type="text" name="Users[bank]" value="<?= $model['bank'];?>" placeholder="开户行" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">地址</div>
                    <div class="layui-input-inline" style="width: 260px;">
                      	<input type="text" name="Users[bankaddress]" value="<?= $model['bankaddress'];?>" placeholder="开户行地址" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">开户行地址</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">银行账号</label>
                    <div class="layui-input-inline" style="margin-left: 40px;width: 260px;">
                      	<input type="text" name="Users[bankno]" value="<?= $model['bankno'];?>" placeholder="银行账号" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">姓名</div>
                    <div class="layui-input-inline" style="width: 260px;">
                      	<input type="text" name="Users[bankname]" value="<?= $model['bankname'];?>" placeholder="开户人姓名" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">开户人姓名</div>
				</div>
				
				<div class="layui-form-item">
					<label class="layui-form-label">是否地区代理</label>
					<div class="layui-input-block">
						<input type="radio" name="Users[bd]" value="0" title="普通会员" <?php if($model['bd']==0){ ?> checked="" <?php } ?> ><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><span>普通会员</span></div>
						<input type="radio" name="Users[bd]" value="1" title="地区代理" <?php if($model['bd']==1){ ?> checked="" <?php } ?>><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>地区代理</span></div>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">地区代理城市</label>
                    <div class="layui-input-inline" style="margin-left: 40px;width: 115px;">
						<select name="Users[sheng]" lay-filter="usersreg1" id="usersreg1">
							<option value="0">选择省</option>
                            <?php foreach ($region as $val) {?>
                            <option value="<?php echo $val['region_id']; ?>"><?php echo $val['region_name']; ?></option>
                            <?php }?>
						</select>
                    </div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-input-inline" style="width: 120px;">
						<select name="Users[shi]" lay-filter="usersreg2" id="usersreg2">
							<option value="0">选择城市</option>
						</select>
                    </div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-input-inline" style="width: 120px;">
						<select name="Users[xian]" lay-filter="usersreg3" id="usersreg3">
							<option value="0">选择县/区</option>
						</select>
                    </div>
                    <div class="layui-form-mid">目前区域:</div>
                    <div class="layui-form-mid layui-word-aux"><?= $model['city'];?></div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">代理级别</label>
					<div class="layui-input-block" style="width: 405px;">
						<select name="Users[dllevel]" lay-filter="aihao">
                            <option value="0" <?php if($model['dllevel']==0){echo "selected";}?>>无级别</option>
                            <option value="1" <?php if($model['dllevel']==1){echo "selected";}?>>代理商</option>
                            <option value="2" <?php if($model['dllevel']==2){echo "selected";}?>>微超市</option>
<!--                            <option value="3" --><?php //if($model['dllevel']==2){echo "selected";}?><!-->店铺</option>-->
						</select>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">是否冻结</label>
					<div class="layui-input-block">
						<input type="radio" name="Users[lockuser]" value="0" title="正常" <?php if($model['lockuser']==0){ ?> checked="" <?php } ?> ><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><span>正常</span></div>
						<input type="radio" name="Users[lockuser]" value="1" title="冻结" <?php if($model['lockuser']==1){ ?> checked="" <?php } ?> ><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>冻结</span></div> 
					</div>
				</div>
				<div class="layui-form-item">
                    <label class="layui-form-label">店铺位置信息</label>
                    <input id="user_id" type="hidden"  value=""/>
                    <div class="layui-input-inline" style=" margin-left: 40px;">
                      	<input type="text" id="lat" placeholder="纬度" value="" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-input-inline">
                      	<input type="text" id="lng" placeholder="经度" value="" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">查看</div>
                </div>
				<div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-input-inline" style="margin-left: 40px;width: 405px;">
                      	<input type="text" id="address" value="" placeholder="店铺位置" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">直接清空</div>
                </div>
				
				<div class="layui-form-item">
					<div class="layui-input-block">
						<button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
				<br><br><br><br><br><br>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</section>
<script type="text/javascript" src="/js/pc/section2.js"></script>
<script type="text/javascript">
$(function(){
	$('#section > form').removeClass('col-lg-5').addClass('col-lg-12');
});
</script>