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



/**
 * 用户管理控制器
 */
class SeluserController extends BaseController
{
    /** 
     * 普通会员列表
     * 
     * @return string
     */
    public function actionIndex($limit = 0, $count = 0,$level = '')
    {
	    /* 请求是否正常 */
	    $id = Yii::$app->request->get('id',1);
	    $key= ['id','loginname','lallyeji','rallyeji','num1','num2','standardlevel','pay_points_all','ppath','area'];
	    if($id != intval($id)){
		    return $this->msg('异常请求!',['icon'=>0,'url'=>$this->urlTo('/seluser/index')]);
	    }
	    /* 条件设置,验证 */
	    $post = Yii::$app->request->post('User');
	    $user = new User();
	    if(isset($post['loginname']) && !empty($post['loginname']) && preg_match("/^[a-z\\d]*$/", $post['loginname'], $toname)){
		    $obj = $user->find()->where('loginname=:loginname',[':loginname'=>implode(',', $toname)]);
	    }else{
		    $obj = $user->find()->where(['id'=>intval($id)]);
	    }
	    $usero = $obj->select($key)->asArray()->one();
	    if(!$usero){
		    return $this->msg('您输入的用户不存在!',['icon'=>0,'url'=>$this->urlTo('/seluser/index')]);
	    }
	    /* 查询子集 */
	    $userp  = $user->find()->where('pid=:pid',[':pid'=>$usero['loginname']])->select($key)->asArray()->all();
	    $model  = ['user' => $usero];
	    foreach ($userp as $val){
		    $model[($val['area'] == 1 ? 'left' : 'right')] = $val;
	    }
	    return $this->render('index',[
		    'user' => $user,
		    'model' => $model,
	    ]);
    }
	
	public function actionSeluser($limit = 0, $count = 0,$level = '')
	{
		/* 请求是否正常 */
		$id = Yii::$app->request->get('id',1);
		$arr = array("l"=>"",'r'=>"");
		$user = new User();
		$obj = $user->find()->where(['id'=>$id])->asArray()->one();
		$ppath = $user->find()->where(['in','id',explode(',',$obj['ppath'])])->orderBy("ceng desc")->asArray()->all();
		$area= $obj['area'];
		foreach ($ppath as $k=>$v){
			if($area==1){
				$arr['l'] .= $v['id'].",";
			}
			if($area==2){
				$arr['r'] .= $v['id'].",";;
			}
			$area = $v['area'];
		}
		pe($arr);
	}
}
