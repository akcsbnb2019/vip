<?php
namespace frontend\controllers;

use frontend\models\EUsers;
use frontend\models\Income;
use frontend\models\Stocks;
use Yii;
use frontend\models\Guquanbuy;
use yii\data\Pagination;
use common\models\User;
use frontend\models\UJiangli;
use Exception;


/**
 * 返利兑换记录控制器
 */
class WeltareController extends BaseController
{

    /**
     * 福利兑换记录
     * @param number $limit
     * @param number $count
     * @return number[]|string[]|NULL[]|number[]|string[]|string[]|\yii\data\Pagination[]|string
     */
    public function actionIndex($limit = 15, $count = 1000)
    {
        if($this->verify() !== true){
            return self::$vfi;
        }

        $guquan = new Guquanbuy();
        $obj    = $guquan->find()->where('userid=:userid',[':userid'=>Yii::$app->session->get("loginname")])->andWhere(['>','addtimes',Yii::$app->session->get('addtime')]);

        /* 获取总记录数 */
        if(Yii::$app->request->post('count')){
            return [ 'count' => $obj->count() ];
        }
        $page = new Pagination(['totalCount' => $count]);
        $page->defaultPageSize = $limit == 15?15:30;
        $model = $obj->offset($page->offset)->limit($page->limit)->asArray()->select(['userid','amount','addtimes','states'])->all();
        $page->params = ['list'=>'all'];
        
        if(Yii::$app->request->isAjax){
            return [ 'html' => $this->render('lists',['model' => $model]), 'page' => $page ];
        }else{
            return $this->render('list',[ 'model' => $model, 'page' => $page]);
        }
    }

    /**
     * 分红记录
     * @param number $limit
     * @param number $count
     * @return number[]|string[]|NULL[]|number[]|string[]|string[]|\yii\data\Pagination[]|string
     */
    public function actionStockslog($limit = 15, $count = 1000)
    {
        if($this->verify() !== true){
            return self::$vfi;
        }
        
        $stocks = new Stocks();
        $obj    = $stocks->find()->where('username=:username',[':username'=>Yii::$app->session->get("loginname")])->andWhere(['>','addtime',Yii::$app->session->get('addtime')]);
        
        /* 获取总记录数 */
        if(Yii::$app->request->post('count')){
            return [ 'count' => $obj->count() ];
        }
        $page = new Pagination(['totalCount' => $count]);
        $page->defaultPageSize = $limit == 15?15:30;
        $model = $obj->offset($page->offset)->limit($page->limit)->asArray()->select(['username','stocks','addtime','adddate','bfje'])->all();
        $page->params = ['list'=>'all'];
        
        if(Yii::$app->request->isAjax){
            return [ 'html' => $this->render('stocksList',['model' => $model]), 'page' => $page ];
        }else{
            return $this->render('stockslog',[ 'model' => $model, 'page' => $page]);
        }
    }

    /**
     * 福利积分兑换
     *
     * @return mixed
     */

    public function actionExchange($type = 0)
    {
        /*
         * 验证二级密码
         * */
        if($this->verify() !== true){
            return self::$vfi;
        }
        $jiangli = array('0','5000','23000');
        $model = new Guquanbuy();
        $euser = new EUsers();
        $money = $euser->find()->where(['user_name'=>Yii::$app->session->get("loginname")])->select(['user_money'])->one();
        $user = new User();
        $row_user = $user->find()->where(['id'=>UID])->select(['yuanshigu','isjiangli','ffyuanshigu'])->one();
        //已经兑换的福利积分
        $yuanshigu = $row_user['yuanshigu']-$row_user['ffyuanshigu']-$jiangli[$row_user['isjiangli']];
        //兑换的最大福利积分
        $sql = "select sum(amount)/10 as zong from income where  userid='".Yii::$app->session->get("loginname")."' and types='股权基金'";
        $row_income = Yii::$app->db->createCommand($sql)->queryOne();

        if(!isset($row_income['zong']) || empty($row_income['zong']) || $yuanshigu>=$row_income['zong']){
            return $this->msg('您没有可兑换的福利积分!',['icon'=>0,'url'=>'/index']);
        }else{
            $maxysg = $row_income['zong']-$yuanshigu;
            if($maxysg>$money['user_money']/10){
                $maxysg = intval($money['user_money']/10/6)*6;
            }
        }

        return $this->render('stock',[
            'model' => $model,
            'max_money' => $money['user_money'],
            'maxysg' => $maxysg,
            'type'  => intval($type),
        ]);
    }

    public function actionConfexstock(){

        if($this->verify() !== true){
            return self::$vfi;
        }

        if(Yii::$app->request->isAjax) {
            $jiangli = array('0','5000','23000');
            $row_user = User::findOne(['id'=>UID]);
            $money = EUsers::findOne(['user_name'=>$row_user->loginname]);

            //已经兑换的福利积分
            $yuanshigu = $row_user['yuanshigu']-$row_user['ffyuanshigu']-$jiangli[$row_user['isjiangli']];
            //兑换的最大福利积分
            $sql = "select sum(amount)/10 as zong from income where  userid='".Yii::$app->session->get("loginname")."' and types='股权基金'";
            $row_income = Yii::$app->db->createCommand($sql)->queryOne();

            if(!isset($row_income['zong']) || empty($row_income['zong']) || $yuanshigu>=$row_income['zong']){
                return $this->msg('您没有可兑换的福利积分!',['icon'=>0,'url'=>'/index']);
            }else{
                $maxysg = $row_income['zong']-$yuanshigu;
                if($maxysg>$money['user_money']/10){
                    $maxysg = intval($money['user_money']/10/6)*6;
                }
            }
            $post = Yii::$app->request->post('Guquanbuy');
            if(!isset($post['amount']) || ($post['amount']%6)!=0){
                return ['status'=>2,'msg'=>'兑换福利积分需为6的倍数！'];
            }

            if(intval($post['amount']) > $maxysg){
                return ['status'=>2,'msg'=>'兑换福利积分不能大于当前可兑换福利积分数量！'];
            }

            $guquanbuy = new Guquanbuy();
            /* 验证提交信息是否完整 */
            if (!$guquanbuy->load(Yii::$app->request->post()) ) {
                return ['status'=>2,'msg'=>'提交信息缺失！'];
            }
            $guquanbuy->userid = $row_user->loginname;
            $guquanbuy->amount = intval($post['amount']);
            $guquanbuy->addtimes = date("Y-m-d H:i:s",time());
            $guquanbuy->states = 1;
            $sess = array();
            $urls = '/weltare/index';
            $transaction=Yii::$app->db->beginTransaction();
            try{
                if(!$guquanbuy->save()){
                    $err = $guquanbuy->getErrors();
                    list($first_key, $first) = (reset($err) ? each($err) : each($err));
                    $sess = ['status'=>2,'msg'=>$first['0']];
                }else{
                    $row_user->updateCounters(['yuanshigu'=>intval($post['amount'])*1]);
                    $rets   = $money->updateCounters(['user_money'=>$guquanbuy->amount*-10]);
                    if($rets){
                        $transaction->commit();//提交事务会真正的执行数据库操作
                        $sess = ['status'=>1,'msg'=>'兑换成功','url'=>$this->urlTo($urls)];
                    }else{
                        $transaction->rollback();
                    }
                }
            }catch (Exception $e) {
                $transaction->rollback();//如果操作失败, 数据回滚
                $sess = ['status'=>2,'msg'=>'兑换失败,请稍候重试'];

            }

            return $sess;
        }

        return '你在找什么，<a href="/">返回首页</a>';
    }
}
