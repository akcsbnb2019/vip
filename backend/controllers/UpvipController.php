<?php
namespace backend\controllers;

use backend\models\UpRegUsers;
use common\models\User;
use Yii;
use backend\models\LUsers;
use backend\models\EUsers;
use backend\models\UpSanzhe;
use yii\data\Pagination;

/**
 * 站内信管理
 */
class UpvipController extends BaseController
{
    /**
     * 列表
     * 
     * @return string
     */
   
	public function trimall($str){
		$qian=array(" ","　","\t","\n","\r");
		return str_replace($qian, '', $str);
	}
    /**
     * edit 编辑
     * 
     * @return string
     */
    public function actionIndex()
    {
	    $user = new LUsers();
        /* 执行更新操作 */
        if(Yii::$app->request->isAjax){
            $level = array(
            	1=>300,
	            2=>3000,
	            3=>9000,
            );
            $update_users = array();
            $update_eusers = array();
            $insert_vip = array();
            $err = array(1=>array(),2=>array());
            $post = Yii::$app->request->post("LUsers");
            /* 验证提交信息是否完整 */
            if (!$user->load(Yii::$app->request->post())) {
                return ['s'=>0,'m'=>'提交信息缺失！'];
            }
	        if(empty($post['loginnames'])){
		        return ['s'=>0,'m'=>'帐号不能为空！'];
	        }
            if($post['level']<1){
	            return ['s'=>0,'m'=>'请选择级别！'];
            }
			$arr = explode(",",$post['loginnames']);
	        foreach ($arr as $k=>$v){
	        	if(!empty($v)){
			        $arr[$k] = $this->trimall($v);
		        }else{
	        		unset($arr[$k]);
		        }
	        }
	
	        foreach ($arr as $k=>$v){
		        $info = $user->find()->where(['loginname'=>$v])->one();
		        if(empty($info)){
		        	$err[1][] = $v;
		        	unset($arr[$k]);
		        }
	            if($info['standardlevel']==$post['level'] || $info['standardlevel']>=$post['level']){
			        $err[2][] = $v;
		            unset($arr[$k]);
	            }
	            if($info['standardlevel']==0){
		            $update_eusers[] = $v;
		            $update_users[]  = $v;
		            $insert_vip[]    = array(
			            $info['loginname'],
			            $info['standardlevel'],
			            0,
			            $post['level'],
			            date("Y-m-d H:i:s",time()),
			            Yii::$app->session->get('uname')
		            );
	            }
	            if($info['standardlevel']>0){
		            $update_users[]  = $v;
		            $insert_vip[]    = array(
			            $info['loginname'],
			            $info['standardlevel'],
			            0,
			            $post['level'],
			            date("Y-m-d H:i:s",time()),
			            Yii::$app->session->get('uname')
		            );
	            }
	        }
	        if(count($err[1])>0){
		        return ['s'=>0,'m'=>"帐号: ".implode(',',$err[1])." 不存在,请核对后重新输入进行升级"];
	        }elseif (count($err[2])>0){
		        return ['s'=>0,'m'=>"帐号: ".implode(',',$err[2])." 已是当前级别或大于当前级别,无法进行升级,请清除以上账号后进行操作!"];
	        }
	        $eusers = new EUsers();
            /* 自定义过滤 */
            if(!$user->validate()){
                $err = $user->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['s'=>0,'m'=>$first['0']];
            }
	        $transaction = Yii::$app->db->beginTransaction();
	        try{
		        $connection = Yii::$app->db;
		        $queryBuilder = $connection->queryBuilder;
		        $sql = $queryBuilder->batchInsert(UpRegUsers::tableName(),
			        ['loginname', 'standardlevel','types','up_standardlevel','addtime','admin_name'], $insert_vip);
		        if(!$connection->createCommand($sql)->execute()){
			        $transaction->rollback();
			        return ['s'=>0,'m'=>'记录添加失败！'];
		        }
		        
		        $eusers = new EUsers();
		        if(count($update_eusers)>0){
			        if(!$eusers::updateAll(['pay_points'=>$level[$post['level']],'rank_points'=>$level[$post['level']]],['in','user_name',$update_eusers])){
				        $transaction->rollback();
				        return ['s'=>0,'m'=>'增加商城积分失败！'];
			        }
			        
			        if(!$user::updateAll(['pay_points_all'=>$level[$post['level']]],['in','loginname',$update_eusers])){
				        $transaction->rollback();
				        return ['s'=>0,'m'=>'增加会员积分失败！'];
			        }
		        }
		        
		        $up_users = new LUsers();
		        if(!$up_users::updateAll(['standardlevel'=>$post['level']],['in','loginname',$update_users])){
			        $transaction->rollback();
			        return ['s'=>0,'m'=>'修改级别失败！'];
		        }
		        $transaction->commit();
		        return ['s'=>2,'m'=>'升级成功！'];
	        }catch (Exception $e) {
		        $transaction->rollback();
		        return ['s'=>0,'m'=>'升级失败！'];
	        }
        }
        /* 取值 */
        /* 初始化类型 */
        $this->layout = 'layui2';
        return $this->render('upvip',[
            'user' => $user,
        ]);
    }
	
}
