<?php
namespace frontend\controllers;

use frontend\models\ZmPositionPoints;
use Yii;
use frontend\models\EUsers;
use frontend\models\Income;
use frontend\models\ZmIncome;
use frontend\models\Getamount;
use frontend\models\ZmTotal;
use frontend\models\ZmLovefund;
use frontend\models\ZmTdgjj;
use frontend\models\ZmFuxiao;
use frontend\models\ZmTravel;
use frontend\models\ZmWeek;
use yii\data\Pagination;
use common\models\User;
use Exception;

/**
 * 积分管理控制器  
 */
class IntegralController extends BaseController
{
    /**
     * 积分记录
     * @param number $limit
     * @param number $count
     */
    public function actionIndex($limit = 15, $count = 1000)
    {
        $zmtotal = new ZmTotal();
        $obj      = $zmtotal->find()->where(['zm_total.userid'=>UID])->andWhere(['NOT', ['zm_total.scount' => null]])->leftJoin("zm_week","zm_week.scount=zm_total.scount")->groupBy('zm_week.scount')->select(['zm_week.*','zm_total.*','sum(zm_total.bonus) as zong']);
        
        /* 获取总记录数 */
        if(Yii::$app->request->post('count')){
            return [ 'count' => $obj->count() ];
        }
        /* 按分页获取列表 */
        $page    = new Pagination(['totalCount' => $count]);
        $page->defaultPageSize = $limit == 15?15:30;
        $model   = $obj->orderBy('addtime desc')->offset($page->offset)->limit($page->limit)->asArray()->all();
        $page->params = ['list'=>'all'];
        /* 求集列表日期，获取分类别数据 */
        /*$addtime = $dls = [];
        $types   = ['销售积分'=>'xiaoshou', '管理积分'=>'guanli','绩效积分'=>'jixiao', '邀请积分'=>'yaoqing', '爱心基金'=>'aixin'];
        $types_s = array( 'xiaoshou'=>0, 'guanli'=>0, 'jixiao'=>0, 'yaoqing'=>0, 'aixin'=>0, 'sum'=>0, 'shui'=>0 );
        
        foreach ($model as $k=>$vs){
            $addtime[$k] = $vs['adddate'];
        }
        $income     = new Income();
        $incomerow  =  $income->find()->select('adddate,types,amount')->where(['userid'=>Yii::$app->session->get("loginname"),'types' => array_flip($types)])->andWhere(['in','adddate',$addtime])->asArray()->all();
        
        foreach ($incomerow as $key=>$v){
            $ts = $v['types'];
            $ae = $v['adddate'];
            $at = $v['amount'];
            $dls[$ae][$types[$ts]] = isset($dls[$ae][$types[$ts]]) ? $dls[$ae][$types[$ts]] + ($at>0?$at*1:0) : ($at>0?$at*1:0);
            $dls[$ae]['sum']       = isset($dls[$ae]['sum'])? $dls[$ae]['sum'] + $at : $at;
            $dls[$ae]['shui']      = ($dls[$ae]['sum'] - $dls[$ae]['sum']*0.94);
        }
        
        foreach ($model as $k=>$vo){
            $model[$k] = array_merge(( isset($dls[$vo['adddate']])?array_merge($types_s,$dls[$vo['adddate']]):$types_s ),$model[$k]);
        }*/
        if(Yii::$app->request->isAjax){
            return [ 'html' => $this->render('recordList',['model' => $model]), 'page' => $page ];
        }else{
            return $this->render('record', [ 'model' => $model, 'page' => $page ]);
        }
        
    }
    
