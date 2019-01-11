<?php
namespace  backend\controllers;

use Yii;
use common\models\User as u; 
use backend\models\ZmPosition as zp;
use backend\models\ZmUprid as zmrid;

/**
 * 
 * 修改推荐人控制器
 * @author Administrator
 *
 */
class UpridController extends  BaseController
{
	/**
	 * 默认加载时
	 * @return string
	 */
	public function actionIndex()
	{
		$this->layout = 'layui2';
		return $this->render('index');
	}
	public function actionIndexpy()
	{
		$this->layout = 'layui2';
		return $this->render('index2');
	}
	
	public function actionEditpy()
	{
	    /** 日志*/
	    self::$logobj['desc'] = '平移修改推荐人1';
		$connection  = Yii::$app->db; 
		$u=new u();
		$zp = new zp(); 
		$relrid=$u->findByUsername(Yii::$app->request->post('rid'));
		if(empty($relrid)){
			return ['s'=>0,'m'=>'推荐人不存在'];
		} 
		$relcur=$u->findByUsername(Yii::$app->request->post('loginname'));
		if(empty($relcur)){
			return ['s'=>0,'m'=>'用户名不存在'];
		}
		/*判断下要修改为的推荐人和当前推荐人是否为同一个人，如果是，则返回*/
		if($relcur['rid']==$relrid['loginname']){
			return ['s'=>0,'m'=>'新推荐人和原先的推荐人为同一人!'];
		}
		$youid = $relcur['id'];
		$yourpath = $relcur['rpath'];
		$sql = "select count(*) as zong from users where rpath like '%,".$relcur['id']."' or rpath like '%,".$relcur['id'].",%' and standardlevel>0";
		$count = $connection->createCommand($sql)->queryAll();
		$vip_count = empty($count[0]['zong']) || !isset($count[0])?0:$count[0]['zong'];
		if($relcur['standardlevel']>0){
			$vip_count+=1;
		} 
		/*验证下推荐人信息*/
		$where = $u->find()->andWhere(['=','loginname',Yii::$app->request->post('rid')]);
		$data =$where->one();  
	    if(empty($data)){
			return ['s'=>0,'m'=>'推荐人不存在或者非vip'];
		}
		$dai=$data['dai']+1;
		$rpath=$data['rpath'].','.$data['id']; 
		if($vip_count>0){
			$transaction= Yii::$app->db->beginTransaction();//创建事务 
			try{
				
				/*更新新的推荐人信息*/
				$update=array('rid'=>Yii::$app->request->post('rid'),'dai'=>$dai,'rpath'=>$rpath);
				$u->updateAll($update,'loginname=:loginname',array(':loginname'=>Yii::$app->request->post('loginname')));
				/*更新 rpath中旧的推荐人 更改为新的推荐人id*/
				$sql = "update users set rpath = REPLACE (rpath,'".$relcur['rpath'].",','".$rpath.",'),dai=length(rpath) - length(REPLACE (rpath, ',', '')) where rpath like '".$relcur['rpath'].",".$relcur['id'].",%' or rpath like '".$relcur['rpath'].",".$relcur['id']."'";
				 
				$command = $connection->createCommand($sql);
				$res     = $command->execute();
				$res = $connection->createCommand("update zm_position set rid=".$data['id']." where users_id = ".$youid)->execute();
				//$res = $zp->updateAll(array('rid'=>$data['id']),'users_id=:users_id',array(':users_id'=>$youid));
				if($res===false){
					$transaction->rollback();
					return ['s'=>0,'m'=>'修改等级记录失败'];
				}
				/*添加日志*/
				$zmrid = new zmrid(); 
				$zmrid->currid=$relcur['rid'];
				$zmrid->newrid=$relrid['loginname'];
				$zmrid->uptime=date('Y-m-d H:i:s',time());
				$zmrid->loginname=$relcur['loginname']; 
				$zmrid->types=1;
				if(!$zmrid->save()){
					$transaction->rollback();
					return ['s'=>0,'m'=>'记录添加失败'];
				} 
				$transaction->commit(); 
			}
			catch(\Exception $e)
			{
				$transaction->rollback();
				echo '6'.$e;
				return ['s'=>0,'m'=>'执行失败'];
			}
		}
		return ['s'=>0,'m'=>'执行成功'];  
	}
	
	
	/*非平移用户*/
	
