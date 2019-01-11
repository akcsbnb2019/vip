<?php
namespace backend\controllers;

use backend\models\ZmPosition;
use backend\models\ZmAbsedit;
use Yii;
use common\models\User;
use backend\models\Users;
use backend\models\ChangeMoney;
use backend\models\ZmIncome;
use backend\models\AcountLog;
use frontend\models\Region;
use yii\data\Pagination;
use common\models\Identity;
use backend\models\ZmUprid as zmrid;
use backend\models\ZmPosition as zp;
use backend\models\ZmTotal;
use backend\models\ZmLovefund;
use backend\models\ZmPositionPoints;
use backend\models\ZmTdgjj;
use backend\models\ZmFuxiao;
use backend\models\ZmTravel;
use backend\models\ZmWeek;



/**
 * 用户管理控制器
 */
class UserController extends BaseController
{
    /** 
     * 普通会员列表
     * 
     * @return string
     */
    public function actionIndex($limit = 0, $count = 0,$level = '')
    {
        $rs    = Yii::$app->request;
        $user  = new User();
        $where = $user->find()->where(['>','states',-1]);
        
        /* 级别区分处理，非会员-会员-指定级别会员及代理类型区分 */
        if($rs->post('level') || $level == -1){
            if($level != -1){
                $level = $rs->post('level');
            }
            if($level == 10 ){
                $where->andWhere(['standardlevel' => 0]);
            }else if($level > 10 ){
                $where->andWhere(['dllevel' => (intval($level)-10)]);
            }else if($level > 0 ){
                $where->andWhere(['standardlevel' => intval($level)]);
            }else if($level == -1 ){
                $where->andWhere(['>','standardlevel',0]);
            }
        }
        
        /* 模糊查询 用户名&姓名 */
        if($rs->post('User')){
            $name     = $rs->post('User');
            if(isset($name['loginname'])){
                $truename = preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$name['loginname']) ? $name['loginname'] : false;
                
                if(!$truename && preg_match("/^[\x{4e00}-\x{9fa5}]+/u",$name['loginname'],$truename)){
                    $truename = implode('', $truename);
                }
                $name['loginname'] = str_replace($truename, '', $name['loginname']);
                
                if($truename){
                    $where->andWhere(" truename = :truename ",[':truename'=>$truename]);
                }
                if(!empty($name['loginname'])){
                    $where->andWhere(" loginname like :loginname ",[':loginname'=>"%$name[loginname]%"]);
                }
            }
            
        }
        
        /* 时间条件 */
        if($rs->post('addtime')){
            $where->andWhere(" addtime >= :addtime ",[':addtime'=>$rs->post('addtime')]);
        }
        if($rs->post('endtime')){
            $where->andWhere(" addtime <= :addtime ",[':addtime'=>$rs->post('endtime')]);
        }
        
        /* 分页设置 &每页显示多少条*/
        $page  = new Pagination([
            'totalCount' => (AJAX && $count ? $rs->post('count') : $where->count()),
        ]);
        $page->defaultPageSize = intval($limit)<10?10:($limit>30?30:intval($limit));
        $model = $where->orderBy('id desc')->offset($page->offset)->limit($page->limit)->asArray()->all();
        $page->params=array("list"=>'all');
        