    /**
     * 积分明细详情
     * @param number $limit
     * @param number $count
     * @return number[]|string[]|string
     */
    public function actionDetailslist2($limit = 15, $count = 1000)
    {
    	$p_type = Yii::$app->request->get("type");/*类型*/
    	$p_scount= Yii::$app->request->get("scount");/*周期*/
    	if($p_scount<9)
    		return $this->msg('请查询第9期以后的信息!',['icon'=>0,'url'=>'/integral/index']);    	
    	
    	$ZmWeek= new ZmWeek();
    	$zmwk=$ZmWeek->find()->where(['scount'=>$p_scount])->asArray()->one(); 
    	
    	if($p_type<4)
    	{ 
    		$ZmTdgjj= new ZmTdgjj();
    		$obj      = $ZmTdgjj->find()->alias('zmp')->where(['userid'=>UID])
    		->andWhere(['type'=>$p_type])
    		->andWhere(['and', 'zmp.addtime>'.$zmwk['stime'],'zmp.addtime<'.$zmwk['etime']])
    		->leftJoin("users","users.id=zmp.reason")
    		->select('users.loginname,zmp.pre,zmp.points,zmp.addtime');
    	 }
    	else 
    	{
    		$ZmTdgjj= new ZmPositionPoints();
    		$obj      = $ZmTdgjj->find()->alias('zmp')->where(['userid'=>UID])
    		->andWhere(['zmp.type'=>($p_type==4?0:1)])
    		->andWhere(['zmp.status'=>3])
    		->andWhere(['between', 'zmp.addtime',$zmwk['stime'],$zmwk['etime']])
    		->leftJoin("users","users.id=zmp.reason")
    		->select('users.loginname,zmp.pre,zmp.points,zmp.addtime');
    	} 
    	/* 获取总记录数 */
    	if(Yii::$app->request->post('count')){
    		return [ 'count' => $obj->count() ];
    	}
    	/* 按分页获取列表 */
    	$page    = new Pagination([
    			'totalCount'      => $count,
    			'defaultPageSize' => (intval($limit) < 15 ||$limit == 15?15:30),
    			'params'          => ['list'=>'all'],
    			'page'            => (Yii::$app->request->get('page')?Yii::$app->request->get('page'):1)-1,
    	]);
    	 
    	$model   = $obj->orderBy('zmp.addtime desc')->orderBy('users.loginname')->offset($page->offset)->limit($page->limit)->asArray()->all();
    	 
    	if(Yii::$app->request->isAjax){
    		return [ 'html' => $this->render('detailslists2',['model' => $model]), 
    				'page' => $page,
    				'p_type'=>$p_type,
    				'p_scount'=>$p_scount];
    	}else{
    		return $this->render('detailslist2', [ 'model' => $model, 
    				'page' => $page,
    				'p_type'=>$p_type,
    				'p_scount'=>$p_scount]);
    	}
    }
    

