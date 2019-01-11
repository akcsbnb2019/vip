<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use backend\assets\BootsAsset;

BootsAsset::bootCss($this, 'animate');
BootsAsset::bootCss($this, 'common');
BootsAsset::bootCss($this, 'sys');
BootsAsset::bootCss($this, 'sysconf');

$this->title = '权限菜单';
?>
<div class="larry-fluid larry-wrapper" id="addo">
    <div class="layui-row lay-col-space20">
    	<div class="layui-cos-xs12 layui-col-sm12 layui-col-md12 layui-col-lg12">
    		<section class="larry-body animated fadeInRightBig">
    			<div class="larry-body-header">
    				<span class="tit">编辑 - <?= Html::encode($this->title) ?></span>
    				<div class="larry-add-edit layui-btn inline-block right-s layui-btn-normal" id="goupt" >
		    	        <i data-icon="larry-xinjian" class="larry-icon larry-fabu1 inline-block"></i>返回
	    	        </div>
    			</div>
    			<div class="larry-body-content clearfix">
                <?php 
                    $form = ActiveForm::begin([
                        'id' => 'eForm',
                        'action' => Url::to('/'.THISID.'/edit?put=1'),
                        'options' => [
                            'class' => 'layui-form layui-col-lg8 layui-col-md12 layui-col-sm12 layui-col-xs12',
                        ],
                        'fieldConfig'=>['template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-3'>{error}</div>"]
                    ]);
                    if(empty($model->name)){
                        $model->type = 1;
                        $model->status = 1;
                        $model->subset = 0;
                        $model->sort = 99;
                    }
                    $model->cat_id = $cat['cname'];
                    ?>
                    <?= $form->field($model, 'name')->textInput() ?>
                    <?= $form->field($model, 'url_key')->textInput() ?>
                    <?= $form->field($model, 'cat_id')->textInput(['disabled' => 'disabled','id' => 'cat_name']) ?>
                    <?= $form->field($model, 'type')->dropDownList($types,['prompt' => '请选择','multiple' => '',]) ?>
                    <?= $form->field($model, 'group_name')->textInput() ?>
                    <?= $form->field($model, 'icon')->textInput() ?>
                    <?= $form->field($model, 'status')->inline()->radioList(['1'=>'启用','0'=>'停用'],[
                        'template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-2'>{error}</div>",
                        'itemOptions' => ['labelOptions' => ['class' => 'radio-inline']]
                    ]) ?>
                    <?= $form->field($model, 'subset')->inline()->radioList(['1'=>'是','0'=>'否'],[
                        'template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-6'>{input}</div>\n<div class='col-sm-2'>{error}</div>",
                        'itemOptions' => ['labelOptions' => ['class' => 'radio-inline']]
                    ]) ?>
                    <?= $form->field($model, 'sort')->textInput() ?>
                    <?= $form->field($model, 'desc',[
                        'template'=> "<div class='col-sm-2 labrs'>{label}</div>\n<div class='col-sm-8'>{input}</div>\n<div class='col-sm-2'>{error}</div>",
                    ])->textarea(['rows' => 5, 'placeholder' => '请输入您需要的内容']) ?>
                    
            		<div class="col-sm-offset-2 butover">
                        <?= $form->field($model, 'id',['template'=>'{input}'])->hiddenInput(['value' => 0]) ?>
                    	<?= $form->field($model, 'cat_id',['template'=>'{input}'])->hiddenInput(['value' => $cat['cid'],'id' => 'cat_id']) ?>
            			<?= Html::submitButton('立即提交', ['class' => 'layui-btn', 'name' => 'login-button']) ?>
            			<?= Html::resetButton('重置', ['class' => 'layui-btn layui-btn-primary', 'name' => 'reset', 'id' => 'reset']) ?>
            		</div>
        			<?php ActiveForm::end(); ?>
    			</div>
    		</section>
    	</div>
    </div>
</div>
<div class="larry-fluid larry-wrapper animated slideInDown" id="listo">
    <div class="layui-row lay-col-space15 ">
    	<div class="layui-cos-xs12 layui-col-sm12 layui-col-md12 layui-col-lg12">
    		<section class="larry-body">
    			<div class="larry-body-header">
    				<span class="tit"><?= Html::encode($this->title) ?></span>
    			</div>
    			<div class="larry-body-content clearfix">
                    <div class="larrycms-btn-box">
		    	        <div class="larry-add-edit layui-btn inline-block right-s layui-btn-normal" id="adds" data-url="<?= Url::to('/'.THISID.'/add?id='.$cat['cid']); ?>">
		    	        <i data-icon="larry-xinjian" class="larry-icon larry-fabu1 inline-block"></i>新增
		    	        </div>
		    	        <?php $form = ActiveForm::begin([
		    	            'id' => 'sForm',
		    	            'action'=>Url::to('/'.THISID.'/index?cid='.$cat['cid']),
		    	            'options' => ['class' => 'layui-form larry-form-tit clearfix inline-block'],
		    	            'fieldConfig'=>['template'=> "<div class='layui-inline'>{input}</div>"]
                          ]);?>
                          <button class="layui-btn goup"  id="goup">返回上一级</button>
		    	        	搜索ID：<?= $form->field($model, 'name')->textInput(['autofocus' => true,'class'=>'layui-input']) ?>
		    		        <button class="layui-btn" data-type="reload">搜索</button>
		    	        <?php ActiveForm::end(); ?>
		            </div>
    		</section>
        </div>
        <div class="layui-cos-xs12 layui-col-sm12 layui-col-md12 layui-col-lg12">
    		<section class="larry-body">

    			<div class="larry-body-content clearfix cont-clear">
                   
		    		<div class="layui-form larry-table-list" id="allls">
		    			<table class="layui-hide" id="test" lay-filter="demo"></table>
<script type="text/html" id="aTpl">
  <a href="javascript:;" lay-event="lname">{{d.name}}</a>
</script>
<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="addv">添加</a>
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
</script>
 
<script type="text/html" id="checkboxTpl">
  <!-- 这里的 checked 的状态只是演示 -->
  <input type="checkbox" name="状态" value="{{d.name}}" title="启用" lay-val="{{d.id}}" lay-filter="lockDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
		            </div>
    			</div>
    		</section>
        </div>
    </div>
</div>
<input type="hidden" value="table1" id="actions">
<script type="text/javascript">
/*编辑特殊回调*/
function gosuss(d){
	goadds({'id':d.cat.cid,'name':d.cat.cname});
	Zi.resuss(d.data);
}
/*编辑时初始化特定参数*/
function goadds(d){
	if(typeof(d.name) == 'undefined'){
		if(d > 0){
			$.ajax({
	            url: dbj.contr + 'edit',
	            type: 'post',
	            data: {'id':d},
	            success: function(d){
	            	$('#cat_name').val(d.data.name);
	            	$('#cat_id').val(d.data.id);
	            }
	        });
		}
	}else{
		$('#cat_name').val(d.name);
		$('#cat_id').val(d.id);
	}
	$('#'+dbj.models+'-id').val(0);
  	return true;
}
/*初始化列表参数设置*/
function ondan(){
	return {
		    elem: '#test'
		    ,url:'<?= Url::to('/'.THISID.'/list?cid='.$cat['pid']); ?>'
		    ,method:'post'
		    ,cellMinWidth: 80
		    ,limits:[10,20,30]
		    ,cols: [[
		      {type: 'checkbox'}
		      ,{field:'id', title:'ID', width:65, unresize: true, sort: true}
		      ,{field:'icon', title: '图标', width:60}
		      ,{field:'name', title:'名称', width:150, toolbar: '#aTpl'}
		      ,{field:'type', title:'类型', width:100}
		      ,{field:'group_name', title:'分组', width:100}
		      ,{field:'add_time', title: '时间', width:180}
		      ,{field:'sort', title:'排序', sort: true, width:70}
		      ,{field:'subset', title:'子集', width:85, templet: function(d){
		    	  return d.subset == 0?'无子集':'有子集';
		      }, unresize: true}
		      ,{field:'status', title:'状态', width:110, templet: '#checkboxTpl', unresize: true}
		      ,{fixed: 'right', width:128, title:'操作', align:'center', toolbar: '#barDemo'}
		    ]]
		    ,id: 'idTest'
		    ,page: true
		    ,where:{}
		    ,models:'vipmenu'
		    ,contr:'<?= '/'.THISID.'/'; ?>'
		  };
}
</script>
</body>
</html>