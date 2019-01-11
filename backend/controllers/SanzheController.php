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
class SanzheController extends BaseController
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
 
	
	public function actionIndex()
	{
		$euser = new EUsers();
		$upsanzhe = new UpSanzhe();
		
		/* 执行更新操作 */
		if(Yii::$app->request->isAjax){
			/* 验证提交信息是否完整 */
			if (!$euser->load(Yii::$app->request->post())) {
				return ['s'=>0,'m'=>'提交信息缺失！'];
			}
			/* 自定义过滤 */
			if(!$euser->validate()){
				$err = $euser->getErrors();
				list($first_key, $first) = (reset($err) ? each($err) : each($err));
				return ['s'=>0,'m'=>$first['0']];
			}
			$post = Yii::$app->request->post("EUsers");
			$euinfo = $euser->find()->where(['user_name'=>$post['user_name']])->one();
			
			$upsanzhe->user_name = $euinfo->user_name;
			$upsanzhe->pay_points = $euinfo->pay_points;
			$upsanzhe->rank_points = $euinfo->rank_points;
			$upsanzhe->user_coupon = $euinfo->user_coupon;
			$upsanzhe->first_coupon = $euinfo->first_coupon;
			$upsanzhe->coupon_rank_points = $euinfo->coupon_rank_points;
			
			$upsanzhe->up_user_coupon = $euinfo->user_coupon;
			$upsanzhe->up_first_coupon = 0;
			$upsanzhe->up_coupon_rank_points = 0;
			$upsanzhe->up_pay_points = $euinfo->pay_points;
			$upsanzhe->up_rank_points = $euinfo->rank_points;
			$upsanzhe->addtime = date("Y-m-d H:i:s",time());
			$upsanzhe->admin_name = Yii::$app->session->get('uname');
			if(empty($euinfo)){
				return ['s'=>0,'m'=>'用户不存在,请核对后重新输入！'];
			}
			if(Yii::$app->request->post('types')>0) {
				$euinfo->pay_points = $euinfo->pay_points+$post['jifen'];
				$euinfo->rank_points = $euinfo->rank_points+$post['jifen'];
				$upsanzhe->up_pay_points += $post['jifen'];
				$upsanzhe->up_rank_points += $post['jifen'];
				
			}
			$euinfo->first_coupon=0;
			$euinfo->coupon_rank_points=0;
			
			$transaction = Yii::$app->db->beginTransaction();
			try{
				
				if(!$euinfo->save()){
					$transaction->rollback();
					return ['s'=>0,'m'=>'修复失败！'];
				}
				if(!$upsanzhe->save()){
					$transaction->rollback();
					return ['s'=>0,'m'=>'记录添加失败！'];
				}
				$transaction->commit();
				return ['s'=>2,'m'=>'编辑成功！'];
			}catch (Exception $e) {
				$transaction->rollback();
				return ['s'=>0,'m'=>'编辑失败！'];
			}
		}
		
		/* 初始化类型 */
		$this->layout = 'layui2';
		return $this->render('upsanzhe',[
			'euser' => $euser,
		]);
	}
}