        if(AJAX){
            $this->layout = 'kong';
            return [
                'html' => $this->render('list',[
                    'model' => $model,
                ]),
                'page' => $page ,
            ];
        }else{
            $this->layout = 'layui2';
            return $this->render('index',[
                'user' => $user,
                'model' => $model,
                'page' => $page,
                'level' => $level,
            ]);
        }
    }
    
    /**
     * 获取用户地区信息
     * @param unknown $shi
     * @param unknown $xian
     * @return number[][]|\yii\db\ActiveRecord[]
     */
    private function getRegion($shi,$xian)
    {
        $userreg = Yii::$app->db->createCommand("SELECT r1.*,r2.region_name as prname,r2.parent_id as ppid FROM {{%region}} as r1 left join {{%region}} as r2 on r1.parent_id=r2.region_id where r1.region_id in($shi,$xian)")->queryAll();
        
        /* 获取地区信息 */
        $data = [
            'reg' => [], 'arr' => [], 'pids' => [1],
        ];
        foreach ($userreg as $val){
            if($val['ppid'] == 1){
                $data['reg']['sheng'] = [
                    'name' => $val['prname'],
                    'id' => $val['ppid'],
                ];
                $data['reg']['shi'] = [
                    'name' => $val['region_name'],
                    'id' => $val['region_id'],
                ];
                $data['pids'][] = $val['ppid'];
            }else{
                $data['reg']['xian'] = [
                    'name' => $val['region_name'],
                    'id' => $val['ppid'],
                ];
            }
            $data['pids'][] = $val['parent_id'];
        }
        
        if($data['pids']){
            $data['pids'] = array_unique($data['pids']);
            $region = new Region();
            $regall = $region->find()->select('region_id,region_name,parent_id')->where(['in','parent_id',$data['pids']])->asArray()->all();
        
            foreach ($regall as $val){
                $data['arr'][$val['parent_id']][] = $val;
            }
        }
        
        return $data;
    }

    /**
     * 编辑用户信息
     *
     * @return string
     */
    public function actionEdit($id)
    {
        if(Yii::$app->request->isAjax){
            $User   = Yii::$app->request->post('Users');
            $modobj = new Users();
            /** 日志*/
            self::$logobj['desc'] = 'id:'.intval($User['id']);
            
            /* 验证提交信息是否完整 */
            if (!$modobj->load(Yii::$app->request->post()) ) {
                return ['s'=>0,'m'=>'提交信息缺失！'];
            }
            /* 自定义过滤 */
            if(!$modobj->validate()){
                $err = $modobj->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['s'=>0,'m'=>$first['0']];
            }
	        $uinfo = $modobj->find()->where(['id'=>$User['id']])->one();
	        if(!empty($User['pwd1'])) $uinfo->pwd1 = md5($User['pwd1']);
	        if(!empty($User['pwd2'])) $uinfo->pwd2 = md5($User['pwd2']);
	        if(!empty($User['identityid'])) $uinfo->identityid = $User['identityid'];
	        if(!empty($User['tel'])) $uinfo->tel = $User['tel'];
	        if(!empty($User['truename'])) $uinfo->truename = $User['truename'];
	        if(!empty($User['pic'])) $uinfo->pic = $User['pic'];
	        if(!empty($User['qq'])) $uinfo->qq = $User['qq'];
	        if(!empty($User['bank'])) $uinfo->bank = $User['bank'];
	        if(!empty($User['bankaddress'])) $uinfo->bankaddress = $User['bankaddress'];
	        if(!empty($User['bankname'])) $uinfo->bankname = $User['bankname'];
	        if(!empty($User['bankno'])) $uinfo->bankno = $User['bankno'];
	        if($User['bd']==0){
		        $uinfo->bd = 0;
		        $uinfo->dllevel = 0;
		        $uinfo->sheng= 0;
		        $uinfo->shi= 0;
		        $uinfo->xian= 0;
	        }else{
		        if(!empty($User['bd'])) $uinfo->bd = $User['bd'];
		        if(!empty($User['dllevel'])) $uinfo->dllevel = $User['dllevel'];
		        if(!empty($User['sheng'])) $uinfo->sheng= $User['sheng'];
		        if(!empty($User['shi'])) $uinfo->shi= $User['shi'];
		        if(!empty($User['xian'])) $uinfo->xian= $User['xian'];
	        }
	        
	        if(!empty($User['lockuser']) || $User['lockuser']==0) $uinfo->lockuser = $User['lockuser'];
	        if(!$uinfo->save()){
		        return ['s'=>0,'m'=>"修改失败"];
	        }
	
	        return ['s'=>2,'m'=>"修改成功"];
        }
        $user   = new User();
        $model  = $user->find()->where(['id'=>$id])->asArray()->one();
        /** 获取用户地区信息*/
        $region = new Region();
        $regall = $region->find()->select('region_id,region_name,parent_id')->where(['in','parent_id',[1]])->asArray()->all();
        /** 已存在地区*/
        $uregion = Yii::$app->db->createCommand("SELECT r1.region_id as id1,r1.region_name as rn1,r2.region_id as id2,r2.region_name as rn2,r3.region_id as id3,r3.region_name as rn3 FROM {{%region}} as r1 left join {{%region}} as r2 on r1.parent_id=r2.region_id left join {{%region}} as r3 on r2.parent_id=r3.region_id where r1.region_id = '".$model['xian']."'")->queryOne();
        $model['city'] = (isset($uregion['rn3'])?$uregion['rn3']:'').(isset($uregion['rn2'])?$uregion['rn2']:'').(isset($uregion['rn1'])?$uregion['rn1']:'');

        $this->layout = 'layui2s';
        return $this->render('edit', [
            'model' => $model,
            'region' => $regall,
        ]);
    }
	
	/**
	 * 编辑用户信息
	 *
	 * @return string
	 */
	public function actionObsedit($id)
	{
		if(Yii::$app->request->isAjax){
			$zmppost   = Yii::$app->request->post('ZmPosition');
			$modobj = new ZmPosition();
            /** 日志*/
            self::$logobj['desc'] = 'id:'.intval($zmppost['users_id']);
			/* 验证提交信息是否完整 */
			if (!$modobj->load(Yii::$app->request->post()) ) {
				return ['s'=>0,'m'=>'提交信息缺失！'];
			}
			/* 自定义过滤 */
			if(!$modobj->validate()){
				$err = $modobj->getErrors();
				list($first_key, $first) = (reset($err) ? each($err) : each($err));
				return ['s'=>0,'m'=>$first['0']];
			}
			$zmpinfo = $modobj->find()->where(['users_id'=>$zmppost['users_id']])->one();
			if(isset($zmppost['absolute']) && isset($zmppost['abs_area']) && $zmppost['abs_area']!=$zmpinfo->abs_area && $zmppost['absolute']!=$zmpinfo->absolute){
				$zma = new ZmAbsedit();
				$user = new Users();
				$uinfo = $user->find()->where(['id'=>$zmppost['users_id']])->one();
				if($zmppost['abs_area']==0){
					$zmppost['absolute'] = 0;
				}
				$zma -> users_id = $zmpinfo->users_id;
				$zma -> y_abs_area  =   $zmpinfo->abs_area;
				$zma -> y_absolute  =   $zmpinfo->absolute;
				$zma -> n_abs_area  =   $zmppost['abs_area'];
				$zma -> n_absolute  =   $zmppost['absolute'];
				$zma -> lallyeji    =   $uinfo->lallyeji;
				$zma -> rallyeji    =   $uinfo->rallyeji;
				$zma -> addtime     =   date("Y-m-d H:i:s",time());
				$zma -> types        =  $zmppost['abs_area']==0?0:1;
				if(!$zma->save()){
					return ['s'=>0,'m'=>"添加记录失败"];
				}
			}
			if(isset($zmppost['pan'])) $zmpinfo->pan = $zmppost['pan'];
			if(isset($zmppost['abs_area'])) $zmpinfo->abs_area = $zmppost['abs_area'];
			if(isset($zmppost['absolute'])) $zmppost['abs_area']==0?$zmpinfo->absolute = 0:$zmpinfo->absolute = $zmppost['absolute'];
			
			if(!$zmpinfo->save()){
				return ['s'=>0,'m'=>"修改失败"];
			}
			return ['s'=>2,'m'=>"修改成功"];
		}
		$zm_p   = new ZmPosition();
		$model  = $zm_p->find()->where(['users_id'=>$id])->asArray()->one();
		$this->layout = 'layui2';
		return $this->render('obsedit', [
			'model' => $model,
		]);
	}
	public function actionSeltotal($limit = 0, $count = 0){
		$rs    = Yii::$app->request;
		$id = Yii::$app->request->get('id');
		$zmtotal = new ZmTotal();
		$obj      = $zmtotal->find()->where(['zm_total.userid'=>$id])->andWhere(['NOT', ['zm_total.scount' => null]])->leftJoin("zm_week","zm_week.scount=zm_total.scount")->groupBy('zm_total.scount');
		
		$page  = new Pagination([
			'totalCount' => (AJAX && $count ? $rs->post('count') : $obj->count()),
		]);
		
		$page->defaultPageSize = intval($limit)<10?10:($limit>30?30:intval($limit));
		$model = $obj->orderBy('addtime desc')->select(['zm_week.*','zm_total.*','sum(zm_total.bonus) as zong'])->offset($page->offset)->limit($page->limit)->asArray()->all();
		$page->params=['list'=>'all'];
		if(AJAX){
			$this->layout = 'kong';
			return [ 'html' => $this->render('recordList',['model' => $model,'id'=>$id]), 'page' => $page ];
		}else{
			$this->layout = 'layui2';
			return $this->render('record', [ 'model' => $model,'id'=>$id, 'page' => $page ]);
		}
	}
	/**
	 * 积分明细详情
	 * @param number $limit
	 * @param number $count
	 * @return number[]|string[]|string
	 */
	public function actionDetailslist2($limit = 0, $count = 0)
	{
		$rs    = Yii::$app->request;
		$id = Yii::$app->request->get('id');
		$p_type = Yii::$app->request->get("type");/*类型*/
		$p_scount= Yii::$app->request->get("scount");/*周期*/
		if($p_scount<7)
			return $this->msg('请查询第9期以后的信息!',['icon'=>0,'url'=>'/integral/index']);
		
		$ZmWeek= new ZmWeek();
		$zmwk=$ZmWeek->find()->where(['scount'=>$p_scount])->asArray()->one();
		
		if($p_type<4)
		{
			$ZmTdgjj= new ZmTdgjj();
			$obj      = $ZmTdgjj->find()->alias('zmp')->where(['userid'=>$id])
				->andWhere(['type'=>$p_type])
				->andWhere(['and', 'zmp.addtime>'.$zmwk['stime'],'zmp.addtime<'.$zmwk['etime']])
				->leftJoin("users","users.id=zmp.reason")
				->select('users.loginname,zmp.pre,zmp.points,zmp.addtime');
		}
		else
		{
			$ZmTdgjj= new ZmPositionPoints();
			$obj      = $ZmTdgjj->find()->alias('zmp')->where(['userid'=>$id])
				->andWhere(['zmp.type'=>($p_type==4?0:1)])
				->andWhere(['zmp.status'=>3])
				->andWhere(['between', 'zmp.addtime',$zmwk['stime'],$zmwk['etime']])
				->leftJoin("users","users.id=zmp.reason")
				->select('users.loginname,zmp.pre,zmp.points,zmp.addtime');
		}
		$page  = new Pagination([
			'totalCount' => (AJAX && $count ? $rs->post('count') : $obj->count()),
		]);
		$page->defaultPageSize = intval($limit)<10?10:($limit>30?30:intval($limit));
		$model   = $obj->orderBy('zmp.addtime desc')->orderBy('users.loginname')->offset($page->offset)->limit($page->limit)->asArray()->all();
		$page->params=['list'=>'all'];
		if(AJAX){
			$this->layout = 'kong';
			return [ 'html' => $this->render('detailslists2',['model' => $model]),
				'page' => $page,
				'id' => $id,
				'p_type'=>$p_type,
				'p_scount'=>$p_scount];
		}else{
			$this->layout = 'layui2';
			return $this->render('detailslist2', [ 'model' => $model,
				'page' => $page,
				'id' => $id,
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
		$id = Yii::$app->request->get('id');
		
		$love    = new ZmLovefund();
		$tdg     = new ZmTdgjj();
		$zmtotal = new ZmTotal();
		$fuxiao  = new ZmFuxiao();
		$lvyou   = new ZmTravel();
		$jb      = new ZmPositionPoints();
		$shui = 0;
		$model   = [];
		$where = $zmtotal->find()->from('zm_total as t')->leftJoin("zm_week as w","w.scount=t.scount")->where(['t.userid'=>$id]);
		if(Yii::$app->request->get("scount")){
			$where = $where->andWhere(['=','t.scount',intval(Yii::$app->request->get("scount"))]);
		}
		$total = $where->andWhere(['>','t.scount',0])->select(['t.*','w.stime','w.etime'])->orderBy("t.scount desc")->asArray()->one();
		$stime = $total['stime']-1;
		$etime = $total['etime']+1;
		
		/** 取最新的周期*/
		$model['alllove'] = $love->find()->where(['userid'=>$id])->andWhere(['>','addtime',$stime])
			->andWhere(['<','addtime',$etime])->andWhere(['status'=>'3'])->select("sum(love) as zong")->asArray()->one();
		$model['allfx']   = $fuxiao->find()->where(['userid'=>$id])->andWhere(['>','addtime',$stime])->andWhere(['=','scount',$total['scount']])
			->andWhere(['status'=>'1'])->select("sum(amount) as zong")->asArray()->one();
		$model['allly']   = $lvyou->find()->where(['userid'=>$id])->andWhere(['>','addtime',$stime])
			->andWhere(['<','addtime',$etime])->andWhere(['status'=>'1'])->select("sum(points) as zong")->asArray()->one();
		$model['alljb']   = $jb->find()->where(['userid'=>$id])->andWhere(['>','addtime',$stime])
			->andWhere(['<','addtime',$etime])->andWhere(['=','type',0])->andWhere(['=','status',3])->select("type,sum(bonus) as zong,sum(points*pre*0.08) as shui")->asArray()->one();
		$model['alljc']   = $jb->find()->where(['userid'=>$id])->andWhere(['>','addtime',$stime])
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
		$tdglist    =   $tdg->find()->where(['userid'=>$id])->andWhere(['>','addtime',$stime])
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
		$this->layout = 'layui2';
		
		/* 按分页获取列表 */
		if($total['scount']==5){
			return $this->render('details2', [ 'model' => $model,'id'=>$id,'total' => $total]);
		}
		if($total['scount']==6){
			return $this->render('details1', [ 'model' => $model,'id'=>$id,'total' => $total]);
		}
		if($total['scount']>=8){
			return $this->render('details3', [ 'model' => $model,'id'=>$id,'total' => $total,'shui' => $shui]);
		}
		return $this->render('details', [ 'model' => $model,'id'=>$id,'total' => $total]);
		
		
	}
    /**
     * 资金
     *
     * @return string
     */
    public function actionFund($id)
    {
        $u  = new Users();
        $zi = new ZmIncome();
        $cm  = new ChangeMoney();

        $model = $u->find()->where(['id'=>$id])->select('id,amount,djamount,loginname')->asArray()->one();
        
        if(Yii::$app->request->isAjax){
            
            $zid = Yii::$app->request->post('ZmIncome');
            /** 日志*/
            self::$logobj['desc'] = 'id:'.intval($id);
            
            /* 验证提交信息是否完整 */
            if (!$zi->load(Yii::$app->request->post())) {
                return ['s'=>0,'m'=>'提交信息缺失！'];
            }
            /* 自定义过滤 */
            if(!$zi->validate()){
                $err = $zi->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['s'=>0,'m'=>$first['0']];
            }
            
            /** 检查说明*/
            if(empty($zid['remark'])){
                return ['s'=>0,'m'=>'说明不能为空！'];
            }

            /* 提交值 */
            $amount = floatval($zid['amount']);

            if ($amount < 0) {
                return ['s'=>0,'m'=>'请输入正确数值！'];
            }
            
            if ($amount == 0) {
                return ['s'=>0,'m'=>'没有帐户变动！'];
            }
            
            if ($zid['add_sub_amount'] == 21) {
                
                if ($zid['amount'] > $model['amount']) {
                    $amount = -$model['amount'];
                } else {
                    $amount = -$amount;
                }
                
            }
            
            if ($zid['add_sub_amount'] == 23) {
                
                if ($zid['amount'] > $model['djamount']) {
                    $amount = -$model['djamount'];
                } else {
                    $amount = -$amount;
                }
                
            }
            
            if ($zid['add_sub_amount'] == 20) {
                $cm->send_userid = '0';
                $cm->to_userid   = $model['loginname'];
            }
            if ($zid['add_sub_amount'] == 21) {
                $cm->send_userid = $model['loginname'];
                $cm->to_userid   = '0';
            }
            $cm->money = $amount;
            $cm->change_time = date("Y-m-d H:i:s",time());
            $cm->why_change = $zid['remark'];
            $cm->types = 1;
            $cm->give_money = 0;
            $cm->amount = 0;
            $cm->flag = 0;
            
            $zi->userid  = $id;
            $zi->amount  = $amount;
            $zi->balance = $model['amount'] + ($amount);
            $zi->addtime = date("Y-m-d H:i:s",time());
            $zi->remark  = $zid['remark'];
            $zi->types   = $zid['add_sub_amount'];
	        $transaction = Yii::$app->db->beginTransaction();
            try{
                if(!$zi->save()){
	                $transaction->rollback();
                    return ['s'=>2,'m'=>"添加记录失败"];
                }

                /* 变动账户 */
	            if ($zid['add_sub_amount'] == 20 || $zid['add_sub_amount'] == 21) {
	                
	                // changemoney 记录
	                if(!$cm->save()){
	                    $transaction->rollback();
	                    return ['s'=>2,'m'=>"添加记录失败"];
	                }
	                
		            if (!$u->updateAllCounters(['amount' => $amount], ['id' => $id])) {
			            $transaction->rollback();
			            return ['s' => 2, 'm' => '编辑失败'];
		            }
	            } else {
                    if(!$u->updateAllCounters(['djamount' => $amount],['id' => $id])) {
	                    $transaction->rollback();
                        return ['s'=>2,'m'=>'编辑失败'];
                    }
                }
                
	            $transaction->commit();
                return ['s'=>1,'m'=>'编辑成功！'];
            }catch (Exception $e) {
	            $transaction->rollback();
                return ['s'=>2,'m'=>'编辑失败！'];
            }
        }
        
        $this->layout = 'layui2';
        return $this->render('fund', [
            'model' => $model,
        ]);
    }


    /**
     * 三级联动
     * @return unknown
     */
    public function actionGetregion(){
        if(Yii::$app->request->isAjax) {
            $region    = new Region();
            $request   = Yii::$app->request;
            $parent_id = $request->post('areaId');
            $region    = $region->find()->where(["parent_id"=>$parent_id])->asArray()->all();
            return $region;
        }
        return [];
    }

    public function actionCheckidentityid(){
        $obj_identity = new Identity();
        if(Yii::$app->request->isAjax) {
            $request = Yii::$app->request;
            $identityid = $request->get('txt_identityid');
            $error['cod'] = 0;
            $data = $obj_identity->checkIdentity($identityid);
            if (!$data) {
                $error['cod'] = 1;
                $error['msg'] = '身份证格式错误,请重新输入!';

            }
            //验证年龄
            $data = $obj_identity->getAge(18, 75);
            if (!$data) {
                $error['cod'] = 1;
                $error['msg'] = '身份证年龄不符,请重新输入!';
            }
            return $error;
        }
    }
    
    /**
     * up status 状态编辑 &删除
     * 
     * @return string
     */
    public function actionUpstatus()
    {
        /* 验证信息 */
        if(!Yii::$app->request->post('ids')){
            return ['s'=>0,'m'=>'没有可操作项'];
        }
        $ids = explode(',', Yii::$app->request->post('ids'));
        foreach ($ids as $k => $v){
            $ids[$k] = intval($v);
        }
        /** 日志*/
        self::$logobj['desc'] = 'id:'.implode(',', $ids);
        /**删除会员的验证信息**/
        $status = Yii::$app->request->post('status');
        if($status != 2 )
        {	
        	$modobj = new User();
        	if($modobj->updateAll(['lockuser' => ($status == '-1'?1:intval($status))],['id' => $ids])){
        		return ['s'=>1,'m'=>'编辑成功'];
        	}
        	return ['s'=>0,'m'=>'编辑失败'];
        }
        else {
        	/* 验证信息 */
        	if(!Yii::$app->request->post('ids')){
        		return ['s'=>0,'m'=>'没有可操作项'];
        	}
        	$ids = explode(',', Yii::$app->request->post('ids'));
        	foreach ($ids as $k => $v){
        		$ids[$k] = intval($v);
        	}
        	/**删除会员的验证信息**/
        	$status = Yii::$app->request->post('status');
        	$modobj = new User();
        	$where=array('pid'=>['=','standardlevel','0'],'pay_points_all'=>0);
        	$data = $modobj->findIdentity($ids);
        	if(empty($data))
        	{
        		return ['s'=>0,'m'=>'删除失败,该会员不存在!'];
        	}
        	$rel = $modobj->find()->Where(['>','standardlevel',0])->andwhere(['=','id',$data['id']])->asArray()->one();
        	if(!empty($rel))
        	{
        		return ['s'=>0,'m'=>'删除失败,vip会员不能删除!'];
        	}
        	$rel = $modobj->find()->andWhere(['>','pay_points_all',0])->andWhere(['id'=>$data['id']])->asArray()->one();
        	if(!empty($rel))
        	{
        		return ['s'=>0,'m'=>'删除失败,有积分会员不能删除!'];
        	}
        	$rel = $modobj->find()->andWhere(array('pid'=>$data['loginname']))->asArray()->count();
        	
        	if(!empty($rel)&&$rel>1)
        	{
        		return ['s'=>0,'m'=>'删除失败,该会员有分支!'];
        	}
        	
        	$area=$data['area'];
        	$ppath = explode(',', $data['ppath']);
        	/*区别左右分区有多少人需要更新num*/
        	$result=$modobj->find()->select('id,area')->Where(['in','id',$ppath])->orderBy("ceng desc")->asArray()->all();//->orderBy(['ceng'=>SORT_DESC])
        	$arr=[];
        	foreach ($result as $key=>$val){
        		$arr[$area][]=$val['id'];
        		$area = $val['area'];
        	}
        	$zp = new zp();
        	/*查询级别*/
        	$zpdata=$zp->find()->where(['users_id'=>$data['id']])->asArray()->one();
        	
        	$connection  = Yii::$app->db;
        	/*创建事务 */
        	$transaction= Yii::$app->db->beginTransaction();
        	
        	try {
		        $omma_separated = implode(",", $arr[1]);
        		if(!empty($arr[1])){
        			$sql = " update users set num1 = num1 - 1 where id in ($omma_separated)";
			        $res= $connection->createCommand($sql)->execute();
        		}
        		if(!empty($arr[2])){
        			$omma_separated = implode(",", $arr[2]);
        			$sql = " update users set num2 = num2-1 where id in ($omma_separated)";
			        $res= $connection->createCommand($sql)->execute();
        		}
        		
        		$upsql = "UPDATE `users` SET ceng = ceng-1,ppath = REPLACE ( ppath, ',".$data['id'].",', ',') where ppath like '%,".$data['id'].",%'";
        		$res= $connection->createCommand($upsql)->execute();
        		
        		$upsql = "UPDATE `users` SET ceng = ceng-1,ppath = REPLACE ( ppath, ',".$data['id']."', '') where ppath like '%,".$data['id']."'";
        		$res= $connection->createCommand($upsql)->execute();
        		$res = $zp->updateAll(array('pid'=>$zpdata['pid']),'pid=:pid',array(':pid'=>$data['id']));
        		if($res===false){
        			$transaction->rollback();
        			return ['s'=>0,'m'=>'修改等级记录失败'];
        		}
        		
        		/*删除当前用户信息*/
        		$zp->deleteAll('uname=:uname',array(':uname'=>$data['loginname']));
        		$modobj->deleteAll('loginname=:loginname',array(':loginname'=>$data['loginname']));
        		
        		$update=array('pid'=>$data['pid'],'area'=>$data['area']);
        		$query = $modobj->updateAll($update,array('pid'=>$data['loginname']));
        		
        		$update=array('rid'=>$data['rid']);
        		$query = $modobj->updateAll($update,array('rid'=>$data['loginname']));
        		
        		/*添加日志*/
        		$zmrid = new zmrid();
        		$zmrid->currid=$data['pid'];
        		$zmrid->newrid=$data['pid'];
        		$zmrid->uptime=date('Y-m-d H:i:s',time());
        		$zmrid->loginname=$data['loginname'];
        		$zmrid->types=2;//删除 ,1 修改
        		if(!$zmrid->save()){
        			$transaction->rollback();
        			return ['s'=>0,'m'=>'添加日志失败'];
        		}
        		$transaction->commit();
        		return ['s'=>2,'m'=>'删除成功！'];
        	}
        	catch (\Exception $e)
        	{
        		$transaction->rollback();
        		return ['s'=>0,'m'=>'删除	失败！'];
        	}
        }
    }
  
}
