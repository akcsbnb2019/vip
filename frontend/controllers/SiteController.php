<?php
namespace frontend\controllers;

use frontend\models\Income;
use frontend\models\UJiangli;
use frontend\models\Yuanshigulist;
use frontend\models\Uso;
use frontend\models\UsersLog;
use Yii;
use common\models\LoginForm;
use frontend\models\Stocks;
use yii\db\Expression;
use yii\web\User;


/**
 * 登录控制器
 */
class SiteController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * 默认页面 登录
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if(isset($_GET['ie'])){
            //pr('ie9/ie8/ie7/ie6暂停使用');
            yii::$app->setBasePath(__DIR__ . '/../vold');
            Yii::$app->session->set('is-ie',true);
        }
        
        $model = new LoginForm();
        $this->layout = 'login';
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    
    /**
     * 登录验证
     * @return number[]|string[]|number[]|string[]|NULL[]|\yii\web\Response
     */
    public function actionLogin()
    {
        if(Yii::$app->request->isAjax){
            $model = new LoginForm();
            $post = Yii::$app->request->post();
            if(preg_match("/^[a-zA-Z\d-_\.]*$/", $post['LoginForm']['username'], $toname)){
                $post['LoginForm']['username'] = implode(',',$toname);
                //重新赋值后需要用此方法更新post数据,
                Yii::$app->request->setBodyParams($post);
            }else{
                return ['status'=>2,'msg'=>'用户名格式不正确'];
            }
	        $userlog = new UsersLog();
	        if ($model->load(Yii::$app->request->post()) && $model->login()) {
                $post = Yii::$app->request->post('LoginForm');
                Yii::$app->session->set('md',$this->checkPassword($post['password']));
                $model->setSession();
                /*废除奖励
                $this->chackjiangli($post['username']);*/
                $this->add_login_count($post['username']);
		        $userlog->loginLog($post['username'],'登录成功!',Yii::$app->request->userIP);
                return ['status'=>6,'msg'=>'登录成功','url'=> $this->urlTo('/index')];
            } else {
		        $userlog->loginLog($post['LoginForm']['username'],'登录失败!',Yii::$app->request->userIP);
		        return ['status'=>2,'msg'=>'登录失败'];
            }
        }else{
            return $this->goBack($this->urlTo('/site'));
        }
    }
    
    /**
     * 使用说明:updateAll 更新内容  更新条件
     * @param unknown $loginname
     */
    function add_login_count($loginname){
        $user = new Uso();
        $user->updateAll(['login_time'=>date("Y-m-d H:i:s",time()+28800),'login_count'=>new Expression('login_count+' . 1),'login_ip'=>Yii::$app->request->userIP],['loginname'=>$loginname]);
        
        return true;
    }
    
    /**
     * 检查密码复杂度
     */
    public function checkPassword($pwd) {
        if ($pwd == null) {
            return 0;
        }
        $pwd = trim($pwd);
        if (!strlen($pwd) >= 6) {//必须大于6个字符
            return 1;
        }
        if (preg_match("/^[0-9]+$/", $pwd)) { //必须含有特殊字符
            return 1;
        }
        if (preg_match("/^[a-zA-Z]+$/", $pwd)) {
            return 1;
        }
        if (preg_match("/^[0-9A-Za-z]+$/", $pwd)) {
            return 2;
        }
        return 3;
    }
    

    function chackjiangli($loginname)
    {
        $income = new Income();
        $zong = $income->find()->where("userid=:userid",[':userid'=>$loginname])->andWhere(['in','types',['销售积分','管理积分','绩效积分','邀请积分']])->andWhere("addtime >= '2017-02-14 00:00:00'")->select(['amount'=>'SUM(amount)'])->one();
//        pr($zong);
        $zong = !empty($zong['amount'])?$zong['amount']:0;
        $user = Uso::findOne(['loginname'=>$loginname]);
        if($zong<510000){
            $u_zong = $income->find()->where("userid=:userid",[':userid'=>$loginname])->andWhere(['in','types',['销售积分','管理积分','绩效积分','邀请积分']])->select(['amount'=>'SUM(amount)'])->one();
            $u_zong = !empty($u_zong['amount'])?$u_zong['amount']:0;
            if($u_zong>=510000){
                if($u_zong<2300000){
                    if($user['isjiangli']==0){
                        if($user['yuanshigu']>0){
                            $ujiangli = new UJiangli();
                            $ujiangli->username = $loginname;
                            $ujiangli->bcstock = 5000;
                            $ujiangli->yystock = $user['yuanshigu'];
                            $ujiangli->zong = $user['yuanshigu']+5000;
                            $ujiangli->adddate = date("Y-d-m",time());
                            $ujiangli->addtime = date("Y-d-m H:i:s",time());
                            $arr = ['0'=>0,'1'=>5000,'2'=>23000];
                            $transaction = Yii::$app->db->beginTransaction();
                            try{
                                if(!$ujiangli->save()){
                                    $err = $ujiangli->getErrors();
                                    list($first_key, $first) = (reset($err) ? each($err) : each($err));
                                }else{
                                    $user->updateCounters(['isjiangli'=>1,'yuanshigu'=>intval(5000)]);
                                    $yuanshigulist = new Yuanshigulist();
                                    $ysglistinfo = $yuanshigulist->find()->where("loginname=:loginname",[':loginname'=>$loginname])->one();
                                    if(!empty($ysglistinfo['id'])){
                                        $yuanshiup = $ysglistinfo->updateCounters(['yuanshigu'=>intval(5000),'jiangliyuanshigu'=>intval(5000)]);
                                    }else{
                                        $yuanshigulist->loginname = $loginname;
                                        $yuanshigulist->yuanshigu = $user['yuanshigu'];
                                        $yuanshigulist->jiangliyuanshigu = $user['yuanshigu']-$user['ffyuanshigu'];
                                        $yuanshigulist->aixinyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']];
                                        $yuanshigulist->goumaiyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']]-$user['ffyuanshigu'];
                                        $yuanshiup = $yuanshigulist->save();

                                    }

                                    if($yuanshiup){
                                        $transaction->commit();//提交事务会真正的执行数据库操作
                                        return true;
                                    }else{
                                        $transaction->rollback();
                                        return false;
                                    }
                                }
                            }catch (Exception $e) {
                                $transaction->rollback();//如果操作失败, 数据回滚
                                return false;
                            }

                        }
                    }
                }else{
                    if($user['isjiangli']==1){
                        if($user['yuanshigu']>0){
                            $ujiangli = new UJiangli();
                            $ujiangli->username = $loginname;
                            $ujiangli->bcstock = 18000;
                            $ujiangli->yystock = $user['yuanshigu'];
                            $ujiangli->zong = $user['yuanshigu']+18000;
                            $ujiangli->adddate = date("Y-d-m",time());
                            $ujiangli->addtime = date("Y-d-m H:i:s",time());
                            $arr = ['0'=>0,'1'=>5000,'2'=>23000];
                            $transaction = Yii::$app->db->beginTransaction();
                            try{
                                if(!$ujiangli->save()){
                                    $err = $ujiangli->getErrors();
                                    list($first_key, $first) = (reset($err) ? each($err) : each($err));
                                }else{
                                    $user->updateCounters(['isjiangli'=>2,'yuanshigu'=>intval(18000)]);
                                    $yuanshigulist = new Yuanshigulist();
                                    $ysglistinfo = $yuanshigulist->find()->where("loginname=:loginname",[':loginname'=>$loginname])->one();
                                    if(!empty($ysglistinfo['id'])){
                                        $yuanshiup = $ysglistinfo->updateCounters(['yuanshigu'=>intval(18000),'jiangliyuanshigu'=>intval(18000)]);
                                    }else{
                                        $yuanshigulist->loginname = $loginname;
                                        $yuanshigulist->yuanshigu = $user['yuanshigu'];
                                        $yuanshigulist->jiangliyuanshigu = $user['yuanshigu']-$user['ffyuanshigu'];
                                        $yuanshigulist->aixinyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']];
                                        $yuanshigulist->goumaiyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']]-$user['ffyuanshigu'];
                                        $yuanshiup = $yuanshigulist->save();

                                    }

                                    if($yuanshiup){
                                        $transaction->commit();//提交事务会真正的执行数据库操作
                                        return true;
                                    }else{
                                        $transaction->rollback();
                                        return false;
                                    }
                                }
                            }catch (Exception $e) {
                                $transaction->rollback();//如果操作失败, 数据回滚
                                return false;
                            }

                        }
                    }else if($user['isjiangli']==0){
                        if($user['yuanshigu']>0){
                            $ujiangli = new UJiangli();
                            $ujiangli->username = $loginname;
                            $ujiangli->bcstock = 23000;
                            $ujiangli->yystock = $user['yuanshigu'];
                            $ujiangli->zong = $user['yuanshigu']+23000;
                            $ujiangli->adddate = date("Y-d-m",time());
                            $ujiangli->addtime = date("Y-d-m H:i:s",time());
                            $arr = ['0'=>0,'1'=>5000,'2'=>23000];
                            $transaction = Yii::$app->db->beginTransaction();
                            try{
                                if(!$ujiangli->save()){
                                    $err = $ujiangli->getErrors();
                                    list($first_key, $first) = (reset($err) ? each($err) : each($err));
                                }else{
                                    $user->updateCounters(['isjiangli'=>2,'yuanshigu'=>intval(23000)]);
                                    $yuanshigulist = new Yuanshigulist();
                                    $ysglistinfo = $yuanshigulist->find()->where("loginname=:loginname",[':loginname'=>$loginname])->one();
                                    if(!empty($ysglistinfo['id'])){
                                        $yuanshiup = $ysglistinfo->updateCounters(['yuanshigu'=>intval(23000),'jiangliyuanshigu'=>intval(23000)]);
                                    }else{
                                        $yuanshigulist->loginname = $loginname;
                                        $yuanshigulist->yuanshigu = $user['yuanshigu'];
                                        $yuanshigulist->jiangliyuanshigu = $user['yuanshigu']-$user['ffyuanshigu'];
                                        $yuanshigulist->aixinyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']];
                                        $yuanshigulist->goumaiyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']]-$user['ffyuanshigu'];
                                        $yuanshiup = $yuanshigulist->save();

                                    }

                                    if($yuanshiup){
                                        $transaction->commit();//提交事务会真正的执行数据库操作
                                        return true;
                                    }else{
                                        $transaction->rollback();
                                        return false;
                                    }
                                }
                            }catch (Exception $e) {
                                $transaction->rollback();//如果操作失败, 数据回滚
                                return false;
                            }

                        }
                    }
                }
            }else{
                return false;
            }
        }elseif ($zong>510000&&$zong<2300000){

            $u_zong = $income->find()->where("userid=:userid",[':userid'=>$loginname])->andWhere(['in','types',['销售积分','管理积分','绩效积分','邀请积分']])->select(['amount'=>'SUM(amount)'])->one();
            $u_zong = !empty($u_zong['amount'])?$u_zong['amount']:0;
            if($u_zong>=510000){
                if($u_zong<2300000){
                    if($user['isjiangli']==0){
                        if($user['yuanshigu']>0){
                            $ujiangli = new UJiangli();
                            $ujiangli->username = $loginname;
                            $ujiangli->bcstock = 5000;
                            $ujiangli->yystock = $user['yuanshigu'];
                            $ujiangli->zong = $user['yuanshigu']+5000;
                            $ujiangli->adddate = date("Y-d-m",time());
                            $ujiangli->addtime = date("Y-d-m H:i:s",time());
                            $arr = ['0'=>0,'1'=>5000,'2'=>23000];
                            $transaction = Yii::$app->db->beginTransaction();
                            try{
                                if(!$ujiangli->save()){
                                    $err = $ujiangli->getErrors();
                                    list($first_key, $first) = (reset($err) ? each($err) : each($err));
                                }else{
                                    $user->updateCounters(['isjiangli'=>1,'yuanshigu'=>intval(5000)]);
                                    $yuanshigulist = new Yuanshigulist();
                                    $ysglistinfo = $yuanshigulist->find()->where("loginname=:loginname",[':loginname'=>$loginname])->one();
                                    if(!empty($ysglistinfo['id'])){
                                        $yuanshiup = $ysglistinfo->updateCounters(['yuanshigu'=>intval(5000),'jiangliyuanshigu'=>intval(5000)]);
                                    }else{
                                        $yuanshigulist->loginname = $loginname;
                                        $yuanshigulist->yuanshigu = $user['yuanshigu'];
                                        $yuanshigulist->jiangliyuanshigu = $user['yuanshigu']-$user['ffyuanshigu'];
                                        $yuanshigulist->aixinyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']];
                                        $yuanshigulist->goumaiyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']]-$user['ffyuanshigu'];
                                        $yuanshiup = $yuanshigulist->save();

                                    }

                                    if($yuanshiup){
                                        $transaction->commit();//提交事务会真正的执行数据库操作
                                        return true;
                                    }else{
                                        $transaction->rollback();
                                        return false;
                                    }
                                }
                            }catch (Exception $e) {
                                $transaction->rollback();//如果操作失败, 数据回滚
                                return false;
                            }

                        }
                    }
                }else{
                    if($user['isjiangli']==1){
                        if($user['yuanshigu']>0){
                            $ujiangli = new UJiangli();
                            $ujiangli->username = $loginname;
                            $ujiangli->bcstock = 18000;
                            $ujiangli->yystock = $user['yuanshigu'];
                            $ujiangli->zong = $user['yuanshigu']+18000;
                            $ujiangli->adddate = date("Y-d-m",time());
                            $ujiangli->addtime = date("Y-d-m H:i:s",time());
                            $arr = ['0'=>0,'1'=>5000,'2'=>23000];
                            $transaction = Yii::$app->db->beginTransaction();
                            try{
                                if(!$ujiangli->save()){
                                    $err = $ujiangli->getErrors();
                                    list($first_key, $first) = (reset($err) ? each($err) : each($err));
                                }else{
                                    $user->updateCounters(['isjiangli'=>2,'yuanshigu'=>intval(18000)]);
                                    $yuanshigulist = new Yuanshigulist();
                                    $ysglistinfo = $yuanshigulist->find()->where("loginname=:loginname",[':loginname'=>$loginname])->one();
                                    if(!empty($ysglistinfo['id'])){
                                        $yuanshiup = $ysglistinfo->updateCounters(['yuanshigu'=>intval(18000),'jiangliyuanshigu'=>intval(18000)]);
                                    }else{
                                        $yuanshigulist->loginname = $loginname;
                                        $yuanshigulist->yuanshigu = $user['yuanshigu'];
                                        $yuanshigulist->jiangliyuanshigu = $user['yuanshigu']-$user['ffyuanshigu'];
                                        $yuanshigulist->aixinyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']];
                                        $yuanshigulist->goumaiyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']]-$user['ffyuanshigu'];
                                        $yuanshiup = $yuanshigulist->save();

                                    }

                                    if($yuanshiup){
                                        $transaction->commit();//提交事务会真正的执行数据库操作
                                        return true;
                                    }else{
                                        $transaction->rollback();
                                        return false;
                                    }
                                }
                            }catch (Exception $e) {
                                $transaction->rollback();//如果操作失败, 数据回滚
                                return false;
                            }

                        }
                    }else if($user['isjiangli']==0){
                        if($user['yuanshigu']>0){
                            $ujiangli = new UJiangli();
                            $ujiangli->username = $loginname;
                            $ujiangli->bcstock = 23000;
                            $ujiangli->yystock = $user['yuanshigu'];
                            $ujiangli->zong = $user['yuanshigu']+23000;
                            $ujiangli->adddate = date("Y-d-m",time());
                            $ujiangli->addtime = date("Y-d-m H:i:s",time());
                            $arr = ['0'=>0,'1'=>5000,'2'=>23000];
                            $transaction = Yii::$app->db->beginTransaction();
                            try{
                                if(!$ujiangli->save()){
                                    $err = $ujiangli->getErrors();
                                    list($first_key, $first) = (reset($err) ? each($err) : each($err));
                                }else{
                                    $user->updateCounters(['isjiangli'=>2,'yuanshigu'=>intval(23000)]);
                                    $yuanshigulist = new Yuanshigulist();
                                    $ysglistinfo = $yuanshigulist->find()->where("loginname=:loginname",[':loginname'=>$loginname])->one();
                                    if(!empty($ysglistinfo['id'])){
                                        $yuanshiup = $ysglistinfo->updateCounters(['yuanshigu'=>intval(23000),'jiangliyuanshigu'=>intval(23000)]);
                                    }else{
                                        $yuanshigulist->loginname = $loginname;
                                        $yuanshigulist->yuanshigu = $user['yuanshigu'];
                                        $yuanshigulist->jiangliyuanshigu = $user['yuanshigu']-$user['ffyuanshigu'];
                                        $yuanshigulist->aixinyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']];
                                        $yuanshigulist->goumaiyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']]-$user['ffyuanshigu'];
                                        $yuanshiup = $yuanshigulist->save();

                                    }

                                    if($yuanshiup){
                                        $transaction->commit();//提交事务会真正的执行数据库操作
                                        return true;
                                    }else{
                                        $transaction->rollback();
                                        return false;
                                    }
                                }
                            }catch (Exception $e) {
                                $transaction->rollback();//如果操作失败, 数据回滚
                                return false;
                            }

                        }
                    }
                }
            }else{
                return false;
            }
        }else if($zong>=2300000){
            $u_zong = $income->find()->where("userid=:userid",[':userid'=>$loginname])->andWhere(['in','types',['销售积分','管理积分','绩效积分','邀请积分']])->select(['amount'=>'SUM(amount)'])->one();
            $u_zong = !empty($u_zong['amount'])?$u_zong['amount']:0;
            if($u_zong>=2300000){
                if($user['isjiangli']==1){
                    if($user['yuanshigu']>0){
                        $ujiangli = new UJiangli();
                        $ujiangli->username = $loginname;
                        $ujiangli->bcstock = 18000;
                        $ujiangli->yystock = $user['yuanshigu'];
                        $ujiangli->zong = $user['yuanshigu']+18000;
                        $ujiangli->adddate = date("Y-d-m",time());
                        $ujiangli->addtime = date("Y-d-m H:i:s",time());
                        $arr = ['0'=>0,'1'=>5000,'2'=>23000];
                        $transaction = Yii::$app->db->beginTransaction();
                        try{
                            if(!$ujiangli->save()){
                                $err = $ujiangli->getErrors();
                                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                            }else{
                                $user->updateCounters(['isjiangli'=>2,'yuanshigu'=>intval(18000)]);
                                $yuanshigulist = new Yuanshigulist();
                                $ysglistinfo = $yuanshigulist->find()->where("loginname=:loginname",[':loginname'=>$loginname])->one();
                                if(!empty($ysglistinfo['id'])){
                                    $yuanshiup = $ysglistinfo->updateCounters(['yuanshigu'=>intval(18000),'jiangliyuanshigu'=>intval(18000)]);
                                }else{
                                    $yuanshigulist->loginname = $loginname;
                                    $yuanshigulist->yuanshigu = $user['yuanshigu'];
                                    $yuanshigulist->jiangliyuanshigu = $user['yuanshigu']-$user['ffyuanshigu'];
                                    $yuanshigulist->aixinyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']];
                                    $yuanshigulist->goumaiyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']]-$user['ffyuanshigu'];
                                    $yuanshiup = $yuanshigulist->save();

                                }

                                if($yuanshiup){
                                    $transaction->commit();//提交事务会真正的执行数据库操作
                                    return true;
                                }else{
                                    $transaction->rollback();
                                    return false;
                                }
                            }
                        }catch (Exception $e) {
                            $transaction->rollback();//如果操作失败, 数据回滚
                            return false;
                        }

                    }
                }else if($user['isjiangli']==0){
                    if($user['yuanshigu']>0){
                        $ujiangli = new UJiangli();
                        $ujiangli->username = $loginname;
                        $ujiangli->bcstock = 23000;
                        $ujiangli->yystock = $user['yuanshigu'];
                        $ujiangli->zong = $user['yuanshigu']+23000;
                        $ujiangli->adddate = date("Y-d-m",time());
                        $ujiangli->addtime = date("Y-d-m H:i:s",time());
                        $arr = ['0'=>0,'1'=>5000,'2'=>23000];
                        $transaction = Yii::$app->db->beginTransaction();
                        try{
                            if(!$ujiangli->save()){
                                $err = $ujiangli->getErrors();
                                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                            }else{
                                $user->updateCounters(['isjiangli'=>2,'yuanshigu'=>intval(23000)]);
                                $yuanshigulist = new Yuanshigulist();
                                $ysglistinfo = $yuanshigulist->find()->where("loginname=:loginname",[':loginname'=>$loginname])->one();
                                if(!empty($ysglistinfo['id'])){
                                    $yuanshiup = $ysglistinfo->updateCounters(['yuanshigu'=>intval(23000),'jiangliyuanshigu'=>intval(23000)]);
                                }else{
                                    $yuanshigulist->loginname = $loginname;
                                    $yuanshigulist->yuanshigu = $user['yuanshigu'];
                                    $yuanshigulist->jiangliyuanshigu = $user['yuanshigu']-$user['ffyuanshigu'];
                                    $yuanshigulist->aixinyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']];
                                    $yuanshigulist->goumaiyuanshigu = $user['yuanshigu']-$arr[$user['isjiangli']]-$user['ffyuanshigu'];
                                    $yuanshiup = $yuanshigulist->save();

                                }

                                if($yuanshiup){
                                    $transaction->commit();//提交事务会真正的执行数据库操作
                                    return true;
                                }else{
                                    $transaction->rollback();
                                    return false;
                                }
                            }
                        }catch (Exception $e) {
                            $transaction->rollback();//如果操作失败, 数据回滚
                            return false;
                        }

                    }
                }
            }

        }else{
            return false;
        }

    }

    public function actionIndexs()
    {
        return $this->actionIndex();
    }
}
