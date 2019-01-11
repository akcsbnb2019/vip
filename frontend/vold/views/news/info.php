<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cents">
<table  id="datalist">
  <tr>
    <td id="title" height="45" style="font-size:16px;font-weight:bold;"><?= $model['title'] ?></td>
  </tr>

  <tr >
    <td height="30" style="line-height:30px;padding:0px 30px;text-align:left;"><?= $model['content'] ?></td>
  </tr>
    <tr>
    
    <td height="30" align="center"><input name="btnok" value="返回" type="button" class="buttom" onclick="window.history.go(-1)"/></td>
    
  </tr>
</table>
<script language="JavaScript" src="/pc/js/base.js"></script>
</div>