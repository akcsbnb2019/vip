<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cents">
    <div id="data" style=" padding-top:100px;">
    	<?php $form = ActiveForm::begin(['id' => 'twopass-form']); ?>
        <table  width="453" height="254" align="center"  cellpadding="0" cellspacing="0" style="background:url(/pc/images/two_bg.png) no-repeat center;">
          <tr>
            <td align="center" valign="middle" style="padding-top:80px;">
                <input name="password" type="password" id="pass">&nbsp;&nbsp;&nbsp;&nbsp;
              	<label>
                  	<input type="submit" name="btnok" id="btnok" class="btn_save" value="确 定"><br><br><br/>
                  	<font color='red'></font><br><br>
              	</label>
            </td>
          </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
<script language="JavaScript" src="/pc/js/base.js"></script>
</div>