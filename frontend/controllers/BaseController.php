<?php
namespace frontend\controllers;

use common\models\User;
use frontend\models\Uso;
use frontend\models\ZmPosition;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * 基础控制器
 */
class BaseController extends Controller
{
    public static $vfi = null;
    /**
     * Initializes the object.
     * {@inheritDoc}
     * @see \yii\base\Object::init()
     */
    public function init()
    {
        /* 检查是否登录 */
        //达到指定时间清空session --- 弃用
        //Yii::$app->session->setCookieParams(['lifetime'=>3600]);
        if(!Yii::$app->session->get("__id") ){
            if(!in_array($this->id, ['site'])){
                $this->goBack($this->urlTo('/site'));
            }
        }else{
            define('UID',Yii::$app->session->get("__id"));
            /* 登录状态时保持sess信息存在 */
            if(!Yii::$app->session->get("loginname")){
                $form = new \common\models\LoginForm();
                $form->setSession();
            }
        }
        
        /* 控制器ID */
        define('THISID', $this->id);
        
        /* 手机识别 */
        if($this->isMobile((isset($_GET['ism'])?false:true))){
            yii::$app->setBasePath(__DIR__ . '/../mobile');
        }else if(Yii::$app->session->get('is-ie')){
            //pr('ie9/ie8/ie7/ie6暂停使用');
            yii::$app->setBasePath(__DIR__ . '/../vold');
        }else{
            //yii::$app->setBasePath(__DIR__ . '/../vold');
        }
        
        /* 启用json 返回值 */
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $this->layout = 'kong';
        }
        
