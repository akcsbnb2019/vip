<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;

?>

                          <?php foreach($model as $key=>$val){?>
                              <tr>
                                <td><input type="checkbox" value="<?= $val['ArticleID']?>" class="id"></td>
                                <td><?= $val['ArticleID']?></td>
                                <td><?= $val['title']?></td>
                                <td><?= $val['UpdateTime']?></td>
                                <td>
                                <?php if($val['status']){?>
                                <button class="layui-btn layui-btn-normal layui-btn-mini" id="up1">启用</button>
                                <?php }else{?>
                                <button class="layui-btn layui-btn-primary layui-btn-mini" id="up2">停用</button>
                                <?php }?>
                                </td>
                                <td>
                                <button class="layui-btn  layui-btn-mini" id="edit" title="编辑<?= mb_substr($val['title'],0,4,'utf-8');?>...">编辑</button>
                                <button class="layui-btn layui-btn-danger layui-btn-mini" id="del">删除</button>
                                </td>
                              </tr>
                          <?php } ?>