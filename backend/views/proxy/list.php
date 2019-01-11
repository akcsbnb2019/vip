<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\bootstrap\ActiveForm;
?>
						<?php foreach($model as $key=>$val){?>
                              <tr>
                                <td><input type="checkbox" value="<?= $val['id']?>" class="id"></td>
                                <td><?= $val['loginname']?></td>
                                <td><?= $val['truename']?></td>
                                <td><?php if($val['dllevel']==1): echo "代理商"; elseif($val['dllevel']==2): echo "微超市"; elseif ($val['dllevel']==3): echo "店铺";elseif ($val['bd']==1): echo "报单中心"; endif;?></td>
                                <td><?= $val['amount']?></td>
                                <td><?= $val['rid']?></td>
                                <td><?= $val['pid']?></td>
                                <td><?= $val['bank']?></td>
                                <td><?= $val['bankno']?></td>
                                <td class="small"><font><?= str_replace(' ', '<br>', $val['jihuotime'])?><font></td>
                                <td>
                                <?php if($val['lockuser']){?>
                                <button class="layui-btn layui-btn-primary layui-btn-mini" id="up1">已冻结</button>
                                <?php }else{?>
                                <button class="layui-btn layui-btn-normal layui-btn-mini" id="up2">正常</button>
                                <?php }?>
                                </td>
                                <td>
                                    <input type="hidden" id="id" class="id" value="<?=$val['id']?>">
                                    <button class="layui-btn layui-btn-warm layui-btn-mini" id="add" >电子券充值</button>
                                    <button class="layui-btn  layui-btn-mini" id="edit" >编辑</button>
                                </td>
                              </tr>
                          <?php } ?>