        if(isset($_GET['ss'])){
            Yii::$app->session->set('mobile',false);
        }
    }
    
    /**
     * @继承doc
     * {@inheritDoc}
     * @see \yii\base\Component::behaviors()
     */
    public function behaviors()
    {
        $ret = $only = $kom = [];
        $login = [ 'indexs', 'login', 'error', 'main','captchatest'];
        $index = ['logout'];
        /* 验证登录属性  */
        if(defined('UID') || in_array($this->id, ['site'])){
            $login = $index = $only = [$this->action->id];
        }else{
            $only  = array_merge($login,$index);
            $only[] = $this->action->id;
        }
    
        $ret['access'] = [
            'class' => AccessControl::className(),
            'only'  => [$this->action->id],
            'rules' => [
                ['actions' => $login,'allow' => true, 'roles' => $kom],
                ['actions' => $index,'allow' => true, 'roles' => ['@']],
            ],
            'denyCallback' => function ($rule, $action) {/*无权限访问处理*/
                if(Yii::$app->request->isAjax){
                    echo json_encode(['status'=>0,'cod'=>0,'msg'=>'无权访问']);
                }else{
                    return Yii::$app->getResponse()->redirect($this->urlTo('/site/'.(defined('UID') ? 'main' : 'login')));
                }
            }
        ];
    
        $ret['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
            ],
        ];
    
        return $ret;
    }

    /**
     * @继承doc
     * {@inheritDoc}
     * @see \yii\base\Controller::actions()
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 手机识别
     */
    public function isMobile($type = true)
    {
        /*if(Yii::$app->session->get('mobile') && $type){
            return true;
        }*/
        
        $is = false;
        if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT']))||((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))||isset($_SERVER['HTTP_X_WAP_PROFILE'])||isset($_SERVER['HTTP_PROFILE'])){
            $is = true;
        }else{
            $mobile_agents = [ 'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
                'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','oper','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
                'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-'
            ];
            if(in_array(strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4)), $mobile_agents)||strpos(strtolower(isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : ''), 'operamini') !== false){
                $is = true;
            }
        }
        if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false){/* 如果用户在Windows上，则进行最终检查以重置所有内容 */
            $is = false;
        }
        if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false){/* 但WP7也是Windows，具有稍微不同的特性 */
            $is = true;
        }
        /* 设置session */
       /* if($is){
            Yii::$app->session->set('mobile',true);
        }*/
        return $is;
    }

    /**
     * 生成系统格式url
     * @param unknown $name url
     * @param string $type 类型
     * @param unknown $data 附加参数
     */
    public function urlTo($name, $type = 'to', $data = null)
    {
        return Url::$type($name);
    }
    
    /**
     * 验证二级密码
     * @return boolean
     */
    public function verify(){
        
        if(Yii::$app->session->get("verified")){
            return true;
        }
        $user = Uso::findOne(['id'=>UID]);
        if(empty($user['pwd2'])){
            return $this->msg('请完善二级密码后重试!',['icon'=>0,'url'=>'/user/pass?type=2']);
        }
        /* 验证密码*/
        if(Yii::$app->request->isAjax){
            
            if(!Yii::$app->request->post('password')){
                self::$vfi = ['status'=>6,'msg'=>'二级密码失效，请重新打开页面','url'=>$this->urlTo('/')];
                return false;
            }
            
            $model = \common\models\User::findIdentity(Yii::$app->session->get("__id"));
            if($model->pwd2 == md5(Yii::$app->request->post('password'))){
                Yii::$app->session->set('verified',1);
                $arr = array();
                $type = '';
                if(!empty($this->actionParams)){
	                $arr = array_keys($this->actionParams);
	                $type = '?'.$arr[0]."=".$this->actionParams[$arr[0]];
                }
                self::$vfi = ['status'=>6,'msg'=>'验证成功','url'=>$this->urlTo('/'.$this->id.'/'.$this->action->id."/".$type)];
            }else{
                self::$vfi = ['status'=>2,'msg'=>'二级密码验证失败'];
            }
        }else{
            self::$vfi = $this->render('/layouts/verify');
        }
        return false;
    }
	/**
	 * 验证手机验证码
	 * @return boolean
	 */
	public function verisms(){
		if(Yii::$app->session->get("verified1")){
			Yii::$app->session->set('verified1',0);
			return true;
		}
		$user = Uso::findOne(['id'=>UID]);
		if(empty($user['tel'])){
			return $this->msg('请完善信息后重试!',['icon'=>0,'url'=>'/user/edit']);
		}
		/* 验证短信*/
		if(Yii::$app->request->isAjax){
			$mobile_code = Yii::$app->request->post('mobile_code');
			/*if(!$mobile_code){
				self::$vfi = ['status'=>6,'msg'=>'验证短信失效，请重新打开页面','url'=>$this->urlTo('/')];
				return false;
			}*/
			if(empty($mobile_code)){
				self::$vfi = ['status'=>2,'msg'=>'验证码不能为空！'];
			}else if($mobile_code!=Yii::$app->session->get("mobile_code")){
				self::$vfi = ['status'=>2,'msg'=>'验证码不正确,请重新输入！'];
			}else{
				$arr = array();
				$type = '';
				if(!empty($this->actionParams)){
					$arr = array_keys($this->actionParams);
					$type = '?'.$arr[0]."=".$this->actionParams[$arr[0]];
				}
				Yii::$app->session->set('verified1',1);
				self::$vfi = ['status'=>6,'msg'=>'验证成功','url'=>$this->urlTo('/user/stockcert')];
			}
			
			/*$model = \common\models\User::findIdentity(Yii::$app->session->get("__id"));
			if($model->pwd2 == md5(Yii::$app->request->post('password'))){
				Yii::$app->session->set('verified',1);
				$arr = array();
				$type = '';
				if(!empty($this->actionParams)){
					$arr = array_keys($this->actionParams);
					$type = '?'.$arr[0]."=".$this->actionParams[$arr[0]];
				}
				self::$vfi = ['status'=>6,'msg'=>'验证成功','url'=>$this->urlTo('/'.$this->id.'/'.$this->action->id."/".$type)];
			}else{
				self::$vfi = ['status'=>2,'msg'=>'二级密码验证失败'];
			}*/
		}else{
			self::$vfi = $this->render('/layouts/verisms',[
					'model' => $user
				]);
		}
		return false;
	}

    /**
     * 完善昵称
     * @return boolean
     */
    public function verify_truename(){

        $user = Uso::findOne(['id'=>UID]);
        if(!empty($user['truename'])){
            return true;
        }
        /* 验证密码*/
        if(Yii::$app->request->isAjax){

            if(!Yii::$app->request->post('truename')){
                self::$vfi = ['status'=>6,'msg'=>'昵称完善失败,请重新打开页面','url'=>$this->urlTo('/')];
                return false;
            }
//            $user->truename = Yii::$app->request->post('truename');

            if($user->updateAll(['truename'=>Yii::$app->request->post('truename')],['loginname'=>$user['loginname']])){
//                Yii::$app->session->set('verified',1);
                self::$vfi = ['status'=>6,'msg'=>'完善成功','url'=>$this->urlTo('/'.$this->id.'/'.$this->action->id)];
            }else{
                self::$vfi = ['status'=>2,'msg'=>'完善失败'];
            }
        }else{
            self::$vfi = $this->render('/layouts/truename');
        }
        return false;
    }

    /**
     * 完善昵称
     * @return boolean
     */
    public function verify_baodan(){
        $user = Uso::findOne(['id'=>UID]);
        if(!empty($user['bdr']) ){
            $baodanuser = Uso::findOne(['loginname'=>$user['bdr']]);
            if($baodanuser['bdl']!=0){
	            if(!empty($user['baodan']) ){
		            if($user->updateAll(['baodan'=>""],['loginname'=>$user['loginname']])){
			            return true;
		            }
	            }
                return true;
            }
        }
        if(!empty($user['baodan']) ){
            $baodanuser = Uso::findOne(['loginname'=>$user['baodan']]);
            if($baodanuser['dllevel']==1){
	            $rpath = explode(",",$user['rpath']);
	            if(in_array($baodanuser['id'],$rpath)){
		            if(!empty($user['bdr']) ) {
			            if ($user->updateAll(['bdr' => ""], ['loginname' => $user['loginname']])) {
				            return true;
			            }
		            }
		            return true;
	            }
            }
        }
        $type = empty(Yii::$app->request->get('type'))?0:Yii::$app->request->get('type');
        if(Yii::$app->request->isAjax){
            if(!Yii::$app->request->post('baodan') && Yii::$app->request->post('types')==0){
                self::$vfi = ['status'=>6,'msg'=>'代理商完善失败,请重新打开页面','url'=>$this->urlTo('?type=0')];
                return false;
            }
	        if(!Yii::$app->request->post('baodan') && Yii::$app->request->post('types')==1){
		        self::$vfi = ['status'=>6,'msg'=>'服务中心完善失败,请重新打开页面','url'=>$this->urlTo('?type=1')];
		        return false;
	        }
            $user_bd = Uso::findOne(['loginname'=>Yii::$app->request->post('baodan')]);
            $rpath = explode(",",$user['rpath']);
            if(in_array($user_bd['id'],$rpath)){
            	if(Yii::$app->request->post('types')==0 && $user_bd['dllevel']==1){
		            if($user->updateAll(['baodan'=>Yii::$app->request->post('baodan')],['loginname'=>$user['loginname']])){
			            self::$vfi = ['status'=>6,'msg'=>'完善成功','url'=>$this->urlTo('/'.$this->id.'/'.$this->action->id)];
		            }else{
			            self::$vfi = ['status'=>2,'msg'=>'完善失败'];
			            return false;
		            }
	            }else if(Yii::$app->request->post('types')==1 && $user_bd['bdl']==1){
		            if($user->updateAll(['bdr'=>Yii::$app->request->post('baodan')],['loginname'=>$user['loginname']])){
			            self::$vfi = ['status'=>6,'msg'=>'完善成功','url'=>$this->urlTo('/'.$this->id.'/'.$this->action->id)];
		            }else{
			            self::$vfi = ['status'=>2,'msg'=>'完善失败'];
			            return false;
		            }
	            } else {
		            self::$vfi = ['status'=>2,'msg'=>'请核对是否是代理商或服务中心'];
		            return false;
		
	            }
             
            }else{
                self::$vfi = ['status'=>2,'msg'=>'请核对是否是邀请团队中的代理商或服务中心!'];
                return false;
            }
//            $user->truename = Yii::$app->request->post('truename');


        }else{
        	if($type==0){
		        self::$vfi = $this->render('/layouts/daili');
	        }else{
		        self::$vfi = $this->render('/layouts/baodan');
	        }
        }
        return false;
    }

    /**
     * 二级密码
     * @return boolean
     */
    public function verify2(){
		$user = Uso::findOne(['id'=>UID]);
		if(!empty($user['pwd2'])){
			return true;
		}
		return false;
    }
	
    
    /**
     * 提示页
     * @param unknown $val
     * @param number $type
     */
    public function msg($val,$type = 0){
        
        $this->layout = 'main1';
        echo $this->render('/layouts/msg',[
            'msg' => $val,
            'model' => $type,
        ]);
    }

    /**
     * 保留小数 去0
     * @param unknown $num
     * @param number $len
     */
    public function decpoint($num,$len = 2){
        if(floor($num) == $num){
            return floor($num);
        }
        if($len == 3){
            $num = sprintf("%.3f",substr(sprintf("%.5f", $num), 0, -2));
        }else{
            $num = sprintf("%.2f",substr(sprintf("%.4f", $num), 0, -2));
        }
        if($len == 3){
            if($num == substr($num,0,-2)){
                return substr($num,0,-2);
            }
        }
        if($num == substr($num,0,-1)){
            return substr($num,0,-1);
        }
        return $num;
    }
    public function ismenu(){
	    $users = new User();
	    $position = new ZmPosition();
	    $row = $users->findOne(['id'=>UID]);
	    $position_info = $position->findOne(['users_id'=>UID]);
	    $p_row = $users->findOne(['pid'=>$row['loginname'],'area'=>1]);
	    $jihuotime = "2018-08-29 00:00:00";
	    $where=array(
		    'isbd'  =>  0,
		    'isup'  =>  0,
		    'isup2'  =>  0,
		    'isup3'  =>  0,
		    'isdw'  =>  0,
		    'ispy'  =>  0,
		    'isfl'  =>  0,
		    'isjb'  =>  0,
		    'iswcs'  =>  0,
	    );
	    if((empty($row['bdl'])||$row['bdl']==0) && ($row['position']<= 11&&$row['position']>0)){
		    $where['isbd'] = 1;
	    }
		if($row['standardlevel']==0 && $position_info['pan']==1){
			$where['ispy'] = 1;
			
		}
	    if($row['position']>0){
		    $where['isjb'] = $row['position'];
	    }
		if($row['yuanshigu']>0){
			$where['isfl'] = 1;
		}
	    $uinfos = $users->findOne(['id'=>UID]);
	    if($uinfos->jihuotime>$jihuotime){
		    $jihuotime = $uinfos->jihuotime;
	    }
	    $max_time = strtotime($jihuotime)+(86400*90);
	    if($row['standardlevel']<3&&$row['standardlevel']>0&&time()<$max_time){
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
	    }
	    if($row['bd']==1&&$row['dllevel']==2){
		    $where['iswcs'] = 1;
	    }
	    return $where;
    }
}
