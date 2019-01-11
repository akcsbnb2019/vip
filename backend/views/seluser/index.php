<?php
	
	/* @var $this yii\web\View */
	/* @var $form yii\bootstrap\ActiveForm */
	/* @var $model \common\models\LoginForm */
	
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Url;
	
	$this->title = '会员办公系统';
	$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    /*
atlas/user
*/
    .a-u-d{
        width: 378px;
        height: 295px;
        background: #ffffff;
        padding: 68px 10px 20px;
        /*-webkit-box-shadow: inset hoff voff blur #ccc;*/
        /*-moz-box-shadow: inset hoff voff blur color;*/
        border-radius: 15px;
        box-shadow: 1px 1px 10px #888888;
    }
    .a-u-d1{
        width: 50%;
        height: 295px;
        background: #ffffff;
        padding: 68px 10px 20px;
        /*-webkit-box-shadow: inset hoff voff blur #ccc;*/
        /*-moz-box-shadow: inset hoff voff blur color;*/
        border-radius: 15px;
        box-shadow: 1px 1px 10px #888888;
        position: absolute;
        left: 25%;
        top: 45px;
    }

    .a-u-d2{

        float: left;
        position: absolute;
        left: 80px;
        top: 451px;
    }

    .a-u-d3{
        float: left;
        position: absolute;
        top: 451px;
        right: 80px;
    }
    .a-u-d-d1{
        border-radius:60px;
        background: #ffffff;
        border: solid 5px #5690fc;
        width: 120px;
        height: 120px;
        position: absolute;
        left: 130px;
        top: -60px;

    }
    .a-u-d-d11{
        border-radius:60px;
        background: #ffffff;
        border: solid 5px #5690fc;
        width: 120px;
        height: 120px;
        position: absolute;
        left: 50%;
        top: -60px;
        margin-left: -60px;

    }
    .a-u-d-d1 img{
        position:relative;
        left:21px;
        top:19px;
    }
    .a-u-d-d1 div{
        width: 70px;
        height: 70px;
        background: #ffffff;

        line-height: 72px;
        position:relative;
        left:28px;
        top:19px;
    }
    .a-u-d-d1 + div{
        width: 100%;
        height: 100%;
        text-align: center;
    }
    .a-u-d-d1 + div div{
        margin: 0px;
        padding: 0px;
        border-bottom: #e7eaec 1px solid;
        width: 100%;
        height: 25%;
        text-align: center;
    }
    .a-u-d-d1 + div div span{
        line-height: 51px;
    }
    .a-u-d-d1-s1{
        float: left;
        display: block;
        text-align: left;
        width: 33%;
    }
    .a-u-d-d1-s2{
        display: block;
        float: left;
        text-align: center;
        width: 33%;
    }
    .a-u-d-d1-s3{
        float: right;
        display: block;
        text-align: right;
        width: 33%;
    }
    .new-user +div div{
        border: 0px;
    }
    .a-u-d-d1-s4{
        display: block;
        float: left;
        text-align: center;
        width: 100%;
    }
    .a-u-d-xian1{
        position:absolute;
        left:30px;
        top:-81px;
    }
    .a-u-d-xian2{
        position:absolute;
        left:-15px;
        top:-81px;
    }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">

        <div class="col-sm-12">
            <div class="ibox ">
                <div class="ibox-content">
					<?php
						$form = ActiveForm::begin([
							'id' => 'select-form',
							'method'=>'post',
							'options' => [
								'class' => 'form-inline',
							],
							'fieldConfig'=>['template'=> "{input}"]
						]);
					?>
                    <div class="form-group">
                        <label for="exampleInputEmail2" class="sr-only">用户名</label>
						<?= $form->field($user, 'loginname')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>"请输入要查找的用户名"]) ?>
                    </div>
                    <!--                        <button class="btn btn-white" type="submit">登录</button>-->
					<?= Html::submitButton('查询', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
					<?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="a-u-d1">
                <div class="a-u-d-d11 a-u-d-d1"><?php if($model['user']['standardlevel']>0) : ?><img src="/images/vip.png" ><?php else:?><img src="/images/no-vip.png"><?php endif;?></div>
                <div>
                    <div style="border: 0px;">
                        <p><a href="/seluser/index?id=<?=$model['user']['id']?>"><?=$model['user']['loginname']?></a> <?php if($model['user']['standardlevel']>0) : ?><img src="/images/v<?=$model['user']['standardlevel']?>.png" ><?php endif;?></p>
                        <p>总消费 : <?=$model['user']['pay_points_all']?></p>
                    </div>
                    <div>
                        <span class = "a-u-d-d1-s1">左区</span>
                        <span class = "a-u-d-d1-s3">右区</span>
                    </div>
                    <div>
                        <span class = "a-u-d-d1-s1"><?=$model['user']['num1']?></span>
                        <span class = "a-u-d-d1-s2">会员数量</span>
                        <span class = "a-u-d-d1-s3"><?=$model['user']['num2']?></span>
                    </div>
                    <div>
                        <span class = "a-u-d-d1-s1"><?=$model['user']['lallyeji']?></span>
                        <span class = "a-u-d-d1-s2">消费业绩</span>
                        <span class = "a-u-d-d1-s3"><?=$model['user']['rallyeji']?></span>
                    </div>
                </div>
            </div>
			<?php if(empty($model['left']['loginname'])) : ?>
                <div class="a-u-d a-u-d2">
                    <div class="a-u-d-d1 new-user"><div>没有会员</div><span class="a-u-d-xian1"><img src="/images/x1.png"/></span></div>
                    <div>
                        <div></div>
                        <div style="text-align: center">
                            <span class = "a-u-d-d1-s4">尚未有会员信息～</span>
                        </div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
			<?php else:?>
                <div class="a-u-d a-u-d2">
                    <div class="a-u-d-d1"><?php if($model['left']['standardlevel']>0) : ?><img src="/images/vip.png" ><?php else:?><img src="/images/no-vip.png"><?php endif;?><span class="a-u-d-xian1"><img src="/images/x1.png"/></span></div>
                    <div>
                        <div style="border: 0px;">
                            <p><a href="/seluser/index?id=<?=$model['left']['id']?>"><?=$model['left']['loginname']?> <?php if($model['left']['standardlevel']>0) : ?><img src="/images/v<?=$model['left']['standardlevel']?>.png" ><?php endif;?></a></p>
                            <p>总消费 : <?=$model['left']['pay_points_all']?></p>
                        </div>
                        <div>
                            <span class = "a-u-d-d1-s1">左区</span>
                            <span class = "a-u-d-d1-s3">右区</span>
                        </div>
                        <div>
                            <span class = "a-u-d-d1-s1"><?=$model['left']['num1']?></span>
                            <span class = "a-u-d-d1-s2">会员数量</span>
                            <span class = "a-u-d-d1-s3"><?=$model['left']['num2']?></span>
                        </div>
                        <div>
                            <span class = "a-u-d-d1-s1"><?=$model['left']['lallyeji']?></span>
                            <span class = "a-u-d-d1-s2">消费业绩</span>
                            <span class = "a-u-d-d1-s3"><?=$model['left']['rallyeji']?></span>
                        </div>
                    </div>
                </div>
			<?php endif;?>
			
			<?php if(empty($model['right']['loginname'])) : ?>
                <div class="a-u-d a-u-d3">
                    <div class="a-u-d-d1 new-user"><div>没有会员</div><span class="a-u-d-xian2"><img src="/images/x2.png"/></span></div>
                    <div>
                        <div></div>
                        <div style="text-align: center">
                            <span class = "a-u-d-d1-s4">尚未有会员信息～</span>
                        </div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
			<?php else:?>
                <div class="a-u-d a-u-d3">
                    <div class="a-u-d-d1"><?php if($model['right']['standardlevel']>0) : ?><img src="/images/vip.png" ><?php else:?><img src="/images/no-vip.png"><?php endif;?><span class="a-u-d-xian2"><img src="/images/x2.png"/></span></div>
                    <div>
                        <div style="border: 0px;">
                            <p><a href="/seluser/index?id=<?=$model['right']['id']?>"><?=$model['right']['loginname']?> <?php if($model['right']['standardlevel']>0) : ?><img src="/images/v<?=$model['right']['standardlevel']?>.png" ><?php endif;?></a></p>
                            <p>总消费 : <?=$model['right']['pay_points_all']?></p>
                        </div>
                        <div>
                            <span class = "a-u-d-d1-s1">左区</span>
                            <span class = "a-u-d-d1-s3">右区</span>
                        </div>
                        <div>
                            <span class = "a-u-d-d1-s1"><?=$model['right']['num1']?></span>
                            <span class = "a-u-d-d1-s2">会员数量</span>
                            <span class = "a-u-d-d1-s3"><?=$model['right']['num2']?></span>
                        </div>
                        <div>
                            <span class = "a-u-d-d1-s1"><?=$model['right']['lallyeji']?></span>
                            <span class = "a-u-d-d1-s2">消费业绩</span>
                            <span class = "a-u-d-d1-s3"><?=$model['right']['rallyeji']?></span>
                        </div>
                    </div>
                </div>
			<?php endif;?>
        </div>
    </div>
</div>



