<?php
namespace backend\controllers;

use backend\models\Users;
use Yii;
use backend\models\Recharge;
use backend\models\ZmIncome;
use yii\data\Pagination;
use Exception;

/**
 * 新闻管理控制器
 */
class RechargeController extends BaseController
{
    /**
     * 列表
     * 
     * @return string
     */
    public function actionIndex($limit = 0, $count = 0)
    {
        $userid  = Yii::$app->request->post('s');
        $modobj = new Recharge();
        $where  = $modobj->find();
        
        /* 模糊查询 */
        if($userid){
            $where->andWhere(" user like :user ",[':user'=>"%$userid%"]);
        }
        
        /* 优化记录数求和 */
        $page  = new Pagination([
            'totalCount' => (AJAX && $count ? Yii::$app->request->post('count') : $where->count()),
        ]);
        $page->defaultPageSize = intval($limit)<10?10:(intval($limit)>30?30:intval($limit));
        $data = $where->orderBy('id DESC')->offset($page->offset)->limit($page->limit)->asArray()->all();
        
        if(AJAX){
            $this->layout = 'kong';
            return [
                'html' => $this->render('list',[
                    'model' => $data,
                ]),
                'page' => $page ,
            ];
        }else{
            $this->layout = 'layui2';
            return $this->render('index',[
                'model' => $data,
                'page'  => $page,
            ]);
        }
    }
    
    
    /**
     * up status 状态编辑&删除
     * 
     * @return string
     */
    public function actionUpstatus()
    {
        /* 验证信息 */
        if(!Yii::$app->request->post('ids')){
            return ['s'=>0,'m'=>'没有可操作项'];
        }
        $status = intval(Yii::$app->request->post('status'));
        if(!in_array($status, [-1,1])){
            return ['s'=>0,'m'=>'没有可操作项'];
        }
        $ids    = explode(',', Yii::$app->request->post('ids'));
	    $modobj = new Recharge();
	    $users  = new Users();
        foreach ($ids as $k => $v){
            $ids[$k] = intval($v);
        }
        /** 日志*/
        self::$logobj['desc'] = 'id:'.implode(',', $ids);
	    $transaction = Yii::$app->db->beginTransaction();
	    try{
	        if($status == 1){
	            if(count($ids) > 0){
	                $all  = $modobj->find()->where(['=','incomeId',0])->andWhere(['in','id',$ids])->orderBy('id ASC')->asArray()->all();
	                if(count($all) == 0){
	                    $transaction->rollback();//如果操作失败, 数据回滚
	                    return ['s'=>0,'m'=>'没有找到操作项'];
	                }
	                foreach ($all as $val){
	                    $uinfo  = $users->findOne(['loginname'=>$val['user']]);
	                    if(isset($uinfo->id)){
	                        $uinfo->amount += $val['money'];
	                        if(!$uinfo->save()){
	                            $transaction->rollback();//如果操作失败, 数据回滚
	                            return ['s'=>0,'m'=>'用户电子币下发失败'];
	                        }
	                        $income = new ZmIncome();
	                        $rets = $income->addIncome($uinfo->id,$val['money'],$uinfo->amount,12);
	                        if(empty($rets) || $rets === false){
	                            $transaction->rollback();
	                            return ['s'=>0,'m'=>'记录失败'];
	                        }
	                        $income_id= Yii::$app->db->getLastInsertID();
	                        if(empty($income_id)){
	                            $transaction->rollback();
	                            return ['s'=>0,'m'=>'记录id丢失'];
	                        }
	                        if(!$modobj->updateAll(['incomeId' => $income_id],['id' => $val['id']])){
	                            $transaction->rollback();//如果操作失败, 数据回滚
	                            return ['s'=>0,'m'=>'更新状态失败'];
	                        }
	                        $income = null;
	                    }else{
	                        $transaction->rollback();//如果操作失败, 数据回滚
	                        return ['s'=>0,'m'=>'用户信息不存在'];
	                    }
	                }
	            }
	        }else if(!$modobj->updateAll(['incomeId' => $status],['id' => $ids])){
			    $transaction->rollback();//如果操作失败, 数据回滚
			    return ['s'=>0,'m'=>'更新状态失败'];
		    }
		    $transaction->commit();
		    return ['s'=>1,'m'=>'编辑成功'];
	    	
	    }catch (Exception $e) {
		    $transaction->rollback();//如果操作失败, 数据回滚
		    return ['s'=>0,'m'=>'编辑失败！'];
		
	    }
     
    }
}
