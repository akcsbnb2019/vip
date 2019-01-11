<?php

namespace frontend\controllers;

use backend\models\Users;
use frontend\models\EUsers;
use Yii;
use frontend\models\Income;
use frontend\models\ZmIncome;
use frontend\models\ZmTdgjj;
use frontend\models\ZmPositionPoints;
use frontend\models\Uso;
use frontend\models\ZmReport;
use frontend\models\UpUsersLevel;
use frontend\models\OrderInfo;
use frontend\models\OrderGoods;
use frontend\models\Goods;
use frontend\models\Region;
use common\models\User;
use common\models\Identity;
use Exception;
use frontend\region\RegionAction;
use frontend\models\ZmPositionLog;
use frontend\models\MobileSms;

/**
 * 用户信息控制器
 */
class UserController extends BaseController
{
    /**
     * 注册查询记录
     * @var unknown
     */
    public static $reg = false;
    /**
     * 会员中心
     * @return string
     */
    public function actionIndex()
    {
        /* 登录验证 */
        if(!defined('UID')){
            return $this->msg('请登录!',['icon'=>0,'url'=>'/']);
        }

        $user = User::findIdentity(UID);
        $income = new Income();

        $dlName = [ '1' => '代理商', '2' => '微超市', '3' => '店铺'];
        $lvName = [ '0' => '普通会员', '1' => 'VIP1级别', '2' => 'VIP2级别', '3' => 'VIP3级别'];
        $tdgjj = new ZmTdgjj();
        $ppoints = new ZmPositionPoints();
        $amount = 0;
        $dlamount = 0;
        $tdgjj_row = $tdgjj->find()->where(['status'=>3,'userid'=>UID])->andWhere(['in','type',[1,2,3]])->select("sum(points*pre) as amount")->asArray()->one();
        if(!empty($tdgjj_row)){
            $amount += $tdgjj_row['amount'];
        }
        $ppoints_row = $ppoints->find()->where(['status'=>3,'userid'=>UID])->select("sum(points*pre) as amount")->asArray()->one();
        if(!empty($ppoints_row)){
            $amount += $ppoints_row['amount'];
        }
        $dl_row = $tdgjj->find()->where(['status'=>3,'userid'=>UID])->andWhere(['in','type',[5,6]])->select("sum(points*0.05) as amount")->asArray()->one();
        if(!empty($dl_row)){
            $dlamount += $dl_row['amount'];
        }
        /*$scountall = $total->find()->where(['userid'=>UID])->andWhere(['>','scount',5])->asArray()->all();
        if(!empty($scountall)){
            foreach ($scountall as $value) {
                if($value['declaration']>0){
                    $dlamount += $value['declaration'];
                    $amount   += $value['bonus']-$value['declaration'];
                }else{
                    $amount   += $value['bonus'];
                }
            }
        }*/
        return $this->render('index', [
            'user' => $user,
            'model' => [
                'level' => isset($lvName[$user['standardlevel']])?$lvName[$user['standardlevel']]:'',/* 等级名称 */
                'fuli'  => $user['yuanshigu']>0 && $user['standardlevel']>0?true:false,/* 福利信息 */
                'dlName'=> isset($dlName[$user['dllevel']])?$dlName[$user['dllevel']]:false,/* 代理名称 */
                'dlamount'=> (isset($dlName[$user['dllevel']])?$income->getDlAmount():0),//+$dlamount,/* 代理积分 */
                'amountall'=> $income->getAmountall()+$amount,/* 电子币历史 */
            ],
        ]);
    }

    /**
     * 股权证书
     */
    public function actionStockcert()
    {
        if($this->verisms() !== true){
            return self::$vfi;
        }
        $users = new User();
        $url=$this->urlTo("/index/main");
        if($this->isMobile((isset($_GET['ism'])?false:true))){
            $url=$this->urlTo("/index");
        }
        $row = $users->find()->where(['id'=>UID])->select(['loginname','identityid','addtime','yuanshigu','truename'])->one();
        if(empty($row['yuanshigu'])){
            return $this->msg('非法访问!',['icon'=>0,'url'=>$url]);
        }
        return $this->render('stockcert',[
            'model' => $row,
        ]);
    }

    /**
     * 职位记录
     */
    public function actionPosition()
    {
        $pst_arr = [0=>"",6=>"总裁董事",7=>"董事",8=>"高级总监",9=>"总监",10=>"高级经理","经理","主任","见习主任"];
        $position = new ZmPositionLog();
        $row = $position->find()
            ->where(['users_id'=>UID])
            ->orderBy('level ASC')
            ->select(['level','old_level','add_time'])
            ->asArray()
            ->all();

        foreach ($row as $key => $v) {
            $row[$key]['old_levels'] = $pst_arr[$v['old_level']];
            $row[$key]['levels'] = $pst_arr[$v['level']];
        }

        //echo "<pre/>";
        //print_r($row);
        return $this->render('position',[
            'model' => $row,
        ]);
    }

    /**
     * 安全完成度
     */
    public function actionSafety()
    {

    }