	public function actionEdit()
	{
	    /** 日志*/
	    self::$logobj['desc'] = '修改推荐人,非平移用户';
		$connection  = Yii::$app->db;
		$u=new u();
		$zp = new zp();
		$relrid=$u->findByUsername(Yii::$app->request->post('rid'));
		if(empty($relrid)){
			return ['s'=>0,'m'=>'推荐人不存在'];
		}
		$relcur=$u->findByUsername(Yii::$app->request->post('loginname'));
		if(empty($relcur)){
			return ['s'=>0,'m'=>'用户名不存在'];
		}
		/*判断下要修改为的推荐人和当前推荐人是否为同一个人，如果是，则返回*/
		if($relcur['rid']==$relrid['loginname']){
			return ['s'=>0,'m'=>'新推荐人和原先的推荐人为同一人!'];
		}
		$youid = $relcur['id'];
		$yourpath = $relcur['rpath'];
		$sql = "select count(*) as zong from users where rpath like '%,".$relcur['id']."' or rpath like '%,".$relcur['id'].",%' and standardlevel>0";
		$count = $connection->createCommand($sql)->queryAll();
		$vip_count = empty($count[0]['zong']) || !isset($count[0])?0:$count[0]['zong'];
		if($relcur['standardlevel']>0){
			$vip_count+=1;
		}
		/*验证下推荐人信息*/
		$where = $u->find()->andWhere(['>','standardlevel',0]);
		$where->andWhere(['=','loginname',Yii::$app->request->post('rid')]);
		$data =$where->one();
		if(empty($data)){
			return ['s'=>0,'m'=>'推荐人不存在或者非vip'];
		}
		$dai=$data['dai']+1;
		$rpath=$data['rpath'].','.$data['id'];
		if($vip_count>0){
			$transaction= Yii::$app->db->beginTransaction();//创建事务
			try{
				/*更新前推荐人，上级人数减*/
				$sql 	 = "update zm_position set r_vip_num=r_vip_num-".$vip_count." where users_id in (".$yourpath.")";
				$command = $connection->createCommand($sql);
				$res     = $command->execute();
				/*更新后推荐人，上级人数加*/
				$sql 	 = "update zm_position set r_vip_num=r_vip_num+".$vip_count." where users_id in (".$rpath.")";
				$command = $connection->createCommand($sql);
				$res     = $command->execute();
				/*更新新的推荐人信息*/
				$update=array('rid'=>Yii::$app->request->post('rid'),'dai'=>$dai,'rpath'=>$rpath);
				$u->updateAll($update,'loginname=:loginname',array(':loginname'=>Yii::$app->request->post('loginname')));
				/*更新 rpath中旧的推荐人 更改为新的推荐人id*/
				$sql = "update users set rpath = REPLACE (rpath,'".$relcur['rpath'].",','".$rpath.",'),dai=length(rpath) - length(REPLACE (rpath, ',', '')) where rpath like '".$relcur['rpath'].",".$relcur['id'].",%' or rpath like '".$relcur['rpath'].",".$relcur['id']."'";
				
				$command = $connection->createCommand($sql);
				$res     = $command->execute();
				$res = $connection->createCommand("update zm_position set rid=".$data['id']." where users_id = ".$youid)->execute();
				$res = $zp->updateAll(array('rid'=>$data['id']),'users_id=:users_id',array(':users_id'=>$youid));
				if($res===false){
					$transaction->rollback();
					return ['s'=>0,'m'=>'修改等级记录失败'];
				}
				/*添加日志*/
				$zmrid = new zmrid();
				$zmrid->currid=$relcur['rid'];
				$zmrid->newrid=$relrid['loginname'];
				$zmrid->uptime=date('Y-m-d H:i:s',time());
				$zmrid->loginname=$relcur['loginname'];
				$zmrid->types=1;
				if(!$zmrid->save()){
					$transaction->rollback();
					return ['s'=>0,'m'=>'记录添加失败'];
				}
				$transaction->commit();
			}
			catch(\Exception $e)
			{
				$transaction->rollback();
				echo '6'.$e;
				return ['s'=>0,'m'=>'执行失败'];
			}
		}
		return ['s'=>0,'m'=>'执行成功'];
	}
}