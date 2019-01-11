<?php
namespace frontend\controllers;

use common\models\User;
use Yii;
use frontend\models\Stocks;
use frontend\models\Neirong;
use frontend\models\MobileSms;


/**
 * 默认控制器
 */
class IndexController extends BaseController
{

    /**
     * 默认页面 登录
     */
    public function actionIndex()
    {
        if($this->verify_truename() !== true){
            return self::$vfi;
        }
        $users = new User();
        $row = $users->findOne(['id'=>UID]);
        /*$p_row = $users->findOne(['pid'=>$row['loginname'],'area'=>1]);
        $where=array( 
        	'isbd'  =>  0,
        	'isup'  =>  0,
        	'isup2'  =>  0,
        	'isup3'  =>  0,
        	'isdw'  =>  0,
        );
        if((empty($row['bdl'])||$row['bdl']==0) && ($row['position']<12&&$row['position']>0)){
        	$where['isbd'] = 1;
        }
	
	    if($row['standardlevel']<3&&$row['standardlevel']>0&&$row['jihuotime']<=date("Y-m-d H:i:s",strtotime("+90 day"))){
	        $where['isup'] = 1;
	        if($row['standardlevel']==2){
		        $where['isup3'] = 1;
	        }
	        if($row['standardlevel']==1){
		        $where['isup2'] = 1;
		        $where['isup3'] = 1;
	        }
        }
        if((empty($p_row)||$p_row['standardlevel']==0)&&$row['standardlevel']==0){
	        $where['isdw'] = 1;
        }*/
        $where = $this->ismenu();
        
        $this->layout = 'index';
        return $this->render('index',[
            'model' => $where
        ]);
    }

    /**
     * 获取手机验证码
     */
    public function actionGetsms()
    {
        if(Yii::$app->request->isAjax) {
            $mobile = Yii::$app->request->post('mobile');
            $types  = Yii::$app->request->post('types')>0?Yii::$app->request->post('types'):0;
            $user = new User();
            $users = $user->find()->where(['id'=>UID])->select(['tel','loginname','truename'])->one();
            $sms = new MobileSms();
            
            return $sms->addcode($mobile,$users,$types);
            
        }
    }
    
    /**
     * Vip 用户中心
     * @return string
     */
    public function actionMain()
    {
        $pst_arr = [0=>"",6=>"总裁董事",7=>"董事",8=>"高级总监",9=>"总监",10=>"高级经理","经理","主任","见习主任"];
        $array = ['<span>无</span>','<span style="color: red; font-weight: bold; font-size: 18px;">低</span>','<span style="color: blue; font-weight: bold; font-size: 18px;">中</span>','<span style="color: #00aa00; font-weight: bold; font-size: 18px;">高</span>'];
        $pwd   = Yii::$app->session->get('md');
        $uname = Yii::$app->session->get("loginname");
        if(empty($uname)){
            return false;
        }
        $users = User::findByUsername(Yii::$app->session->get("loginname"))->toArray();
        $users['amount']      = $this->decpoint($users['amount']);
        $users['pay_points_all']  = $this->decpoint($users['pay_points_all']);
        $users['cx_vipyeji1'] = $this->decpoint($users['cx_vipyeji1']);
        $users['cx_vipyeji2'] = $this->decpoint($users['cx_vipyeji2']);
        $users['position']    = $users['position'];
        $users['positions']   = $pst_arr[$users['position']];
        
        $neirong = new Neirong();
        $neirong = $neirong->find()->where(['<=','BegindateTime',date("Y-m-d H:i:s",time())])->andWhere(['>=','EnddateTime',date("Y-m-d H:i:s",time())])->andWhere(['>','status',0])->orderBy('articleid desc')->limit(6)->all();
        /*foreach ($neirong as $key=>$val){
            foreach ($val as $k=>$v){
                if($k=="title"){
                    if(strlen($v)>12){
                        $neirong[$key][$k] = substr($v,0,51);
                        $neirong[$key][$k] .= "...";
                    }
                }
            }
        }*/
		$vfi2 = $this->verify2();
        return $this->render('main',[
            'model'   => $users,
            'neirong' => $neirong,
            'pwd'     => (isset($array[$pwd])?$array[$pwd]:$array[0]),
            'vfi2'    => $vfi2,
        ]);
    }

    /**
     * 退出
     * @return number[]|string[]|NULL[]
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return ['status'=>1,'msg'=>'退出成功','url'=> $this->urlTo('/site/index')];
    }
}