    /**
     * 申请报单中心
     */
    public function actionAddreport()
    {
        $users = new User();
        $row = $users->findIdentity(UID);
        $url=$this->urlTo("/index/main");
        if($this->isMobile((isset($_GET['ism'])?false:true))){
            $url=$this->urlTo("/index");
        }
        if($row['position']>11 || $row['position']==0){
            return $this->msg('非法访问!',['icon'=>0,'url'=>$url]);
        }
        if($row['bdl']==1){
            return $this->msg('您已是报单中心,无须再次申请!',['icon'=>0,'url'=>$url]);
        }

        $report = new ZmReport();
        $rerow = $report->findOne(['userid'=>$row['loginname']]);
        if(!empty($rerow) && $rerow['status']==0){
            return $this->msg('您已提交申请,请勿重复提交!',['icon'=>0,'url'=>$url]);
        }else if($rerow['status']==1){
            return $this->msg('您已通过申请!',['icon'=>1]);
        }
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post("ZmReport");
            $mobile_code = Yii::$app->request->post('mobile_code');
            if(empty($mobile_code)){
                return ['status'=>2,'msg'=>'验证码不能为空！'];
            }else if($mobile_code!=Yii::$app->session->get("mobile_code")){
                return ['status'=>2,'msg'=>'验证码不正确,请重新输入！'];
            }

            $report->userid = $row['loginname'];
            $report->adddate = date("Y-m-d",time());
            $report->readddate = '';
            $report->readdtime = '';
            $report->tel = $post['tel'];
            $report->province = $post['province'];
            $report->city = $post['city'];
            $report->district = $post['district'];
            $report->status = 0 ;
            if(!$report->save()){
                $err = $report->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['status' => 2, 'msg' => $first['0']];
            } else {
                $msg = "申请成功,请耐心等待管理员审批!";

                return ['status' => 6, 'msg' => $msg,'url'=>$url];
            }

        }
        return $this->render('report',[
            'user' => $row,
            'model' =>$report,
        ]);

    }

    /**
     * 升级处理
     * @return number[]|string[]|number[]|unknown[]|number[]|string[]|unknown[]|string
     */
    public function actionUpvip()
    {
    	
        /** 验证级别*/
        $jihuotime = "2018-08-29 00:00:00";
	    $up_id = Yii::$app->request->get("id");
	    $user = new User();
	    $uinfos = $user->findOne(['id'=>UID]);
	    if($uinfos->jihuotime>$jihuotime){
	    	$jihuotime = $uinfos->jihuotime;
	    }
	    $max_time = strtotime($jihuotime)+(86400*90);
	    if(empty($up_id) || !in_array($up_id, [2,3]) || time()>$max_time){
            return $this->msg('非法访问!',['icon'=>0,'url'=>'/index/main']);
        }
        /** 升级信息*/
        $vip_table = [
            1       =>      ['level'  =>  "1",'fd'  =>  "3000",],
            2       =>      ['level'  =>  "2",'fd'  =>  "30000",],
            3       =>      ['level'  =>  "3",'fd'  =>  "90000",],
        ];
        $vip_info = [
            '1-2'       =>       "沙棘油2盒  牡丹肽1盒  沙棘欣胃胶囊1盒  牡丹籽油1盒  沙棘山药胶囊1盒",//v1-v2
            '1-3'       =>       "功能被子1套  沙棘欣胃胶囊4盒  沙棘山药胶囊4盒  牡丹籽油3盒  芦荟胶3支  沙棘油3盒  牡丹肽3盒",//v1-v3
            '2-3'       =>       "沙棘油3盒  牡丹籽油2盒  沙棘欣胃胶囊3盒  沙棘山药胶囊3盒  牡丹肽3盒  洗手液4瓶",//v2-v3
        ];

        $goodsm = new Goods();
        $goods = [
            '1-2'       =>       [$goodsm->findOne(['goods_id'=>2671])['goods_id']=>$goodsm->findOne(['goods_id'=>2671])['goods_name']],//v1-v2
            '1-3'       =>       [$goodsm->findOne(['goods_id'=>2672])['goods_id']=>$goodsm->findOne(['goods_id'=>2672])['goods_name'],$goodsm->findOne(['goods_id'=>2670])['goods_id']=>$goodsm->findOne(['goods_id'=>2670])['goods_name']],//"功能被子1套  沙棘欣胃胶囊4盒  沙棘山药胶囊4盒  牡丹籽油3盒  芦荟胶3支  沙棘油3盒  牡丹肽3盒",//v1-v3
            '2-3'       =>       [$goodsm->findOne(['goods_id'=>2673])['goods_id']=>$goodsm->findOne(['goods_id'=>2673])['goods_name']],//"沙棘油3盒  牡丹籽油2盒  沙棘欣胃胶囊3盒  沙棘山药胶囊3盒  牡丹肽3盒  洗手液4瓶",//v2-v3
        ];
        $goods_check = [
            '1-2'       =>      2671,//v1-v2
            '1-3'       =>      2672,//v1-v3
            '2-3'       =>      2673,//v2-v3
        ];
        $vip_show = [
            2       =>      [ 1  => 4050, ],
            3       =>      [ 1  =>  13050, 2 =>  9000 ],
        ];

        /** 升级模型*/
        $uplevel = new UpUsersLevel();
        $order = new OrderInfo();
        $eu = new EUsers();

        $income  = new ZmIncome();

        /** ajax 升级入库处理*/
        if(Yii::$app->request->isAjax){
            $post  = Yii::$app->request->post("OrderInfo");
            $level = isset($post['up_standardlevel'])?intval($post['up_standardlevel']):0;
            if(empty($level)|| !isset($vip_show[$level])){
                return ['status'=>2,'msg'=>'请勿非法修改数据，刷新页面后重试！'];
            }
            /** 调取用户信息*/
            $uinfo = Yii::$app->mycomponent->getusers();
            if(!isset($vip_show[$level][$uinfo['standardlevel']])){
                return Yii::$app->mycomponent->pr(['status'=>2,'msg'=>'请勿非法修改数据，刷新页面后重试！']);
            }
            /** 需要扣除的金额*/
            $amount = $vip_show[$level][$uinfo['standardlevel']];
            /** 查看余额*/
            if($uinfo['amount']-$uinfo['djamount']-$amount<0){
                return Yii::$app->mycomponent->pr(['status'=>2,'msg'=>'请确保有充足的余额！']);
            }
            /*if($amount==4050){
                $goods_id = 2552;
            }else if($amount==13050){
                $goods_id = 2553;
            }else if($amount==9000){
                $goods_id = 2554;
            }*/
            $goods_is = [2671,2672,2673,2670];
            if(!in_array($post['goods_id'],$goods_is)){
                return ['status'=>2,'msg'=>'请勿非法修改数据，刷新页面后重试！'];
            }
            $goods_id = $post['goods_id'];
            $euinfo = $eu->findOne(['user_name'=>$uinfo['loginname']]);
            $order_fee= array(
                'user_id'               => $euinfo['user_id'],//金额
                'surplus'               => $amount,//金额
                'goods_amount'         => $amount,//商品金额
                'consignee'             =>  empty($post['consignee'])?"":$post['consignee'],//收货人姓名
                'province'              =>    $post['province'],   //收货人省
                'city'                  =>    $post['city'],   //收货人市
                'district'              =>    $post['district'],   //收货人县
                'address'               =>    $post['address'],   //收货人具体地址
                'tel'                    =>    $post['tel'],   //收货人手机号
            );
            /** 升级对应金额需要下发的积分数量*/
            $points = ['4050' => 2700,'13050' => 8700,'9000' => 6000];
            if(!isset($points[$amount])){
                return Yii::$app->mycomponent->pr(['status'=>2,'msg'=>'请勿非法修改数据，刷新页面后重试！']);
            }
            try{
                /** 插入升级记录*/
                $reg = $uplevel->addlevel($uinfo['loginname'],$uinfo['standardlevel'],$level,2);
                if($reg!==true){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $reg]);
                }
                /** 减去金额*/
                $ret = Yii::$app->mycomponent->setkeys('amount',-1*$amount);
                if($ret === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '金额调整失败!']);
                }
                $ret = Yii::$app->mycomponent->setkeys('standardlevel',$level,true);
                if($ret === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '级别调整失败']);
                }
                /** 升级下发奖金*/
                $ret = Yii::$app->mycomponent->orderPoints(Yii::$app->db->getLastInsertID(),$points[$amount]);
                if($ret === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '升级失败','put'=>'order. not users.11']);
                }
                /** 添加兑换记录*/
                $rets = $income->addIncome($uinfo['id'],$amount*-1,$uinfo['amount']-$amount,9);
                if(empty($rets) || $rets === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '积分变动记录写入失败']);
                }
                /** 生成订单*/
                $order_info = $this->addOrder($order_fee);
                $rets = Yii::$app->db->createCommand()->Insert('ecs_order_info', $order_info)->execute();
                if(empty($rets) || $rets === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '订单添加失败']);
                }
                $order_id =  Yii::$app->db->getLastInsertID();
                $goods_info = $this->addOrderGoods($order_id,$goods_id);
                $rets = Yii::$app->db->createCommand()->Insert('ecs_order_goods', $goods_info)->execute();
                if(empty($rets) || $rets === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '订单商品添加失败']);
                }
                Yii::$app->mycomponent->commit();
                return ['status' => 6, 'msg' => '升级成功!','url'=>$this->urlTo("/index/main")];

            }catch (Exception $e) {
                return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '升级失败,请确保有充足的余额']);
            }
        }
        /** 获取用户基本信息 */
        $uinfo = User::findIdentity(UID);
        if(empty($uinfo) || !in_array($uinfo['standardlevel'], [1,2]) || !isset($vip_show[$up_id][$uinfo['standardlevel']])){
            return $this->msg('非法访问!',['icon'=>0,'url'=>'/index/main']);
        }

        /** 显示信息*/
        $row = [
            'level'     => $uinfo['standardlevel'],
            'newvip'    => $up_id,
            'amount'    => $uinfo['amount'],
            'newamount' => $vip_show[$up_id][$uinfo['standardlevel']],
        ];
        $row[$up_id]                  =  $vip_table[$up_id];
        $row[$uinfo['standardlevel']] =  $vip_table[$uinfo['standardlevel']];
        $row['taocan'] =  $vip_info;
        return $this->render('upvip',[
            'model' =>  $order,
            'goods' =>  $goods,
            'goods_check' =>  $goods_check,
            'row'   =>  $row,
        ]);
    }

    /**
     * 平移升级
     * @return number[]|string[]|number[]|unknown[]|number[]|string[]|unknown[]|string
     */
    public function actionPupvip()
    {
        $eu = new EUsers();
        /** 验证级别*/
        $jihuotime = "2018-08-29 00:00:00";
        $up_id = Yii::$app->request->get("id");
	    $user = new User();
	    $uinfos = $user->findOne(['id'=>UID]);
	    if($uinfos->jihuotime>$jihuotime){
		    $jihuotime = $uinfos->jihuotime;
	    }
	    $max_time = strtotime($jihuotime)+(86400*90);
	    if(empty($up_id) || !in_array($up_id, [2,3]) || time()>$max_time){
		    return $this->msg('非法访问!',['icon'=>0,'url'=>'/index/main']);
	    }
        /** 升级信息*/
        $vip_table = [
            1       =>      ['level'  =>  "1",'fd'  =>  "3000",],
            2       =>      ['level'  =>  "2",'fd'  =>  "30000",],
            3       =>      ['level'  =>  "3",'fd'  =>  "90000",],
        ];
        $vip_show = [
            1       =>      1350,
            2       =>      1350,
            3       =>      1350,
        ];
        /** 升级模型*/
        $uplevel = new UpUsersLevel();
        $order = new OrderInfo();

        $income  = new ZmIncome();

        /** ajax 升级入库处理*/
        if(Yii::$app->request->isAjax){
            $post  = Yii::$app->request->post("OrderInfo");
            $level = isset($post['up_standardlevel'])?intval($post['up_standardlevel']):0;

            if(empty($level)|| !isset($vip_show[$level])){
                return ['status'=>2,'msg'=>'请勿非法修改数据，刷新页面后重试！'];
            }
            /** 调取用户信息*/
            $uinfo = Yii::$app->mycomponent->getusers();
            if(!isset($vip_show[$level])){
                return Yii::$app->mycomponent->pr(['status'=>2,'msg'=>'请勿非法修改数据，刷新页面后重试！']);
            }
            /** 需要扣除的金额*/
            $amount = $vip_show[$level];
            /** 查看余额*/
            if($uinfo['amount']-$uinfo['djamount']-$amount<0){
                return Yii::$app->mycomponent->pr(['status'=>2,'msg'=>'请确保有充足的余额！']);
            }
            if($amount==1350){
                /*v0->v3*/
                $goods_id = 2551;
            }
            /*else if($amount==8700){
                /*v1->v3
                $goods_id = 1060;
            }else if($amount==9000){
                /*v2->v3
                $goods_id = 1060;
            }*/
            /** 升级对应金额需要下发的积分数量*/
            $points = ['1350' => 900];
            if(!isset($points[$amount])){
                return Yii::$app->mycomponent->pr(['status'=>2,'msg'=>'请勿非法修改数据，刷新页面后重试！']);
            }
            $euinfo = $eu->findOne(['user_name'=>$uinfo['loginname']]);
            $order_fee= array(
                'user_id'               => $euinfo['user_id'],//金额
                'surplus'               => $amount,//金额
                'goods_amount'         => $amount,//商品金额
                'consignee'             =>  empty($post['consignee'])?"":$post['consignee'],//收货人姓名
                'province'              =>    $post['province'],   //收货人省
                'city'                  =>    $post['city'],   //收货人市
                'district'              =>    $post['district'],   //收货人县
                'address'               =>    $post['address'],   //收货人具体地址
                'tel'                    =>    $post['tel'],   //收货人手机号
            );
            try{
                /** 插入升级记录*/
                $reg = $uplevel->addlevel($uinfo['loginname'],$uinfo['standardlevel'],$level,4);
                if($reg!==true){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $reg]);
                }
                /** 减去金额*/
                $ret = Yii::$app->mycomponent->setkeys('amount',-1*$amount);
                if($ret === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '金额调整失败!']);
                }
                $ret = Yii::$app->mycomponent->setkeys('standardlevel',$level,true);
                if($ret === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '级别调整失败']);
                }
                /** 升级下发奖金*/
                $ret = Yii::$app->mycomponent->orderPoints(Yii::$app->db->getLastInsertID(),$points[$amount],3);
                if($ret === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '升级失败','put'=>'order. not users.11']);
                }
                /** 添加兑换记录*/
                $rets = $income->addIncome($uinfo['id'],$amount*-1,$uinfo['amount']-$amount,16);
                if(empty($rets) || $rets === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '积分变动记录写入失败']);
                }
                /** 生成订单*/
                $order_info = $this->addOrder($order_fee);
                $rets = Yii::$app->db->createCommand()->Insert('ecs_order_info', $order_info)->execute();
                if(empty($rets) || $rets === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '订单添加失败']);
                }
                $order_id =  Yii::$app->db->getLastInsertID();
                $goods_info = $this->addOrderGoods($order_id,$goods_id);
                $rets = Yii::$app->db->createCommand()->Insert('ecs_order_goods', $goods_info)->execute();
                if(empty($rets) || $rets === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '订单商品添加失败']);
                }
                Yii::$app->mycomponent->commit();
                return ['status' => 6, 'msg' => '升级成功!','url'=>$this->urlTo("/index/main")];

            }catch (Exception $e) {
                return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '升级失败,请确保有充足的余额']);
            }
        }
        /** 获取用户基本信息 */
        $uinfo = User::findIdentity(UID);
        if(empty($uinfo) || !in_array($uinfo['standardlevel'], [0]) || !isset($vip_show[$up_id])){
            return $this->msg('非法访问!',['icon'=>0,'url'=>'/index/main']);
        }

        /** 显示信息*/
        $row = [
            'level'     => $uinfo['standardlevel'],
            'newvip'    => $up_id,
            'amount'    => $uinfo['amount'],
            'newamount' => $vip_show[$up_id],
        ];
        $row[$up_id]                  =  $vip_table[$up_id];
        return $this->render('pupvip',[
            'model' =>  $order,
            'row'   =>  $row,
        ]);
    }

    /*
     *  注册三点位
     * */
    public function actionUpreg()
    {
        $users = new User();
        $eu = new EUsers();
        $order = new OrderInfo();

        $leftinfo = $users->findByLeftName(Yii::$app->session->get("loginname"));
        if($leftinfo['standardlevel']>0){
            return $this->msg('左区用户已是vip，无法使用该功能!',['icon'=>0,'url'=>'/index/main']);
        }
        if (!is_null($leftinfo) && $leftinfo['rid'] != Yii::$app->session->get("loginname")) {
            return $this->msg('左区用户推荐人不是当前用户，无法使用该功能!',['icon'=>0,'url'=>'/index/main']);
        }


        if(Yii::$app->session->get("level")!=0){
            return $this->msg('非法访问!',['icon'=>0,'url'=>'/index/main']);
        }

        $goodsm = new Goods();
        $goods = [
            '0-3'       =>       [$goodsm->findOne(['goods_id'=>2680])['goods_id']=>$goodsm->findOne(['goods_id'=>2680])['goods_name'],$goodsm->findOne(['goods_id'=>2681])['goods_id']=>$goodsm->findOne(['goods_id'=>2681])['goods_name']],//"功能被子1套  沙棘欣胃胶囊4盒  沙棘山药胶囊4盒  牡丹籽油3盒  芦荟胶3支  沙棘油3盒  牡丹肽3盒",//v1-v3
        ];
        $goods_check = [
            '0-3'       =>      2680
        ];
        $vip_show = [
            1       =>      18000,
        ];
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post("OrderInfo");
            if(empty($post['goods_id'])){
                return ['status' => 2, 'msg' => '请选择套餐'];
            }
            $goods_id = $post['goods_id'];
            if(empty($leftinfo)){
                if(empty($post['luname'])){
                    return ['status' => 2, 'msg' => '左区用户不能为空'];
                }else{
                    if(!$this->actionCheckuname($post['luname'])||$post['isleft']!=1){
                        return ['status' => 2, 'msg' => '左区用户已存在,请更换其他用户!'];
                    }else{
                        if(!preg_match("/^[a-z\\d]*$/", $post['luname'], $toname)){
                            return ['status' => 2, 'msg' => '左区用户格式错误!'];
                        }
                    }
                }
                $istype = 1;
            }else{
                if(empty($post['isleft'])||$post['isleft']!=1){
                    return ['status' => 2, 'msg' => '请确认是否使用左区用户'];
                }
                $istype = 0;
            }
            if(empty($post['runame'])){
                return ['status' => 2, 'msg' => '右区用户不能为空'];
            }else{
                if(!$this->actionCheckuname($post['runame'])){
                    return ['status' => 2, 'msg' => '右区用户已存在,请更换其他用户!'];
                }else{
                    /*  正则验证用户名*/
                    if(!preg_match("/^[a-z\\d]*$/", $post['runame'], $toname)){
                        return ['status'=>2,'msg'=>'右区用户格式错误！'];
                    }
                }
            }

            $uinfo = Yii::$app->mycomponent->getusers();
            $euinfo = $eu->findOne(['user_name'=>$uinfo['loginname']]);
            $order_fee= array(
                'user_id'               => $euinfo['user_id'],//金额
                'surplus'               => 27000,//金额
                'goods_amount'         => 27000,//商品金额
                'consignee'             =>  empty($post['consignee'])?"":$post['consignee'],//收货人姓名
                'province'              =>    $post['province'],   //收货人省
                'city'                  =>    $post['city'],   //收货人市
                'district'              =>    $post['district'],   //收货人县
                'address'               =>    $post['address'],   //收货人具体地址
                'tel'                    =>    $post['tel'],   //收货人手机号
            );

            if($uinfo['amount']-$uinfo['djamount']-27000<0){
                return Yii::$app->mycomponent->pr(['status'=>2,'msg'=>'请确保有充足的余额！']);
            }

            $ridpos = 0;
            $rupos  = User::findByUsername($uinfo['rid']);
            if(isset($rupos['id'])){
                $ridpos = $rupos['id'];
            }
            $user   = new Uso();
            $user1  = new Uso();
            $euser  = new EUsers();
            $euser1 = new EUsers();
            $uplevel= new UpUsersLevel();
            $income = new ZmIncome();
            $user->status_code  = 2;
            $user1->status_code = 2;

            try{
                $rets = $user1->addUsers($post['runame'],$uinfo,2);
                if($rets!==true){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $rets."a"]);
                }
                $position = [];
                /**职称等级入表*/
                if(!empty($user1->uids)){
                    $position[1] = [$user1->uids, $post['runame'],0,$uinfo['id'],$ridpos,time(),1,0];
                }
                /**添加用户*/
                $rets = $euser1->addEusers($post['runame'],$uinfo['pwd1'],$uinfo['tel'],6000,'2');
                if($rets!==true){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $rets."b"]);
                }
                if($istype==1){
                    $luname = $post['luname'];
                    $rets = $user->addUsers($post['luname'],$uinfo,1,9000);
                    if($rets!==true){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $rets."c"]);
                    }
                    if(!empty($user->uids)){
                        $position[2] = [$user->uids, $post['luname'],0,$uinfo['id'],$ridpos,time(),1,9000];
                    }
                    $rets = $euser->addEusers($post['luname'],$uinfo['pwd1'],$uinfo['tel'],6000,'2');
                    if($rets!==true){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $rets."d"]);
                    }
                    $rets  = Yii::$app->db->createCommand('UPDATE zm_position SET r_vip_num=r_vip_num+3 WHERE users_id in ('.$uinfo['rpath'].",".$uinfo['id'].')')->execute();
                    if(!$rets){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "更新推荐人数失败,请稍候重试!"]);
                    }
                    /*$rets  = Yii::$app->db->createCommand('UPDATE zm_position SET r_vip_num=r_vip_num+2 WHERE users_id = '.$uinfo['id'])->execute();
                    if(!$rets){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "更新当前用户推荐人数失败,请稍候重试!"]);
                    }*/
                }else{
                    $luname = $leftinfo['loginname'];
                    $rets  = Yii::$app->db->createCommand('UPDATE users SET standardlevel=3,pay_points_all=pay_points_all+9000 WHERE loginname = "'.$leftinfo['loginname'].'"')->execute();
                    if(!$rets){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "更新数据失败,请稍候重试!"]);
                    }
                    $rets  = Yii::$app->db->createCommand('UPDATE ecs_users SET alias="2" WHERE user_name = "'.$leftinfo['loginname'].'"')->execute();
                    if(!$rets){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "更新个人状态失败,请稍候重试!"]);
                    }
                    $rets  = Yii::$app->db->createCommand('UPDATE zm_position SET points_old=points_old+9000 WHERE uname = "'.$leftinfo['loginname'].'"')->execute();
                    if(!$rets){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "更新级别数据失败,请稍候重试!"]);
                    }
                    $rets  = Yii::$app->db->createCommand('UPDATE zm_position SET r_vip_num=r_vip_num+1 WHERE users_id in ('.$leftinfo['rpath'].')')->execute();
                    if(!$rets){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "更新推荐1人数失败,请稍候重试!"]);
                    }
                    $rets  = Yii::$app->db->createCommand('UPDATE zm_position SET r_vip_num=r_vip_num+2 WHERE users_id in ('.$uinfo['rpath'].",".$uinfo['id'].')')->execute();
                    if(!$rets){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "更新推荐2人数失败,请稍候重试!"]);
                    }
                    /*$rets  = Yii::$app->db->createCommand('UPDATE zm_position SET r_vip_num=r_vip_num+2 WHERE users_id ='.$uinfo['id'])->execute();
                    if(!$rets){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "更新当前用户推荐人数失败,请稍候重试!"]);
                    }*/
                }
                $rets  = Yii::$app->db->createCommand("UPDATE users SET cx_vipyeji1 =cx_vipyeji1+9000,lallyeji = lallyeji + 9000 WHERE loginname = '".$uinfo['loginname']."'")->execute();
                if(!$rets){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "更新人数失败1,请稍候重试!"]);
                }

                /** 添加职称等级记录*/
                if(count($position) > 0){
                    $rets = Yii::$app->db->createCommand()->batchInsert('zm_position', ['users_id', 'uname', 'level', 'pid', 'rid', 'up_time', 'status','points_old'], $position)->execute();
                    if(empty($rets) || $rets === false){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "新增用户失败!"]);
                    }
                }
                $reg = $uplevel->addlevel(Yii::$app->session->get("loginname"),Yii::$app->session->get("level"),3,3,$luname,$post['runame']);
                if($reg!==true){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $reg]);
                }
                $levelid = Yii::$app->db->getLastInsertID();
                $rets  = Yii::$app->db->createCommand('UPDATE ecs_users SET rank_points=rank_points+6000,pay_points=pay_points+6000,alias="2" WHERE user_name = "'.$uinfo['loginname'].'"')->execute();
                if(!$rets){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "更新数据失败,请稍候重试!"]);
                }

                $rets = Yii::$app->mycomponent->setkeys('amount',-1*27000);
                if(!$rets){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "金额调整失败!"]);
                }
                //true 表示数值等于什么   去掉true 表示加减操作
                $rets = Yii::$app->mycomponent->setkeys('standardlevel',3,true);
                if(!$rets){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "级别调整失败!"]);
                }
                $rets = Yii::$app->mycomponent->setkeys('jihuotime',date("Y-m-d H:i:s",time()),true);
                /*$rets  = Yii::$app->db->createCommand('UPDATE users SET standardlevel=3,jihuotime=\''.date("Y-m-d H:i:s",time()).'\' WHERE loginname = "'.$uinfo['loginname'].'"')->execute();*/
                if(!$rets){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "升级时间调整失败!"]);
                }


                /** 升级下发奖金*/
                $ret = Yii::$app->mycomponent->orderPoints($levelid,18000,2);
                if($ret === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '开通失败','put'=>'order. not level.1']);
                }
                /** 添加兑换记录*/
                $rets = $income->addIncome($uinfo['id'],-27000,$uinfo['amount']-27000,10);
                if(empty($rets) || $rets === false){
                    return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '积分变动记录写入失败']);
                }
                /** 生成订单*/
                
                if($goods_id==88888888){
                    $order_info = $this->addOrder1($order_fee);
                    $rets = Yii::$app->db->createCommand()->Insert('ecs_order_info', $order_info)->execute();
                    if(empty($rets) || $rets === false){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '订单添加失败']);
                    }
                    $order_id =  Yii::$app->db->getLastInsertID();
                    $goods_info = $this->addOrderGoods($order_id,$goods_id);
                    $rets = Yii::$app->db->createCommand()->Insert('ecs_order_goods', $goods_info)->execute();
                    if(empty($rets) || $rets === false){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '订单商品添加失败']);
                    }
                    $rets  = Yii::$app->db->createCommand('UPDATE ecs_users SET pay_points=0,user_coupon=27000,coupon_status=1,first_coupon=27000,coupon_rank_points=18000 WHERE user_name = "'.$uinfo['loginname'].'"')->execute();
                    if(!$rets){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "更新购物券失败,请稍候重试!"]);
                    }
                }else{
                    $order_info = $this->addOrder($order_fee);
                    $rets = Yii::$app->db->createCommand()->Insert('ecs_order_info', $order_info)->execute();
                    if(empty($rets) || $rets === false){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '订单添加失败']);
                    }
                    $order_id =  Yii::$app->db->getLastInsertID();
                    $goods_info = $this->addOrderGoods($order_id,$goods_id);
                    $rets = Yii::$app->db->createCommand()->Insert('ecs_order_goods', $goods_info)->execute();
                    if(empty($rets) || $rets === false){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '订单商品添加失败']);
                    }
                }
                Yii::$app->mycomponent->commit();
                return ['status' => 6, 'msg' => '开通成功!','url'=>$this->urlTo("/index/main")];

            }catch (Exception $e) {
                return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '开通失败了']);
            }
        }

        $row = $users -> findOne(['id'=>UID]);
        return $this->render('upreg',[
            'model' =>  $order,
            'lname' =>  $leftinfo['loginname'],
            'goods' =>  $goods,
            'goods_check' =>  $goods_check,
            'row' =>  $row,
        ]);

    }

    public function actionCheckuname($loginname)
    {
        $users = new User();
        if(!empty($users->findByUsername($loginname))){
            return false;
        }
        return true;

    }
    public function actions()
    {
        $actions=parent::actions();
        $actions['get-region']=[
            'class'=>RegionAction::className(),
            'model'=>Region::className()
        ];
        return $actions;
    }

    /**
     * 修改密码&修改&完善二级密码
     */
    public function actionPass()
    {
        $users = new User();
        $type = empty(Yii::$app->request->get('type'))?1:Yii::$app->request->get('type');
        $usero = User::findIdentity(UID);
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post("User");
            if($type==1) {

                if (md5(Yii::$app->request->post("pwd1")) != $usero['pwd1']) {
                    return ['status' => 2, 'msg' => '原密码验证错误,请核对后重新输入！'];
                }
                if($usero['pwd1']==md5($post['pwd1'])){
                    return ['status' => 2, 'msg' => '新密码不能与原密码相同！'];
                }
                if (!preg_match("/^[[:punct:]A-Za-z\\d]*$/", $post['pwd1'])) {
                    return ['status' => 2, 'msg' => '新密码输入格式错误！'];
                } else if (strlen($post['pwd1']) < 6) {
                    return ['status' => 2, 'msg' => '新密码长度不能小于6位！'];
                } else if (preg_match("/^[\\d]*$/", $post['pwd1'])) {
                    return ['status' => 2, 'msg' => '新密码不能是纯数字！'];
                }
                if (md5($post['pwd1']) != md5(Yii::$app->request->post("pwd2"))) {
                    return ['status' => 2, 'msg' => '两次密码输入不一致,请核对后重新输入！'];
                }
                $usero->pwd1 = md5($post['pwd1']);
                $msg = "修改成功,请重新登录";
                $url = $this->urlTo("/site/index");
            }else if($type==2){
                $post = Yii::$app->request->post("User");
                $mobile_code = Yii::$app->request->post('mobile_code');
                if(empty($mobile_code)){
                    return ['status'=>2,'msg'=>'验证码不能为空！'];
                }else if($mobile_code!=Yii::$app->session->get("mobile_code")){
                    return ['status'=>2,'msg'=>'验证码不正确,请重新输入！'];
                }
                if (!preg_match("/^[[:punct:]A-Za-z\\d]*$/", $post['pwd2'])) {
                    return ['status' => 2, 'msg' => '二级密码输入格式错误！'];
                } else if (strlen($post['pwd2']) < 6) {
                    return ['status' => 2, 'msg' => '二级密码长度不能小于6位！'];
                } else if (preg_match("/^[\\d]*$/", $post['pwd2'])) {
                    return ['status' => 2, 'msg' => '二级密码不能是纯数字！'];
                }
                if (md5($post['pwd2']) != md5(Yii::$app->request->post("pwd2"))) {
                    return ['status' => 2, 'msg' => '两次密码输入不一致,请核对后重新输入！'];
                }
                $usero->pwd2 = md5($post['pwd2']);
                $msg = "修改成功";
                $url = $this->urlTo("/index/main");
            }
            if (!$usero->save()) {
                $err = $usero->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['status' => 2, 'msg' => $first['0']];
            } else {
                return ['status' => 6, 'msg' => $msg,'url'=>$url];
            }
        }else{
            $this->geturl(Yii::$app->request->getReferrer());
            return $this->render('pass',[
                'type'=>$type,
                'model' => $users,
                'tel'   => $usero['tel']
            ]);
        }
    }
    /** 验证银行卡号*/
    function checkBankNo($str, $user, $excludeSelf = true) {
        if (empty($str)) {
            return '银行账号不得为空';
        }
        if (preg_match('/^[1-9]\\d{5,20}$/', $str) == 0) {
            return '银行账号格式不正确';
        }
        $users = new Users();
        $query = $users->find()->where(['bankno'=>$str]);
        if ($excludeSelf) {
            $query->andWhere(['<>','loginname', $user])->andWhere(['<>','rid','a001']);
        }
        $used = $query->count();
        if ($used == 0) {
            return true;
        }
        if ( $used >= 7) {
            return '银行账号使用次数已达到7次';
        }
        $userRow = $users->findOne(['id'=>UID]);

        $arr = explode(',', $userRow['rpath']);
        $arr[] = $userRow['id'];
        if ($users->find()->where(['bankno'=> $str])->andWhere(['<>','id',UID])->andWhere(['<>','rid','a001'])->andWhere(['or',['in','id',$arr],["or like",'rpath',['%,'.UID,'%,'.UID.'%,']]])->count() > 7) {
            return '银行账号使用次数已达到7次';
        }
        if ($users->find()->where(['bankno'=>$str])->andWhere(['<>','id',UID])->andWhere(['<>','rid','a001'])->andWhere(['or',['in','id',$arr],["or not like",'rpath',['%,'.UID,'%,'.UID.'%,']]])->count() > 7) {
            return '银行账号已被非同团队人使用';
        }
        return true;
    }
    /*验证身份证*/
    function checkIdentityId($str, $user, $excludeSelf = true) {
        if (empty($str)) {
            return '身份证号码不得为空';
        }
        if (preg_match('/^[0-9]\\d{14}$/', $str) == 0
            && preg_match('/^[0-9]\\d{17}$/', $str) == 0
            && preg_match('/^[0-9]\\d{16}x$/', $str) == 0
            && preg_match('/^[0-9]\\d{16}X$/', $str) == 0) {
            return '身份证号码格式不正确';
        }
        $users = new Users();
        $query = $users->find()->where(['identityid'=>$str]);
        if ($excludeSelf) {
            $query->andWhere(['<>','loginname',$user])->andWhere(['<>','rid','a001']);
        }
        $used = $query->count();
        if ($used == 0) {
            return true;
        }
        if ( $used >= 7) {
            return '身份证号码使用次数已达到7次';
        }
        $userRow = $users->findOne(['id'=>UID]);
        $arr = explode(',', $userRow['rpath']);
        $arr[] = $userRow['id'];
        if ($users->find()->where(['identityid'=> $str])->andWhere(['<>','id',UID])->andWhere(['<>','rid','a001'])->andWhere(['or',['in','id',$arr],["or like",'rpath',['%,'.UID,'%,'.UID.'%,']]])->count() > 7) {
            return '身份证号码使用次数已达到7次';
        }
        if ($users->find()->where(['identityid'=>$str])->andWhere(['<>','id',UID])->andWhere(['<>','rid','a001'])->andWhere(['or',['in','id',$arr],["or not like",'rpath',['%,'.UID,'%,'.UID.'%,']]])->count() > 7) {
            return '身份证号码已被非同团队人使用';
        }
        return true;
    }
    function checkIdentityId1($str, $user,$ci = 7 ,$excludeSelf = true) {
        if (empty($str)) {
            return '手机号码不得为空';
        }
        if (preg_match('/^[0-9]\\d{14}$/', $str) == 0
            && preg_match('/^[0-9]\\d{17}$/', $str) == 0
            && preg_match('/^[0-9]\\d{16}x$/', $str) == 0
            && preg_match('/^[0-9]\\d{16}X$/', $str) == 0) {
            return '身份证号码格式不正确';
        }
        $users = new Users();
        $query = $users->find()->where(['identityid'=>$str]);
        if ($excludeSelf) {
            $query->andWhere(['<>','loginname', $user])->andWhere(['<>','rid','a001']);
        }
        $used = $query->count();

        if ($used == 0) {
            return true;
        }
        if ( $used >= $ci) {
            return '身份证使用次数已达到上限';
        }
        $userRow = $users->findOne(['loginname'=>$user]);

        $arr = explode(',', $userRow['rpath']);
        $arr[] = $userRow['id'];

        if ($users->find()->where(['identityid'=>$str])->andWhere(['<>','id',$userRow['id']])->andWhere(['<>','rid','a001'])->andWhere(['or',['in','id',$arr],["or like",'rpath',['%,'.$userRow['id'],'%,'.$userRow['id'].'%,']]])->count() > $ci) {
            return '身份证使用次数已达到上限';
        }
        if($users->find()->where(['identityid'=>$str])->andWhere(['<>','id',$userRow['id']])->andWhere(['<>','rid','a001'])->andWhere(['or',['in','id',$arr],["or not like",'rpath',['%,'.$userRow['id'],'%,'.$userRow['id'].'%,']]])->count()>0){
            return '身份证已被非同团队人使用';
        }
        return true;
    }
    /** 验证手机号*/
    function checkPhone($str, $user, $excludeSelf = true) {
        if (empty($str)) {
            return '手机号码不得为空';
        }
        if (preg_match('/^1\\d{10}$/', $str) == 0) {
            return '手机号码格式不正确';
        }
        $users = new Users();
        $query = $users->find()->where(['tel'=>$str]);
        if ($excludeSelf) {
            $query->andWhere(['<>','loginname', $user])->andWhere(['<>','rid','a001']);
        }
        $used = $query->count();
        if ($used == 0) {
            return true;
        }
        if ( $used >= 7) {
            return '手机号使用次数已达到7次';
        }
        $userRow = $users->findOne(['id'=>UID]);

        $arr = explode(',', $userRow['rpath']);
        $arr[] = $userRow['id'];
        if ($users->find()->where(['tel'=>$str])->andWhere(['<>','id',UID])->andWhere(['<>','rid','a001'])->andWhere(['or',['in','id',$arr],["or like",'rpath',['%,'.UID,'%,'.UID.'%,']]])->count() > 7) {
            return '手机号使用次数已达到7次';
        }
        if ($users->find()->where(['tel'=>$str])->andWhere(['<>','id',UID])->andWhere(['<>','rid','a001'])->andWhere(['or',['in','id',$arr],["or not like",'rpath',['%,'.UID,'%,'.UID.'%,']]])->count() > 7) {
            return '手机号已被非同团队人使用';
        }
        return true;
    }
    /** 验证手机号*/
    function checkPhone1($str, $user,$ci = 7 ,$excludeSelf = true) {
        if (empty($str)) {
            return '手机号码不得为空';
        }
        if (preg_match('/^1\\d{10}$/', $str) == 0) {
            return '手机号码格式不正确';
        }
        $users = new Users();
        $query = $users->find()->where(['tel'=>$str]);
        if ($excludeSelf) {
            $query->andWhere(['<>','loginname', $user])->andWhere(['<>','rid','a001']);
        }
        $used = $query->count();

        if ($used == 0) {
            return true;
        }
        if ( $used >= $ci) {
            return '手机号使用次数已达到上限';
        }
        $userRow = $users->findOne(['loginname'=>$user]);

        $arr = explode(',', $userRow['rpath']);
        $arr[] = $userRow['id'];

        if ($users->find()->where(['tel'=>$str])->andWhere(['<>','id',$userRow['id']])->andWhere(['<>','rid','a001'])->andWhere(['or',['in','id',$arr],["or like",'rpath',['%,'.$userRow['id'],'%,'.$userRow['id'].'%,']]])->count() > $ci) {
            return '手机号使用次数已达到上限';
        }
        if($users->find()->where(['tel'=>$str])->andWhere(['<>','id',$userRow['id']])->andWhere(['<>','rid','a001'])->andWhere(['or',['in','id',$arr],["or not like",'rpath',['%,'.$userRow['id'],'%,'.$userRow['id'].'%,']]])->count()>0){
            return '手机号已被非同团队人使用';
        }
        return true;
    }
    /**
     * Lists all Users models.
     * @return mixed
     * 修改用户信息&完善用户信息
     */
    public function actionEdit()
    {
        if($this->verify() !== true){
            return self::$vfi;
        }
        $bank = array("农业银行"=>"农业银行","工商银行"=>"工商银行","建设银行"=>"建设银行","农商银行"=>"农商银行","其它"=>"其它");
        $user = new Uso();

        $userinfo = $user->findOne(['id'=>UID]);
        $userinfo->status_code = 1;


        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post('Uso');
            if($userinfo['tel']!=""){
                $mobile_code = Yii::$app->request->post('mobile_code');
                if(empty($mobile_code)){
                    return ['status'=>2,'msg'=>'验证码不能为空！'];
                }else if($mobile_code!=Yii::$app->session->get("mobile_code")){
                    return ['status'=>2,'msg'=>'验证码不正确,请重新输入！'];
                }
            }


            if(!empty($post['identityid'])&&$post['identityid']!=$userinfo->identityid){
                $checkidentity = $this->checkIdentityId($post['identityid'],$userinfo->loginname);
                if($checkidentity!==true){
                    return ['status'=>2,'msg'=>$checkidentity];
                }
            }
            if(!empty($post['bankno'])&&$post['bankno']!=$userinfo->bankno){
                $checkbankno = $this->checkBankNo($post['bankno'],$userinfo->loginname);
                if($checkbankno!==true){
                    return ['status'=>2,'msg'=>$checkbankno];
                }
            }
            if(!empty($post['tel'])&&$post['tel']!=$userinfo->tel){
                $checkphone = $this->checkPhone($post['tel'],$userinfo->loginname);
                if($checkphone!==true){
                    return ['status'=>2,'msg'=>$checkphone];
                }
            }
            $userinfo->status_code = 1;
            $userinfo->truename = trim($post['bankname']);
            $userinfo->address = trim($post['address']);
            $userinfo->pic = trim($post['pic']);
            $userinfo->tel = trim($post['tel']);
            $userinfo->qq = trim($post['qq']);
            $userinfo->identityid = trim($post['identityid']);
            $userinfo->bankname = trim($post['bankname']);
            $userinfo->bank = trim($post['bank']);
            $userinfo->bankno = trim($post['bankno']);
            $userinfo->bankaddress = trim($post['bankaddress']);
            $obj_identity = new Identity();
            $data1 = $obj_identity ->checkIdentity($userinfo->identityid);
            if(!$data1){
                return ['status'=>2,'msg'=>'身份证格式错误,请重新输入!'];
            }
            //验证年龄
            $data1 = $obj_identity ->getAge(18,75);
            if(!$data1){
                return ['status'=>2,'msg'=>'身份证年龄不符,请重新输入!'];
            }
            //更新数据
            $userinfo->save();
            if(!$userinfo->save()){
                $err = $userinfo->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['status'=>2,'msg'=>$first['0']];
            }
            return ['status' => 6, 'msg' => "修改成功",'url'=>$this->urlTo('/user/edit')];
        }else{
            $this->geturl(Yii::$app->request->getReferrer());
            return $this->render('edit', [
                'model' => $userinfo,
                'bank' => $bank,
            ]);
        }

    }

    public function actionInfo()
    {
        if($this->verify() !== true){
            return self::$vfi;
        }
        $bank = array("农业银行"=>"农业银行","工商银行"=>"工商银行","建设银行"=>"建设银行","农商银行"=>"农商银行");
        $user = new Uso();

        $userinfo = $user->findOne(['id'=>UID]);

        $this->geturl(Yii::$app->request->getReferrer());
        return $this->render('info', [
            'model' => $userinfo,
            'bank' => $bank,
        ]);

    }

    function geturl($url= ""){
        $urls = substr($url,strpos($url,'.com')+4);
        Yii::$app->session->set("go_url",$urls);
    }

    /**
     * 注册会员
     * @return string
     */
    public function actionReg()
    {
        /* 登录验证 */
        if(!defined('UID')){
            return $this->msg('请登录!',['icon'=>0,'url'=>$this->urlTo('/')]);
        }

        /* 没有二级密码时禁止注册*/
        if(Yii::$app->session->get('spwd')){
            if($this->verify() !== true){
                return self::$vfi;
            }
        }

        $get = Yii::$app->request->get();
        if(!isset($get['pid']) || !isset($get['area']) || intval($get['pid']) != $get['pid'] || !in_array($get['area'], [1,2])){
            return $this->msg("参数异常!",['icon'=>0,'url'=>$this->urlTo('/atlas/user')]);
        }
        $usero = User::findIdentity(UID);
        if($usero['position']>12||$usero['position']<1){
            if ($usero['dllevel']!=2){
                return $this->msg('非法请求!',['icon'=>0,'url'=>$this->urlTo('/')]);
            }
        }
        $userp = User::findIdentity(intval($get['pid']));
        $user  = new User();
        $punum = $user->find()->where('pid=:pid',[':pid'=>$userp['loginname']])->count();

        if($get['area']==2){
            if($usero['standardlevel']>0){
                if($punum <= 0){
                    return $this->msg('注册右区必须先注册左区!',['icon'=>0,'url'=>$this->urlTo('/atlas/user?id='.$get['pid'])]);
                }
                /*$row = $user->find()->where('rid=:rid',[':rid'=>$usero['loginname']])->andWhere(['area'=>1])->andWhere(['>','standardlevel',0])->count();
                if($row <= 0){
                    return $this->msg('您左区无VIP会员，无法注册右区！',['icon'=>0,'url'=>$this->urlTo('/atlas/user?id='.$get['pid'])]);
                }*/
            }else{
                //return $this->msg('您不是VIP会员，无法注册右区！',['icon'=>0,'url'=>$this->urlTo('/atlas/user?id='.$get['pid'])]);
            }
        }

        if(($get['area']==1 && $punum > 0 ) || ($get['area']==2 && $punum > 1)){
            return $this->msg('安置人当前区已有人，不能再注册当前区！',['icon'=>0,'url'=>$this->urlTo('/atlas/user?id='.$get['pid'])]);
        }
        $uso = new Uso();
        $uso->status_code=0;
        return $this->render('reg', [
            'model'  => $uso,
            'get'  => $get,
            'user'   => $usero,
            'userp'  => $userp,
        ]);
    }

    /**
     * 验证左区是否有VIP会员
     */
    public function actionIsright()
    {
        if(Yii::$app->request->isAjax) {

            $usero = User::findIdentity(UID);
            if($usero['standardlevel']>0){
                $user  = new User();
                /*$row = $user->find()->where('rid=:rid',[':rid'=>$usero['loginname']])->andWhere(['area'=>1])->andWhere(['>','standardlevel',0])->count();
                if($row <= 0){
                    return ['status'=>2,'msg'=>'您左区无VIP会员，无法注册右区，3秒后将返回图谱！'];
                }*/
                Yii::$app->session->set('rido',1);
                return ['status'=>1,'msg'=>''];
            }else{
                return ['status'=>2,'msg'=>'您不是VIP会员，无法注册右区，3秒后将返回图片！'];
            }
        }

        return '你在找什么，<a href="/">返回首页</a>';
    }

    /**
     * 验证注册基本信息，不存在返回错误信息
     * @return number[]|string[]|number[]
     */
    public function actionCheckuserid($post = [])
    {
        if(count($post) == 0){
            $post = Yii::$app->request->post();
        }
        if(Yii::$app->request->isAjax && isset($post['uname']) && isset($post['type'])) {
            $ty = intval($post['type']);
            $un = $post['uname'];
            $na = ['1' => '邀请人','2' => '代理商','3' => '新会员编号','5' => '密码','6' => '手机'];
            if(empty($un)){
                return ['status'=>2,'msg'=>$na[$ty].'输入不能为空！'];
            }
            if(in_array($ty, [1,2,3])){
                /* 正则匹配，验证内容合法 */
                if($ty==1){
                    if(!preg_match("/^[a-z\\d_.]*$/", $un, $toname)){
                        return ['status'=>2,'msg'=>$na[$ty].'输入格式错误！'];
                    }
                }else{
                    if(!preg_match("/^[a-z\\d]*$/", $un, $toname)){
                        return ['status'=>2,'msg'=>$na[$ty].'输入格式错误！'];
                    }
                }

                if($un != implode(',', $toname)){
                    return ['status'=>2,'msg'=>$na[$ty].'输入格式错误！'];
                }
                $un = implode(',', $toname);
                $wh = ['loginname'=>$un];
                /*if($ty == 2){
                    $wh['bd'] = 1;
                }*/
                $addamounts = User::findOne($wh);
                if($ty == 3){
                    if(!$addamounts){
                        if(preg_match("/^[\\d]*$/", $un)){
                            return ['status'=>2,'msg'=>$na[$ty].'不能是纯数字！'];
                        }else if(strlen($un) < 4){
                            return ['status'=>2,'msg'=>$na[$ty].'长度不能小于4位！'];
                        }
                    }else{
                        return ['status'=>2,'msg'=>$na[$ty].'已存在，请重新输入！'];
                    }
                }else{
                    if($addamounts){
                        if($ty == 1 && empty($addamounts['id'])){
                            return ['status'=>2,'msg'=>$na[$ty].'不存在，请核对后再次输入！'];
                        }
                        $name = '';
                        if(!empty($addamounts->bankname)||!empty($addamounts->truename)){
                            $name = empty($addamounts->bankname)?$addamounts->truename:$addamounts->bankname;
                        }
                        $ret = ['status'=>1,'msg'=>($ty == 1 ? $name : '')];
                        if(self::$reg){
                            $ret['user'] = $addamounts;
                        }
                        return $ret;
                    }else{
                        return ['status'=>2,'msg'=>$na[$ty].'不存在，请核对后再次输入！'];
                    }
                }
            }else{
                if($ty == 5){
                    if(!preg_match("/^[[:punct:]A-Za-z\\d]*$/", $un, $toname)){
                        return ['status'=>2,'msg'=>$na[$ty].'输入格式错误！'];
                    }else if(strlen($un) < 6){
                        return ['status'=>2,'msg'=>$na[$ty].'长度不能小于6位！'];
                    }else if(preg_match("/^[\\d]*$/", $un)){
                        return ['status'=>2,'msg'=>$na[$ty].'不能是纯数字！'];
                    }
                }else if($ty == 6){
                    if(!preg_match("/^[\\d]{4}[\-\\d]{1,2}[\\d]{6}$/", $un, $toname)){
                        return ['status'=>2,'msg'=>$na[$ty].'输入格式错误！'];
                    }else if(!self::isTel($un)){
                        return ['status'=>2,'msg'=>$na[$ty].'输入格式错误,小灵通或固话请加区号，区号后请加‘-’，手机无需加0！'];
                    }
                }
                if($un != implode(',', $toname)){
                    return ['status'=>2,'msg'=>$na[$ty].'输入格式错误！'];
                }
            }

            return ['status'=>1,'msg'=>''];
        }

        return '你在找什么，<a href="/">返回首页</a>';
    }
    /**
     * 手机号码严格验证
     * @param unknown $tel
     * @param string $type
     */
    private function isTel($tel, $type = '')
    {
        $regxArr = array(
            'sj'  => '/^(\+?86-?)?(13|15|16|17|18|19|14)[0-9]{9}$/',
            'tel' => '/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/',
            '400' => '/^400(-\d{3,4}){2}$/',
        );
        if($type && isset($regxArr[$type]))
        {
            return preg_match($regxArr[$type], $tel)?true:false;
        }
        foreach($regxArr as $regx)
        {
            if(preg_match($regx,$tel))
            {
                return true;
            }
        }
        return false;
    }
    /**
     * 注册入库
     */
    public function actionCheckreg()
    {
        /* 没有二级密码时禁止注册*/
        if(!defined('UID') || Yii::$app->session->get('spwd')){
            if($this->verify() !== true){
                return self::$vfi;
            }
        }
        if(Yii::$app->request->isAjax){
            $usokey    = ['rid'=>1,'pid'=>0,'area'=>0,'identityid'=>0,'fuwuuser'=>2,'loginname'=>3,'pwd1'=>5,'tel'=>6,'truename'=>0];
            $post      = Yii::$app->request->post('Uso');
            self::$reg = true;
            $ruser = "";
            $bd = null;
            if(empty($post['fuwuuser'])){
                $post['fuwuuser']='a001';
            }
            if(empty($post['truename'])){
                return ['status'=>2,'msg'=>'请填写真实姓名！'];
            }
            if(count($post) != count($usokey)){
                return ['status'=>2,'msg'=>'非法操作！'];
            }
            /* 验证入库合法性*/
            foreach ($post as $key => $val){
                if(!isset($usokey[$key])){
                    return ['status'=>2,'msg'=>'非法操作！'];
                    break;
                }
                if($usokey[$key] > 0){
                    if($usokey[$key] == 2 && empty($val)){
                        continue;
                    }
                    $ret = self::actionCheckuserid(['uname'=>$val,'type'=>$usokey[$key]]);
                    if($ret['status'] == 2){
                        return $ret;
                        break;
                    }
                    if($usokey[$key] == 1){
                        $ruser = $ret['user'];
                    }
                    if($usokey[$key] == 2){
                        $bd    = $ret['user'];
                    }
                }
            }
            if(md5($post['pwd1']) != md5(Yii::$app->request->post('pwd1'))){
                return ['status'=>2,'msg'=>'二级密码输入不一致,请重新输入！'];
            }
            if(!preg_match("/^[a-z\\d]*$/", $post['pid'], $toname)){
                return ['status'=>2,'msg'=>'安置人不存在！'];
            }
            $toname = implode(',', $toname);
            if($post['pid'] != $toname){
                return ['status'=>2,'msg'=>'安置人不存在！'];
            }

            /* 验证创建是否满足条件 */
            $user  = new User();
            $count = $user->find()->where('pid=:pid',[':pid'=>$toname])->count();
            if($post['area'] == 2){
                /*if($post['rid'] != Yii::$app->session->get('loginname')){
                    return ['status'=>2,'msg'=>'注册右区邀请人必须是自己！'];
                }
                if($count <= 0){
                    return ['status'=>2,'msg'=>'注册右区必须先注册左区！'];
                }*/
                if($count >= 2){
                    return ['status'=>2,'msg'=>'这个账号右区已有人，无法注册！'];
                }
                /*if(!Yii::$app->session->get('rido')){
                    $reo = self::actionIsright();
                    if($reo['status'] == 2){
                        return ['status'=>2,'msg'=>'您左区无VIP会员，无法注册右区！'];
                    }
                }*/
            }else if($count >= 1){
                return ['status'=>2,'msg'=>'该账号左区已有人，无法注册！'];
            }
            $uinfo = $user->findOne(['id'=>UID]);
            if($uinfo['loginname']!=$post['rid']){
                $pid = $user->findOne(['loginname'=>$post['pid']]);
                $parr = explode(',',$pid['ppath']);
                $rid = $user->findOne(['loginname'=>$post['rid']]);
                /*推荐人同邀请团队*/
                $arr = explode(',',$uinfo['rpath']);
                $arr1 = explode(',',$rid['rpath']);
                if(!in_array($rid['id'],$arr) && !in_array(UID,$arr1)){
                    return ['status'=>2,'msg'=>'邀请人非安置人的邀请团队，无法注册！'];
                }
                if($post['rid']!=$post['pid']){
                    if(!in_array($rid['id'],$parr)){
                        return ['status'=>2,'msg'=>'请勿跨区注册！'];
                    }
                }
                /*if($rid['standardlevel']<1){
	                return ['status'=>2,'msg'=>'推荐人非VIP用户,无法注册！'];
                }*/

            }
            /*手机号7人验证*/
            $istel = $this->checkPhone1($post['tel'],$post['rid'],6);
            if($istel!==true){
                return ['status'=>2,'msg'=>$istel];
            }
            /*身份证7人验证*/
            $isident1 = $this->checkIdentityId1($post['identityid'],$post['rid'],6);
            if($isident1!==true){
                return ['status'=>2,'msg'=>$isident1];
            }
            $isident2 = $this->actionCheckidentityid($post['identityid']);
            if($isident2!==true){
                return ['status'=>2,'msg'=>$isident2];
            }

            $user = new Uso();
            /* Yii验证提交信息是否完整 */
            if (!$user->load(Yii::$app->request->post()) ) {
                return ['status'=>2,'msg'=>'提交信息缺失！'];
            }
            $user->pwd1 = md5($user->pwd1);
            /* 根据安置人设置基本信息 */
            $userp = User::findOne(['loginname'=>$toname]);
            $user->status_code = 0;
            $user->ppath = $userp['ppath'].','.$userp['id'];
            $user->ceng  = $userp['ceng']+1;
            $user->rpath = $ruser['rpath'].','.$ruser['id'];
            $user->dai   = $ruser['dai']+1;

            $bdrow = $user->findOne(['loginname'=>$post['fuwuuser']]);
            if($bdrow['dllevel']!=1 && $bdrow['bdl']==0){
                return ['status'=>2,'msg'=>'服务中心不存在，无法注册！'];
            }else{
                $rid = $user->findOne(['loginname'=>$post['rid']]);
                $arr = explode(',',$rid['rpath']);
                $arr1 = explode(',',$bdrow['rpath']);
                if(!in_array($bdrow['id'],$arr)&&!in_array($rid['id'],$arr1)){
                    return ['status'=>2,'msg'=>'服务中心非邀请人的邀请团队，无法注册！'];
                }
                if($bdrow['dllevel']==1){
                    $user->baodan   = $post['fuwuuser'];
                }
                if($bdrow['bdl']==1){
                    $user->bdr   = $post['fuwuuser'];
                }

            }

            $userall = $user->find()->where(['in','id',explode(',',$user->ppath)])->asArray()->select(['id','area'])->orderBy('id desc')->all();
            $left = $right = [];
            $str  = $user->area;
            foreach ($userall as $key => $val){
                if($str == 1){
                    $left[] = $val['id'];
                }else if($str == 2){
                    $right[] = $val['id'];
                }
                $str = $val['area'];
            }

            unset(Yii::$app->session['rido']);
            $euser       = new EUsers();
            $sess        = ['status'=>2,'msg'=>'注册失败'];
            $position = [];

            $transaction = Yii::$app->db->beginTransaction();
            try{
                if(!$user->save()){
                    $err  = $user->getErrors();
                    list($first_key, $first) = (reset($err) ? each($err) : each($err));
                    $sess = ['status'=>2,'msg'=>$first['0']];
                }else{
                    /**职称等级入表*/
                    $insert_id = Yii::$app->db->getLastInsertID();
                    $pid_info = $user->findOne(['loginname'=>$post['pid']]);
                    $rid_info = $user->findOne(['loginname'=>$post['rid']]);
                    if(!empty($insert_id)){
                        $position[0] = [$insert_id, $post['loginname'],0,$pid_info['id'],$rid_info['id'],time(),1];
                    }
                    $rets = Yii::$app->db->createCommand()->batchInsert('zm_position', ['users_id', 'uname', 'level', 'pid', 'rid', 'up_time', 'status'], $position)->execute();
                    if(empty($rets) || $rets === false){
                        return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => "新增用户失败!"]);
                    }
                    $rets = $euser->addEusers($user->loginname,$user->pwd1,$user->tel,0,'0');

                    if($rets){
                        $rets  = Yii::$app->db->createCommand('UPDATE users SET num1=num1+1 WHERE id in('.(implode(',', $left)).')')->execute();
                    }
                    if($rets){
                        $rets  = Yii::$app->db->createCommand('UPDATE users SET num2=num2+1 WHERE id in('.(implode(',', $right)).')')->execute();
                    }
                    if($rets){
                        $insert_row = $user->findOne(['id'=>$insert_id]);
                        $sms = new MobileSms();
                        $sms->addcode($insert_row['tel'],$insert_row,3);
                        $transaction->commit();//提交事务会真正的执行数据库操作
                        $sess = ['status'=>6,'msg'=>'注册成功','url'=>$this->urlTo('/atlas/user?id='.$userp['id'])];
                    }else{
                        $transaction->rollback();
                    }
                }
            }catch (Exception $e) {
                $transaction->rollback();//如果操作失败, 数据回滚
            }
            return $sess;
        }

        return '你在找什么，<a href="/">返回首页</a>';
    }
    public function actionCheckidentityid($identity){
        $obj_identity = new Identity();
        $msg = true;
        if(Yii::$app->request->isAjax) {
            $data = $obj_identity->checkIdentity($identity);
            if (!$data) {
                $msg = '身份证格式错误,请重新输入!';

            }
            //验证年龄
            $data = $obj_identity->getAge(18, 75);
            if (!$data) {
                $msg = '身份证年龄不符,请重新输入!';
            }
            return $msg;
        }
    }
    /*
     * 插入订单数据
     * */
    public function addOrder($row){
        /*
             * 初始化订单数据
             * */
        $order_sn = $this->get_order_sn();
        $order = array(
            'order_sn'     =>   $order_sn,    //订单状态
            'order_status'     => 1,    //订单状态
            'shipping_status'  => 0,    //收货状态
            'pay_status'        =>  2,  //支付状态
            'shipping_id'           =>  7,  //发货状态
            'shipping_name'           =>  '快递', //发货状态名称
            'country'               =>    1,   //收货人国
            'pay_id'           =>  11,  //支付方式
            'pay_name'           =>  '余额或购物券支付',    //支付方式说明
            'how_oos'           =>  '等待所有商品备齐后再发',  //发货详情
            'shipping_fee'           =>  0,  //运费
            'referer'           =>  '会员系统',  //标识订单来源
            'add_time'           =>  time()-28800,  //订单添加时间
            'confirm_time'           =>  time()-28800,  //订单确认时间
            'pay_time'           =>  time()-28800,  //订单支付时间
            'agency_id'           => 0,
            'inv_type'           => '',
            'tax'               =>  0,
            'discount'           => 0,
            'buyin_money'           => 0,
            'buyout_money'           => 0,
            'tihuo_desc'           => '',
        );
        $order = array_merge($order,$row);
        return $order;

//          $order_goods = array();
    }
    /*
     * 插入订单数据
     * */
    public function addOrder1($row){
        /*
             * 初始化订单数据
             * */
        $order_sn = $this->get_order_sn();
        $order = array(
            'order_sn'     =>   $order_sn,    //订单状态
            'order_status'     => 5,    //订单状态
            'shipping_status'  => 2,    //收货状态
            'pay_status'        =>  2,  //支付状态
            'shipping_id'           =>  7,  //发货状态
            'shipping_name'           =>  '快递', //发货状态名称
            'country'               =>    1,   //收货人国
            'pay_id'           =>  11,  //支付方式
            'pay_name'           =>  '余额或购物券支付',    //支付方式说明
            'how_oos'           =>  '等待所有商品备齐后再发',  //发货详情
            'shipping_fee'           =>  0,  //运费
            'referer'           =>  '会员系统',  //标识订单来源
            'add_time'           =>  time()-28800,  //订单添加时间
            'confirm_time'           =>  time()-28800,  //订单确认时间
            'shipping_time'           =>  time()-28800,  //订单确认时间
            'pay_time'           =>  time()-28800,  //订单支付时间
            'agency_id'           => 0,
            'inv_type'           => '',
            'tax'               =>  0,
            'discount'           => 0,
            'buyin_money'           => 0,
            'buyout_money'           => 0,
            'tihuo_desc'           => '',
        );
        $order = array_merge($order,$row);
        return $order;

//          $order_goods = array();
    }
    /*
     * 插入订单商品数据
     * */
    public function addOrderGoods($order_id,$goods_id){
        /*
             * 初始化订单数据
             * */
        $goods = new Goods();
        $goods_row = $goods->findOne(['goods_id'=>$goods_id]);
        $asgoods = array(
            'order_id'     => $order_id,    //订单状态
            'goods_id'  => $goods_id,    //收货状态
            'goods_name'        =>  $goods_row['goods_name'],  //支付状态
            'goods_sn'           =>  $goods_row['goods_sn'],  //发货状态
            'goods_number'           =>  1, //发货状态名称
            'market_price'           =>  $goods_row['market_price'],  //支付方式
            'goods_price'           => $goods_row['shop_price'],    //支付方式说明
            'is_real'           =>  1,  //发货详情
            'goods_attr'           =>  '',
        );
        return $asgoods;

    }

    /**
     * 得到新订单号
     *
     * @return string
     */
    function get_order_sn() {
        /* 选择一个随机的方案 */
        $order= new OrderInfo();
        mt_srand((double) microtime() * 1000000);
        $sn = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        /* 检查订单号是否重复 */
        $is_existed = $order->findOne(['order_sn'=>$sn]);
        if ($is_existed['order_id'] > 0) {
            $sn = get_order_sn();
        }
        return $sn;
    }
}
