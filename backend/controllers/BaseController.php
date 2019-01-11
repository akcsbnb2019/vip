<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\Object;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * 后台核心继承控制器
 */
class BaseController extends Controller
{
    /**
     * 公用权限项
     * @var unknown
     */
    public static $group  = null;
    /**
     * 操作日志
     * @var unknown
     */
    public static $logobj = null;
    /**
     * 初始化动作
     * {@inheritDoc}
     * @see \yii\base\Object::init()
     */
    public function init()
    {
        /* 检查是否登录 */
        if(!Yii::$app->session->get("__id")){
            if(!in_array($this->id, ['site'])){
                $this->goBack($this->urlTo('/site/login'));
            }
        }else{
            define('UID',Yii::$app->session->get("__id"));
            /* 登录状态时保持sess信息存在 */
            if(!Yii::$app->session->get("uname")){
                $form = new \common\models\VipLogin();
                $form->setSession();
            }
            define('GROUPID', Yii::$app->session->get("gid"));
        }
        
        /* 控制器ID */
        define('THISID', $this->id);
        
        /* 启用json 返回值 */
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            define('AJAX', true);
        }
        defined('AJAX') or define('AJAX', false);
        $this->getLog();
        register_shutdown_function(array(&$this, 'adminLog'));
    }
    
    /**
     * @继承doc
     */
    public function behaviors()
    {
        $ret = $only = $kom = [];
        $login = [ 'login', 'error', 'main','captchatest','lajax'];
        $index = ['logouts'];
        /* 验证登录属性  */
        if(defined('UID')&& !in_array($this->id, ['site'])){
            $this->getAuth();
            $kom  = ['?'];
            $cid  = $this->id;
            $aid  = $this->action->id;
    
            if(isset(self::$group->nav->$cid->$aid)){
                $login = $index = $only = [self::$group->nav->$cid->$aid];
                /* 格式化标签 */
                yii::$app->params['seo']['title'] = $aid.' - '.$cid.' - ';
            }
            if($this->id == 'index'){
                self::$group->nav = (object)[];
            }else{
                self::$group = null;
            }
            if($this->id == 'index' || UID == '12'){
                /* 编程阶段使用*/
                $login = $index = $only = [$this->action->id];
                /* 编程阶段使用 end*/
            }
            
        }else{
            if(in_array($this->id, ['site'])){
                $login[] = 'index';
            }else{
                $index[] = 'index';
            }
            $only  = array_merge($login,$index);
        }
    
        $ret['access'] = [
            'class' => AccessControl::className(),
            'only'  => $only,
            'rules' => [
                ['actions' => $login,'allow' => true, 'roles' => $kom],
                ['actions' => $index,'allow' => true, 'roles' => ['@']],
            ],
            'denyCallback' => function ($rule, $action) {/*无权限访问处理*/
                if(Yii::$app->request->isAjax){
                    echo json_encode(['status'=>0,'cod'=>0,'msg'=>'无权访问']);
                }else{
                    return Yii::$app->getResponse()->redirect($this->urlTo('/site/'.(defined('UID') ? ($this->id == 'index'?'mains':'main') : 'login')));
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
    public function verify()
    {
        
        if(Yii::$app->session->get("verified")){
            return true;
        }
        /* 验证密码*/
        if(Yii::$app->request->isAjax){
            
            $model = \common\models\User::findIdentity(Yii::$app->session->get("__id"));
            if($model->pwd2 == md5(Yii::$app->request->post('password'))){
                Yii::$app->session->set('verified',1);
                echo json_encode(['status'=>1,'msg'=>'验证成功','url'=>$this->urlTo('/'.$this->id.'/'.$this->action->id)]);
            }else{
                echo json_encode(['status'=>0,'msg'=>'验证失败','url'=>'']);
            }
        }else{
            echo $this->render('/layouts/verify');
        }
        
    }
    
    /**
     * 提示页
     * @param unknown $val
     * @param number $type
     */
    public function msg($val,$type = 0)
    {
        
        $this->layout = 'main1';
        echo $this->render('/layouts/msg',[
            'msg' => $val,
            'model' => $type,
        ]);
    }
    
    /**
     * 过滤敏感字符
     * @param unknown $val
     * @param number $type
     */
    public function strSafety($val,$type = 0)
    {
    
        if($type == 0){
            return str_replace([
                'and',' ','or','1','true',
                "'",',','`','=','"','<','>'
            ], '', htmlspecialchars($val));
        }
        
        return null;
    }
    
    /**
     * 获取对应角色列表
     * @return boolean
     */
    public function getAuth()
    {
        /* 定义工作对象 */
        self::$group = (object)[ 'tree'=>(object)[], 'auth'=>(object)[], 'nav'=>(object)[]];
        
        /* 获取权限列表 */
        $auth = Yii::$app->redis->get('bac-auth'.GROUPID);
        if(!$auth){
            $groupobj = new \backend\models\VipGroup();
            $groups = $groupobj->findOne(['id'=>GROUPID]);
            if($groups){
                $auth = $groups['auth'];
                Yii::$app->redis->setex('bac-auth'.GROUPID,3600,$auth);
            }
        }
        self::$group->auth = json_decode($auth);
        /* 获取权限URl列表 */
        $nav = Yii::$app->redis->get('bac-hav'.GROUPID);
        if(!$nav || isset($_GET['svs'])){
            if(!empty(self::$group->auth)){
                foreach (self::$group->auth as $key=>$val){
                    $kns = explode('_', $key);
                    if(isset($kns[0])&&!empty($kns[0])){
                        $arar = [];
                        foreach ($val as $k2 => $val){
                            $kn2 = explode('_', $k2);
                            if(isset($kn2[0])&&!empty($kn2[0])){
                                $arar[$kn2[0]] = $kn2[0];
                            }
                        }
                        $ks = $kns[0];
                        self::$group->nav->$ks = (object)$arar;
                    }
                }
                Yii::$app->redis->setex('bac-hav'.GROUPID,3600,json_encode(self::$group->nav));
            }
        }else{
            self::$group->nav = json_decode($nav);
        }
        return true;
    }
    
    /**
     * 验证特定数据类型是否正常，数据异常时直接停止
     * 主要针对主键数据值 或 key属性设置为int类型的数据值
     * 数据值控制在10位以内，若数据值超过设定值请改用字符串类型，若主键记录值超过十亿级需要重新设定该验证方式
     * @param number $ints
     */
    public function intset($ints = 0){
        $int = intval($ints);
        if($int == 0 || $int != $ints || strlen($ints) > 10){
            if(Yii::$app->request->isAjax){
                exit(json_encode(['s'=>0,'m'=>'异常，非法请求','url'=>'']));
            }else{
                exit('<script type="text/javascript"> location.href = "'.$this->urlTo('/site/mains').'"; </script>');
            }
            return false;
        }
        
        return $int;
    }
    
    /**
     * 检查为空
     * @param unknown $val
     */
    public function isNull($val){
        if((empty($val) && intval($val) != 0) || $val == '.'){
            return false;
        }
        return true;
    }
    
    /**
     * 日志记录
     */
    public function adminLog(){
        if(self::$logobj['desc'] == '' || in_array($this->action->id, ['captchatest'])){
            return false;
        }
        $types = [
            'admin'     => 1,
            'authgroup' => 2,
            'authmenu'  => 3,
            'data'      => 4,
            'index'     => 5,
            'info'      => 6,
            'integral'  => 7,
            'news'      => 8,
            'performance' => 9,
            'proxy'     => 10,
            'public'    => 11,
            'recharge'  => 12,
            'report'    => 13,
            'shares'    => 14,
            'sharesgo'  => 15,
            'shipping'  => 16,
            'site'      => 17,
            'system'    => 18,
            'transfer'  => 19,
            'uprid'     => 20,
            'user'      => 21,
            'withdraw'  => 22,
        ];
        if(isset($types[$this->id])){
            self::$logobj['type'] = $types[$this->id];
        }
        //$this->id
        if(empty(self::$logobj)){
            $this->getLog();
        }
        foreach (self::$logobj as $key => $val){
            if(strlen($val) > 254){
                $dinfo[$key] = substr($val,0,254);
            }
        }
        if(!Yii::$app->db->createCommand()->Insert('zm_vadmin_log', self::$logobj)->execute()){
            return false;
        }
    }
    /**
     * 初始化日志数组
     */
    public function getLog(){
        $post = Yii::$app->request->post();
        if(isset($post['_csrf-backend'])){
            unset($post['_csrf-backend']);
        }
        $adminid = Yii::$app->session->get("__id");
        if(empty($adminid)){
            $adminid = 0;
        }
        if(isset($post['VipLogin'])){
            if(isset($post['VipLogin']['password'])){
                unset($post['VipLogin']['password']);
            }
        }
        self::$logobj = [
            'adminid' => $adminid,
            'userid'  => 0,
            'addtime' => date('Y-m-d H:i:s',time()),
            'loginip' => Yii::$app->request->userIP,
            'post'    => $this->getStrs($post),
            'ref'     => str_replace(Yii::$app->request->getHostInfo(), '', Yii::$app->request->referrer),
            'url'     => Yii::$app->request->url,
            'type'    => 0,
            'desc'    => '',
        ];
    }
    public function getStrs($data) {
        if(count($data) == 0){
            return '';
        }
        foreach ($data as $key => $val){
            if(is_array($val)){
                foreach ($val as $k => $v){
                    if(is_array($v)){
                        $data[$key][$k] = '';
                    }else if(empty($v)){
                        $data[$key][$k] = 0;
                    }else if(strlen($v)>15){
                        $data[$key][$k] = '';//substr($v,0,9);
                    }else if(in_array($k, ['centont','editorValue'])){
                        $data[$key][$k] = '';
                    }
                }
            }else if(in_array($key, ['centont','editorValue'])){
                $data[$key] = '';
            }
        }
        return json_encode($data);
    }
}
