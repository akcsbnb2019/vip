<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '会员办公系统';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login_box">
<?php $form = ActiveForm::begin(['id' => 'login-form','action' => '/site/login']); ?>
    <table>
        <tr>
            <td class="login_info">账号：</td>
            <td colspan="2"><INPUT id="UserName" maxLength="16" name="LoginForm[username]" type="text" class="width150"></td>
            <td class="login_error_info"><span class="required"></span></td>
        </tr>
        <tr>
            <td class="login_info">密码：</td>
            <td colspan="2"><INPUT  id="PWD" type="password"  name="LoginForm[password]"  class="width150" maxLength=50></td>
            <td><span class="required"></span></td>
        </tr>
                 
        <tr>
            <td></td>
            <td class="login_button" colspan="2">
              <INPUT name="LoginForm[rememberMe]" type="hidden" value="1">
              <INPUT type=submit  id=btnLogin value=" 登 录 ">
              <input type="reset" name="button" id="button" value=" 重 置 "></td>
            </td>    
            <td><span class="required"></span></td>                
        </tr>
    </table>
<?php ActiveForm::end(); ?>
</div>
<script src="/pc/js/init.js"></script>