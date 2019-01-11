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
                                <td><?= $val['standardlevel']>0?"VIP".$val['standardlevel']."会员":"普通用户";?></td>
                                <td><?= $val['amount']?></td>
                                <td><?= $val['aixinjijin']?></td>
                                <td><?= $val['yuanshigu']?></td>
                                <td><?= $val['rid']?></td>
                                <td><?= $val['pid']?></td>
                                <td><?php 
                                $pos =['6'=>'总裁董事','7'=>'董事','8'=>'高级总监','9'=>'总监','10'=>'高级经理','11'=>'经理','12'=>'主任','13'=>'见习主任'];
                                echo (isset($pos[$val['position']])?$pos[$val['position']]:'无级别');
                                ?></td>
                                <td><?= $val['truename']?></td>
                                <td><?= $val['bankname']?></td>
                                <td><?= $val['bank']?></td>
                                <td>
                                <?php if($val['lockuser']){?>
                                <button class="layui-btn layui-btn-primary layui-btn-mini" id="up1">已冻结</button>
                                <?php }else{?>
                                <button class="layui-btn layui-btn-normal layui-btn-mini" id="up2">正常</button>
                                <?php }?>
                                </td>
                                <td>
                                    <input type="hidden" id="id" class="id" value="<?=$val['id']?>">
                                    <button class="layui-btn  layui-btn-mini" id="edit" >编辑</button>
                                    <a href="/user/obsedit?id=<?=$val['id']?>" class="layui-btn  layui-btn-mini" id="absedit">其它</a>
                                    <a href="/user/fund?id=<?=$val['id']?>" class="layui-btn  layui-btn-mini layui-btn-warm" id="absedit">资金</a>
<!--                                    <a href="/user/seltotal?id=--><?//=$val['id']?><!--" class="layui-btn  layui-btn-mini layui-btn-warm" id="absedit">奖金</a>-->
                                    <button class="layui-btn layui-btn-danger layui-btn-mini" id="deluser"  >删除</button>
                                </td>
                            </tr>
                        <?php } ?>