    /**
     * 积分明细
     * @param number $limit
     * @param number $count
     */
    public function actionDetails()
    {
        $love    = new ZmLovefund();
        $tdg     = new ZmTdgjj();
	    $zmtotal = new ZmTotal();
	    $fuxiao  = new ZmFuxiao();
	    $lvyou   = new ZmTravel();
	    $jb      = new ZmPositionPoints();
	    $shui = 0;
	    $model   = [];
	    $where = $zmtotal->find()->from('zm_total as t')->leftJoin("zm_week as w","w.scount=t.scount")->where(['t.userid'=>UID]);
	    if(Yii::$app->request->get("scount")){
	        $where = $where->andWhere(['=','t.scount',intval(Yii::$app->request->get("scount"))]);
	    }
	    $total = $where->andWhere(['>','t.scount',0])->select(['t.*','w.stime','w.etime'])->orderBy("t.scount desc")->asArray()->one();
	    
	    $stime = $total['stime']-1;
	    $etime = $total['etime']+1;
	    
	    /** 取最新的周期*/
	    $model['alllove'] = $love->find()->where(['userid'=>UID])->andWhere(['>','addtime',$stime])
		       ->andWhere(['<','addtime',$etime])->andWhere(['status'=>'3'])->select("sum(love) as zong")->asArray()->one();
	    $model['allfx']   = $fuxiao->find()->where(['userid'=>UID])->andWhere(['>','addtime',$stime])->andWhere(['=','scount',$total['scount']])
		       ->andWhere(['status'=>'1'])->select("sum(amount) as zong")->asArray()->one();
	    $model['allly']   = $lvyou->find()->where(['userid'=>UID])->andWhere(['>','addtime',$stime])
	           ->andWhere(['<','addtime',$etime])->andWhere(['status'=>'1'])->select("sum(points) as zong")->asArray()->one();
	    $model['alljb']   = $jb->find()->where(['userid'=>UID])->andWhere(['>','addtime',$stime])
	           ->andWhere(['<','addtime',$etime])->andWhere(['=','type',0])->andWhere(['=','status',3])->select("type,sum(bonus) as zong,sum(points*pre*0.08) as shui")->asArray()->one();
	    $model['alljc']   = $jb->find()->where(['userid'=>UID])->andWhere(['>','addtime',$stime])
		    ->andWhere(['<','addtime',$etime])->andWhere(['=','type',1])->andWhere(['=','status',3])->select("type,sum(bonus) as zong1,sum(points*pre*0.08) as shui")->asArray()->one();
	    if(empty($model['alljc']['zong1'])){
		    $model['alljc']['zong1'] = 0;
	    }
	    $shui += $model['alljc']['shui'];
	    $shui += $model['alljb']['shui'];
	    $model['alljc']['zong'] = 0;
	    if(intval($total['position'])-intval($model['alljb']['zong']) > 0){
	        $model['alljc']['zong'] = intval($total['position'])-intval($model['alljb']['zong']);
	    }
	    $tdglist    =   $tdg->find()->where(['userid'=>UID])->andWhere(['>','addtime',$stime])
		    ->andWhere(['<','addtime',$etime])
		    ->andWhere(['in','status',[1,2,3]])
		    ->groupBy('type')
		    ->select("type,sum(bonus) as zong,sum(points*pre*0.08) as shui")
		    ->asArray()->all();
	    if($model['allfx']['zong']>=300){
		    $model['allfxzf']['zong'] = $total['tdgjj'];
	    }else{
		    $model['allfxzf']['zong'] = 0;
	    }
        foreach ($tdglist as $val){
        	if($val['type']==1){
		        $model['alltj']['zong'] = $val['zong'];
		        $shui += $val['shui'];
	        }
	        if($val['type']==2){
		        $model['allxs']['zong'] = $val['zong'];
		        $shui += $val['shui'];
	        }
	        if($val['type']==3){
		        $model['allgl']['zong'] = $val['zong'];
		        $shui += $val['shui'];
	        }
	        if($model['allfx']['zong']>=300) {
		        $model['allfxzf']['zong'] -= $val['zong'];
	        }
        }
        $zong = 0;
        foreach ($model as $key=>$value){
        	if(empty($value['zong'])){
		        $model[$key]['zong'] = 0;
	        }
        }
	
	    /* 按分页获取列表 */
	    if($total['scount']==5){
		    return $this->render('details2', [ 'model' => $model,'total' => $total]);
	    }
	    if($total['scount']==6){
		    return $this->render('details1', [ 'model' => $model,'total' => $total]);
	    }
	    if($total['scount']>=10){
	    	return $this->render('details3', [ 'model' => $model,'total' => $total,'shui' => $shui]);
	    }
	    return $this->render('details', [ 'model' => $model,'total' => $total]);
	
	
    }

    /**
     * 积分兑换&提现
     * @return number[]|string[]|NULL[]|string
     */
    public function actionExchange($type = 0)
    {
        if($this->verify() !== true){
            return self::$vfi;
        }
        $p_type = Yii::$app->request->get("type");
        $type = !empty($p_type)?$p_type:0;
        $userinfo = User::findIdentity(UID);
        if((empty($userinfo['bank'])||empty($userinfo['bankno'])||empty($userinfo['bankname']))&& $type == 1 ){
            return $this->msg('请完善个人信息后重试!',['icon'=>0,'url'=>'/user/edit']);
        }
        $userinfo['amount'] = $this->decpoint($userinfo['amount']);
        $getamount = new Getamount();
        return $this->render('exchange',[
            'model' => $getamount,
            'user'  => $userinfo,
            'type'  => intval($type),
        ]);
    }
    
