<?php
	namespace frontend\controllers;
	
	use Yii;
	use common\models\User;
	use frontend\models\Income;
	use frontend\models\ChangeMoney;
	use yii\data\Pagination;
	use Exception;
	
	
	/**
	 * 资金管理控制器
	 */
	class FundsController extends BaseController
	{
		
		/**
		 * 转账记录
		 * @param number $limit
		 * @param number $count
		 * @return number[]|string[]|NULL[]|number[]|string[]|string[]|\yii\data\Pagination[]|string
		 */
		public function actionIndex($limit = 15, $count = 1000)
		{
			if($this->verify() !== true){
				return self::$vfi;
			}
			$change_money = new ChangeMoney();
			$obj = $change_money->find()->where(['send_userid'=>Yii::$app->session->get("loginname")])->orWhere(['to_userid'=>Yii::$app->session->get("loginname")])->andWhere(['>','change_time',Yii::$app->session->get('addtime')]);
			
			/* 获取总记录数 */
			if(Yii::$app->request->post('count')){
				return [ 'count' => $obj->count() ];
			}
			$page = new Pagination(['totalCount' => $count]);
			$page->defaultPageSize = $limit == 15?15:30;
			$model = $obj->orderBy('id desc')->offset($page->offset)->limit($page->limit)->asArray()->all();
			$page->params = ['list'=>'all'];
			
			if(Yii::$app->request->isAjax){
				return [ 'html' => $this->render('recordList',['model' => $model]), 'page' => $page ];
			}else{
				return $this->render('record',[ 'model' => $model, 'page' => $page]);
			}
		}
		
		/**
		 * 爱心基金
		 * @param number $limit
		 * @param number $count
		 */
		public function actionLovefund($limit = 15, $count = 1000)
		{
			$income = new Income();
			$obj = $income->find()->where(['userid'=>Yii::$app->session->get("loginname"),'types'=>'爱心基金'])->andWhere(['>','addtime',Yii::$app->session->get('addtime')]);
			
			/* 获取总记录数 */
			if(Yii::$app->request->post('count')){
				return [ 'count' => $obj->count() ];
			}
			$page = new Pagination(['totalCount' => $count]);
			$page->defaultPageSize = $limit == 15?15:30;
			$model = $obj->orderBy('id desc')->offset($page->offset)->limit($page->limit)->asArray()->all();
			$page->params = ['list'=>'all'];
			
			if(Yii::$app->request->isAjax){
				return [ 'html' => $this->render('lovefundList',['model' => $model]), 'page' => $page ];
			}else{
				return $this->render('lovefund',[ 'model' => $model, 'page' => $page]);
			}
		}
		
		/**
		 * 会员转账
		 * @return number[]|string[]|NULL[]|string
		 */
		public function actionTransfer()
		{
			if($this->verify() !== true){
				return self::$vfi;
			}
			$changeMoney = new ChangeMoney();
			$users = User::findIdentity(UID);
			/*if($users['position']>12||$users['position']==0){
				if($this->verify_baodan() !== true){
					return self::$vfi;
				}
			}*/
			$users['amount'] = $this->decpoint($users['amount']);
			return $this->render('transfer',[
				'user' => $users,
				'model' => $changeMoney,
			]);
		}
		
		/**
		 * ajax 检测转账会员是否存在,存在返回用户真实姓名，不存在返回错误信息
		 * @return number[]|string[]|number[]
		 */
		public function actionCheckuserid()
		{
			if($this->verify() !== true){
				return self::$vfi;
			}
			
			
			$post = Yii::$app->request->post();
			if(Yii::$app->request->isAjax && isset($post['uname'])) {
				
				if(!isset($post['uname']) || empty($post['uname']) || !preg_match("/^[a-zA-Z\d-_\.]*$/", $post['uname'], $toname)){
					return ['status'=>0,'msg'=>'接收会员格式错误！'];
				}
				if($post['uname'] == Yii::$app->session->get('loginname')){
					return ['status'=>0,'msg'=>'接收人不能是自己！'];
				}
				
				$addamounts = User::findOne(['loginname'=>implode(',', $toname)]);
				if($addamounts){
					return ['status'=>1,'msg'=>$addamounts->truename];
				}else{
					return ['status'=>0,'msg'=>'转入会员不存在，请核对后再次输入！'];
				}
			}
			
			return '你在找什么，<a href="/">返回首页</a>';
		}
		
		/**
		 * 确认转账操作
		 * @return number[]|string[]|number[]|string[]|mixed[]
		 */
		public function actionConftransfer()
		{
			if($this->verify() !== true){
				return self::$vfi;
			}
			
			if(Yii::$app->request->isAjax) {
				$mobile_code = Yii::$app->request->post('mobile_code');
				if(empty($mobile_code)){
					return ['status'=>2,'msg'=>'验证码不能为空！'];
				}else if($mobile_code!=Yii::$app->session->get("mobile_code")){
					return ['status'=>2,'msg'=>'验证码不正确,请重新输入！'];
				}
				$isposition = 0;
				$post = Yii::$app->request->post('ChangeMoney');
				if(!isset($post['money']) || (intval($post['money'])%50)!=0){
					return ['status'=>2,'msg'=>'转账金额需为50的倍数！'];
				}
				$post['money']     = intval($post['money']);
				$post['to_userid'] = trim($post['to_userid']);
				$userAmount = User::findIdentity(UID);
				/*if($userAmount['position']>12||$userAmount['position']==0){
					if(!empty($userAmount['baodan'])){
						$addamounts = User::findOne(['loginname'=>$userAmount['baodan']]);
						if(!$addamounts){
							if($addamounts['dllevel']!=1){
								return ['status'=>2,'msg'=>'转入会员不存在或非代理商,请核对后再次输入！'];
							}
						}
					}
					if(!empty($userAmount['bdr'])) {
						$addamounts = User::findOne(['loginname' => $userAmount['bdr'], 'bdl' => 1]);
						if (!$addamounts) {
							return ['status' => 2, 'msg' => '转入会员不存在或非报单中心,请核对后再次输入！'];
						}
					}
					$isposition = 1;
				}else{*/
				$addamounts = User::findOne(['loginname' => $post['to_userid']]);
//				}
				if(empty($addamounts)){
					return ['status'=>2,'msg'=>'转入会员不存在！'];
				}/*else{
					if($isposition==1){
						if($addamounts['position']>12 || $addamounts['position']==0){
							return ['status'=>2,'msg'=>'转入会员非主任及以上级别,无法转账！'];
						}
					}
				}*/
				if(!isset($post['to_userid']) || empty($post['to_userid']) || !preg_match("/^[a-zA-Z\d-_\.]*$/", $post['to_userid'], $toname) ){
					return ['status'=>2,'msg'=>'接收会员格式错误！'];
				}
				if($addamounts->id==$userAmount->id){
					return ['status'=>2,'msg'=>'转入会员不能是自己！'];
				}
				if($post['money']>$userAmount->amount){
					return ['status'=>2,'msg'=>'转账金额不能大于当前积分余额！'];
				}
				if($userAmount->amount-$userAmount->djamount-$post['money']<0){
				    return ['status'=>2,'msg'=>'您的账号部分资金已被冻结，无法转出！'];
				}
				$changeMoney = new ChangeMoney();
				/* 验证提交信息是否完整 */
				if (!$changeMoney->load(Yii::$app->request->post()) ) {
					return ['status'=>2,'msg'=>'提交信息缺失！'];
				}
				
				$sess  = ['status'=>2,'msg'=>'转账失败'];
				$times = date('Y-m-d H:i:s',time());
				$transaction = Yii::$app->db->beginTransaction();
				try{
					if(!$changeMoney->save()){
						$err = $changeMoney->getErrors();
						list($first_key, $first) = (reset($err) ? each($err) : each($err));
						$transaction->rollback();
						return ['status'=>2,'msg'=>$first['0']];
					}
					/** 调整转出积分*/
					$rets = $userAmount->updateCounters(['amount'=>$post['money']*-1]);
					if(empty($rets) || $rets === false){
						$transaction->rollback();
						return $sess;
					}
					/** 调整转入账户*/
					$rets = $addamounts->updateCounters(['amount'=>$post['money']]);
					if(empty($rets) || $rets === false){
						$transaction->rollback();
						return $sess;
					}
					/** 添加转账记录*/
					$rets = Yii::$app->db->createCommand()->batchInsert('zm_income', ['userid', 'amount', 'balance', 'addtime', 'reason', 'types'], [
						[$userAmount->id, $post['money']*-1,$userAmount->amount,$times,$addamounts->id,5],
						[$addamounts->id, $post['money'],$addamounts->amount,$times,$userAmount->id,3],
					])->execute();
					if(empty($rets) || $rets === false){
						$transaction->rollback();
						return $sess;
					}
					/** 提交事务会真正的执行数据库操作*/
					$transaction->commit();
					return ['status'=>1,'msg'=>'转账成功','url'=>$this->urlTo('/funds/index?funin=1'),'sx'=>1];
				}catch (Exception $e) {
					/** 如果操作失败, 数据回滚*/
					$transaction->rollback();
					return $sess;
				}
			}
			
			return '你在找什么，<a href="/">返回首页</a>';
		}
	}
