<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '权限 - 管理员角色';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.keyleg{
	width: 100px;border:0;
}
.field{
	margin-top: 30px;
}
.layui-form-item{margin:0}
.all-name{
	margin-left: 30px;
}
.groups{background: #F1F2F7; margin: 0 30px 10px;}
.layui-form-item .layui-inline,.groups label{margin-bottom: 0;}
</style>
<section class="larry-grid">
	<div class="larry-personal">
	    <div class="layui-tab">
            <blockquote class="layui-elem-quote mylog-info-tit">
                <ul class="layui-tab-title">
		    	          <li class="layui-btn layui-this"><i class="layui-icon">&#xe60a;</i>权限分配</li>
		    	          <a class="layui-btn layui-btn-small larry-log-del" href="<?= Url::to('/'.THISID); ?>"><i class="iconfont icon-huishouzhan1"></i>返回列表</a>
		            </ul>
            </blockquote>
            <div class="larry-separate"></div>
            <?php $form = ActiveForm::begin(['id' => 'group-form']); ?>
            <input type="hidden" name="id" value="<?= $data['id']?>">
            <?php foreach($tree->i0 as $k2=>$tr2){?>
            <fieldset class="layui-elem-field layui-field-title field">
  				<legend class="keyleg"><?= $tr2->title; ?></legend>
			</fieldset>
			<div class="layui-form">
			<?php 
                      $na = 'i'.$tr2->id;
                      if(isset($tree->$na)){
                      foreach($tree->$na as $k3=>$tr3){?>
              <div class="layui-form-item groups">
                <div class="layui-inline">
                  <label class="layui-form-label"><?= $tr3->title; ?></label>
                </div>
              </div>
              <?php 
                          $na = 'i'.$tr3->id;
                          if(isset($tree->$na) && $tr3->zi == 0){
                          foreach($tree->$na as $k4=>$tr4){?>
              <div class="layui-form-item all-name">
                <label class="layui-form-label"><?= $tr4->title; ?></label>
                <div class="layui-input-block">
              <?php
                              $na = 'i'.$tr4->id;
                              if(isset($tree->$na) && $tr4->zi == 1){
                              $nb = $tr4->href;
                              foreach($tree->$na as $k5=>$tr5){?>
                  <input type="checkbox" name="group[<?= $tr4->href; ?>_<?= $tr4->id; ?>][<?= $tr5->href; ?>_<?= $tr5->id; ?>]" title="<?= $tr5->title; ?>" <?php
                                $nc = $tr5->href;
                                if(isset($group->$nb->$nc) ){
                                    echo 'checked';
                                }
                  ?>>
                  		<?php } } ?>
                </div>
              </div>
              		<?php } }else{?>
              <div class="layui-form-item all-name">
                <label class="layui-form-label">权限</label>
                <div class="layui-input-block">
                          <?php 
                              $nb = $tr3->href;
                              foreach($tree->$na as $k4=>$tr4){?>
                  <input type="checkbox" name="group[<?= $tr3->href; ?>_<?= $tr3->id; ?>][<?= $tr4->href; ?>_<?= $tr4->id; ?>]" title="<?= $tr4->title; ?>" <?php
                                $nc = $tr4->href;
                                if(isset($group->$nb->$nc) ){
                                    echo 'checked';
                                }
                  ?>>
                  		<?php } ?>
                </div>
              </div>
                  		<?php } ?>
            <?php } } ?>
            </div>
            <?php } ?>
            <div class="layui-form-item">
				<div class="layui-input-block">
					<button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
					<button type="reset" class="layui-btn layui-btn-primary">重置</button>
				</div>
			</div>
			<br>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</section>
<input type="hidden" value="group" id="actions">