    /**
     * 确认积分兑换
     */
    public function actionConfexchange($type = 0){
        
        if($this->verify() !== true){
            return self::$vfi;
        }
        $msg = "兑换";
        if(Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('Getamount');
            if(Yii::$app->request->get("type")==1){
	            $msg = "提现";
	            $mobile_code = Yii::$app->request->post('mobile_code');
                if(empty($mobile_code)){
                    return ['status'=>2,'msg'=>'验证码不能为空！'];
                }else if($mobile_code!=Yii::$app->session->get("mobile_code")){
                    return ['status'=>2,'msg'=>'验证码不正确,请重新输入！'];
                }
            }
            if(!isset($post['amount']) || ($post['amount']%50)!=0){
                return ['status'=>2,'msg'=>'兑换金额需为50的倍数！'];
            }
            if(!isset($post['states'])){
                return ['status'=>2,'msg'=>'模式不存在！'];
            }
            $post['amount'] = intval($post['amount']);
            $post['states'] = intval($post['states']);
            
            $userinfo = User::findIdentity(UID);
            if($post['amount'] > $userinfo->amount){
                return ['status'=>2,'msg'=>'转账金额不能大于当前积分余额！'];
            }
            if($userinfo->amount-$userinfo->djamount-$post['amount']<0){
                return ['status'=>2,'msg'=>'您的账号部分资金已被冻结，无法转出！'];
            }
            $getamount = new Getamount();
            /* 验证提交信息是否完整 */
            if (!$getamount->load(Yii::$app->request->post()) ) {
                return ['status'=>2,'msg'=>'提交信息缺失！'];
            }
            $getamount->userid     = $userinfo->loginname;
            $getamount->get_amount = $post['amount'];
            if($post['states'] == 1 && Yii::$app->request->get("type")==1){
                $getamount->bank       = $userinfo['bank'];
                $getamount->bankno     = $userinfo['bankno'];
                $getamount->bankuser   = $userinfo['bankname'];
                $getamount->states     = 0;
                $getamount->get_amount *= 0.98;
            }else if($post['states'] == 8 && Yii::$app->request->get("type")==0){
                $ecsuinfo = EUsers::findOne(['user_name'=>$userinfo->loginname]);
            }else{
                return ['status'=>2,'msg'=>'模式不存在！'];
            }
            $urls   = '/integral/exlist/';
            $sess   = ['status'=>2,'msg'=>$msg.'失败'];
            $type   = 8;
            $income = new ZmIncome();
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if(!$getamount->save()){
                    $err = $getamount->getErrors();
                    list($first_key, $first) = (reset($err) ? each($err) : each($err));
                    $transaction->rollback();
                    return ['status'=>2,'msg'=>$first['0']];
                }else{
                    /** 调整兑换减少积分*/
                    $rets = $userinfo->updateCounters(['amount'=>$post['amount']*-1]);
                    if(empty($rets) || $rets === false){
                        $transaction->rollback();
                        return $sess;
                    }
                    /** 兑换到商城调整商城余额*/
                    if($post['states'] == 8){
                        $rets = $ecsuinfo->updateCounters(['user_money'=>$post['amount']]);
                        if(empty($rets) || $rets === false){
                            $transaction->rollback();
                            return $sess;
                        }
                        $urls.= '?sval=1';
                        $type = 7;
                    }
                    /** 添加兑换记录*/
                    $rets = $income->addIncome($userinfo->id,$post['amount']*-1,$userinfo->amount,$type);
                    if(empty($rets) || $rets === false){
                        $transaction->rollback();
                        return $sess;
                    }
                    /** 提交事务会真正的执行数据库操作*/
                    $transaction->commit();
                    return ['status'=>1,'msg'=>$msg.'成功','url'=>$this->urlTo($urls),'sx'=>1];
                }
            }catch (Exception $e) {
                /** 如果操作失败, 数据回滚*/
                $transaction->rollback();
                return $sess;
            }
        }
        
        return '你在找什么，<a href="/">返回首页</a>';
    }
    
    /**
     * 积分兑换&提现记录
     * @param number $limit
     * @param number $count
     * @param number $states
     * @return NULL|number[]|string[]|string[]|\yii\data\Pagination[]|string
     */
    public function actionExlist($limit = 15, $count = 1000)
    {
        if($this->verify() !== true){
            return self::$vfi;
        }
        
        $getamount = new Getamount();
        $obj = $getamount->find()->where('userid=:userid',[':userid'=>Yii::$app->session->get("loginname")])->andWhere(['>','addtimes',Yii::$app->session->get('addtime')]);
        
        $temp = 'exlist';
        if(Yii::$app->request->get('sval')){
            $obj->andWhere(['states'=>8]);
            $temp = 'extract';
        }else{
            $obj->andWhere(['states'=>['-1',0,1]]);
        }
        
        /* 获取总记录数 */
        if(Yii::$app->request->post('count')){
            return [ 'count' => $obj->count() ];
        }
        /* 按分页获取列表 */
        $page    = new Pagination(['totalCount' => $count]);
        $page->defaultPageSize = $limit == 15?15:30;
        $model   = $obj->orderBy('id desc')->offset($page->offset)->limit($page->limit)->asArray()->all();
        $page->params = ['list'=>'all'];
        if(Yii::$app->request->isAjax){
            return [ 'html' => $this->render($temp.'List',['model' => $model]), 'page' => $page ];
        }else{
            return $this->render($temp, [ 'model' => $model, 'page' => $page ]);
        }
    }


}
